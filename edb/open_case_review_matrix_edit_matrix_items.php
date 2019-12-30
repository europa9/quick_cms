<?php 
/**
*
* File: edb/open_case_review_matrix_edit_matrix_items.php
* Version 1.0
* Date 16:06 07.10.2019
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
include("$root/_admin/_translations/site/$l/edb/ts_open_case_overview.php");


/*- Tables ---------------------------------------------------------------------------- */
// (Should not be used here) $t_edb_review_matrix_titles = $mysqlPrefixSav . "edb_review_matrix_titles";
// (Should not be used here) $t_edb_review_matrix_fields = $mysqlPrefixSav . "edb_review_matrix_fields";

$t_edb_case_index_review_notes			= $mysqlPrefixSav . "edb_case_index_review_notes";
$t_edb_case_index_review_matrix_titles		= $mysqlPrefixSav . "edb_case_index_review_matrix_titles";
$t_edb_case_index_review_matrix_fields		= $mysqlPrefixSav . "edb_case_index_review_matrix_fields";
$t_edb_case_index_review_matrix_values		= $mysqlPrefixSav . "edb_case_index_review_matrix_values";
$t_edb_case_index_review_matrix_items		= $mysqlPrefixSav . "edb_case_index_review_matrix_items";


/*- Variables -------------------------------------------------------------------------- */
$tabindex = 0;
if(isset($_GET['case_id'])) {
	$case_id = $_GET['case_id'];
	$case_id = strip_tags(stripslashes($case_id));
}
else{
	$case_id = "";
}
$case_id_mysql = quote_smart($link, $case_id);

if(isset($_GET['matrix_item_id'])) {
	$matrix_item_id = $_GET['matrix_item_id'];
	$matrix_item_id = strip_tags(stripslashes($matrix_item_id));
}
else{
	$matrix_item_id = "";
}
if(isset($_GET['field_id'])) {
	$field_id = $_GET['field_id'];
	$field_id = strip_tags(stripslashes($field_id));
}
else{
	$field_id = "";
}
if(isset($_GET['order_by'])) {
	$order_by = $_GET['order_by'];
	$order_by = strip_tags(stripslashes($order_by));
}
else{
	$order_by = "";
}
if(isset($_GET['order_method'])) {
	$order_method = $_GET['order_method'];
	$order_method = strip_tags(stripslashes($order_method));
	if($order_method != "asc" && $order_method != "desc"){
		echo"Wrong order method";
		die;
	}
}
else{
	$order_method = "asc";
}





/*- Content ---------------------------------------------------------------------------------- */
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){

	// Find case 
	$query = "SELECT case_id, case_number, case_title, case_title_clean, case_suspect_in_custody, case_code_id, case_code_title, case_status_id, case_status_title, case_priority_id, case_priority_title, case_district_id, case_district_title, case_station_id, case_station_title, case_is_screened, case_assigned_to_datetime, case_assigned_to_time, case_assigned_to_date_saying, case_assigned_to_date_ddmmyy, case_assigned_to_user_id, case_assigned_to_user_name, case_assigned_to_user_alias, case_assigned_to_user_email, case_assigned_to_user_image_path, case_assigned_to_user_image_file, case_assigned_to_user_image_thumb_40, case_assigned_to_user_image_thumb_50, case_assigned_to_user_first_name, case_assigned_to_user_middle_name, case_assigned_to_user_last_name, case_created_datetime, case_created_time, case_created_date_saying, case_created_date_ddmmyy, case_created_user_id, case_created_user_name, case_created_user_alias, case_created_user_email, case_created_user_image_path, case_created_user_image_file, case_created_user_image_thumb_40, case_created_user_image_thumb_50, case_created_user_first_name, case_created_user_middle_name, case_created_user_last_name, case_detective_user_id, case_detective_user_job_title, case_detective_user_first_name, case_detective_user_middle_name, case_detective_user_last_name, case_detective_user_name, case_detective_user_alias, case_detective_user_email, case_detective_email_alerts, case_detective_user_image_path, case_detective_user_image_file, case_detective_user_image_thumb_40, case_detective_user_image_thumb_50, case_updated_datetime, case_updated_time, case_updated_date_saying, case_updated_date_ddmmyy, case_updated_user_id, case_updated_user_name, case_updated_user_alias, case_updated_user_email, case_updated_user_image_path, case_updated_user_image_file, case_updated_user_image_thumb_40, case_updated_user_image_thumb_50, case_updated_user_first_name, case_updated_user_middle_name, case_updated_user_last_name, case_is_closed, case_closed_datetime, case_closed_time, case_closed_date_saying, case_closed_date_ddmmyy, case_time_from_created_to_close FROM $t_edb_case_index WHERE case_id=$case_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_case_id, $get_current_case_number, $get_current_case_title, $get_current_case_title_clean, $get_current_case_suspect_in_custody, $get_current_case_code_id, $get_current_case_code_title, $get_current_case_status_id, $get_current_case_status_title, $get_current_case_priority_id, $get_current_case_priority_title, $get_current_case_district_id, $get_current_case_district_title, $get_current_case_station_id, $get_current_case_station_title, $get_current_case_is_screened, $get_current_case_assigned_to_datetime, $get_current_case_assigned_to_time, $get_current_case_assigned_to_date_saying, $get_current_case_assigned_to_date_ddmmyy, $get_current_case_assigned_to_user_id, $get_current_case_assigned_to_user_name, $get_current_case_assigned_to_user_alias, $get_current_case_assigned_to_user_email, $get_current_case_assigned_to_user_image_path, $get_current_case_assigned_to_user_image_file, $get_current_case_assigned_to_user_image_thumb_40, $get_current_case_assigned_to_user_image_thumb_50, $get_current_case_assigned_to_user_first_name, $get_current_case_assigned_to_user_middle_name, $get_current_case_assigned_to_user_last_name, $get_current_case_created_datetime, $get_current_case_created_time, $get_current_case_created_date_saying, $get_current_case_created_date_ddmmyy, $get_current_case_created_user_id, $get_current_case_created_user_name, $get_current_case_created_user_alias, $get_current_case_created_user_email, $get_current_case_created_user_image_path, $get_current_case_created_user_image_file, $get_current_case_created_user_image_thumb_40, $get_current_case_created_user_image_thumb_50, $get_current_case_created_user_first_name, $get_current_case_created_user_middle_name, $get_current_case_created_user_last_name, $get_current_case_detective_user_id, $get_current_case_detective_user_job_title, $get_current_case_detective_user_first_name, $get_current_case_detective_user_middle_name, $get_current_case_detective_user_last_name, $get_current_case_detective_user_name, $get_current_case_detective_user_alias, $get_current_case_detective_user_email, $get_current_case_detective_email_alerts, $get_current_case_detective_user_image_path, $get_current_case_detective_user_image_file, $get_current_case_detective_user_image_thumb_40, $get_current_case_detective_user_image_thumb_50, $get_current_case_updated_datetime, $get_current_case_updated_time, $get_current_case_updated_date_saying, $get_current_case_updated_date_ddmmyy, $get_current_case_updated_user_id, $get_current_case_updated_user_name, $get_current_case_updated_user_alias, $get_current_case_updated_user_email, $get_current_case_updated_user_image_path, $get_current_case_updated_user_image_file, $get_current_case_updated_user_image_thumb_40, $get_current_case_updated_user_image_thumb_50, $get_current_case_updated_user_first_name, $get_current_case_updated_user_middle_name, $get_current_case_updated_user_last_name, $get_current_case_is_closed, $get_current_case_closed_datetime, $get_current_case_closed_time, $get_current_case_closed_date_saying, $get_current_case_closed_date_ddmmyy, $get_current_case_time_from_created_to_close) = $row;
	

	if($get_current_case_id == ""){
		echo"<h1>Server error 404</h1><p>Case not found</p>";
		die;
	}
	else{
		/*- Headers ---------------------------------------------------------------------------------- */
		$website_title = "$l_edb - $get_current_case_district_title - $get_current_case_station_title - $get_current_case_number - $l_review_matrix";
		if(file_exists("./favicon.ico")){ $root = "."; }
		elseif(file_exists("../favicon.ico")){ $root = ".."; }
		elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
		elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
		include("$root/_webdesign/header.php");

		// Me
		$my_user_id = $_SESSION['user_id'];
		$my_user_id = output_html($my_user_id);
		$my_user_id_mysql = quote_smart($link, $my_user_id);


		// Check that I am member of this station
		$query = "SELECT station_member_id, station_member_station_id, station_member_station_title, station_member_district_id, station_member_district_title, station_member_user_id, station_member_rank, station_member_user_name, station_member_user_alias, station_member_first_name, station_member_middle_name, station_member_last_name, station_member_user_email, station_member_user_image_path, station_member_user_image_file, station_member_user_image_thumb_40, station_member_user_image_thumb_50, station_member_user_image_thumb_60, station_member_user_image_thumb_200, station_member_user_position, station_member_user_department, station_member_user_location, station_member_user_about, station_member_added_datetime, station_member_added_date_saying, station_member_added_by_user_id, station_member_added_by_user_name, station_member_added_by_user_alias, station_member_added_by_user_image FROM $t_edb_stations_members WHERE station_member_user_id=$my_user_id_mysql AND station_member_station_id=$get_current_case_station_id";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_my_station_member_id, $get_my_station_member_station_id, $get_my_station_member_station_title, $get_my_station_member_district_id, $get_my_station_member_district_title, $get_my_station_member_user_id, $get_my_station_member_rank, $get_my_station_member_user_name, $get_my_station_member_user_alias, $get_my_station_member_first_name, $get_my_station_member_middle_name, $get_my_station_member_last_name, $get_my_station_member_user_email, $get_my_station_member_user_image_path, $get_my_station_member_user_image_file, $get_my_station_member_user_image_thumb_40, $get_my_station_member_user_image_thumb_50, $get_my_station_member_user_image_thumb_60, $get_my_station_member_user_image_thumb_200, $get_my_station_member_user_position, $get_my_station_member_user_department, $get_my_station_member_user_location, $get_my_station_member_user_about, $get_my_station_member_added_datetime, $get_my_station_member_added_date_saying, $get_my_station_member_added_by_user_id, $get_my_station_member_added_by_user_name, $get_my_station_member_added_by_user_alias, $get_my_station_member_added_by_user_image) = $row;

		if($get_my_station_member_id == ""){
			echo"
			<h1><img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" /> Please apply for access to this station..</h1>
			<meta http-equiv=\"refresh\" content=\"3;url=districts.php?action=apply_for_membership_to_station&amp;station_id=$get_current_case_station_id&amp;l=$l\">
			";
		} // access to station denied
		else{
			if($process != "1"){
				echo"
				<!-- Headline + Select cases board -->
					<h1>$get_current_case_number</h1>
				<!-- Headline + Select cases board -->

				<!-- Where am I? -->
					<p style=\"padding-top:0;margin-top:0;\"><b>$l_you_are_here:</b><br />
					<a href=\"index.php?l=$l\">$l_edb</a>
					&gt;
					<a href=\"cases_board_1_view_district.php?district_id=$get_current_case_district_id&amp;l=$l\">$get_current_case_district_title</a>
					&gt;
					<a href=\"cases_board_2_view_station.php?district_id=$get_current_case_district_id&amp;station_id=$get_current_case_station_id&amp;l=$l\">$get_current_case_station_title</a>
					&gt;
					<a href=\"open_case_overview.php?case_id=$get_current_case_id&amp;l=$l\">$get_current_case_number</a>
					&gt;
					<a href=\"open_case_review_matrix.php?case_id=$get_current_case_id&amp;l=$l\">$l_review_matrix</a>
					&gt;
					<a href=\"open_case_review_matrix_edit_matrix_items.php?case_id=$get_current_case_id&amp;l=$l\">$l_edit_review_matrix_items</a>
					</p>
					<div style=\"height: 10px;\"></div>
				<!-- //Where am I? -->


				<!-- Case navigation -->
					";
					include("open_case_menu.php");
					echo"
				<!-- //Case navigation -->
				";
			} // process != 1

				
			if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor" OR $get_my_station_member_rank == "editor_limited"){
				if($action == ""){
					if($process == "1"){
						$query = "SELECT matrix_item_id, matrix_item_case_id, matrix_item_item_id, matrix_item_record_id, matrix_item_record_seized_year, matrix_item_record_seized_journal, matrix_item_record_seized_district_number, matrix_item_numeric_serial_number, matrix_item_title FROM $t_edb_case_index_review_matrix_items WHERE matrix_item_case_id=$get_current_case_id ORDER BY matrix_item_record_seized_year, matrix_item_record_seized_journal, matrix_item_record_seized_district_number, matrix_item_numeric_serial_number ASC";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_matrix_item_id, $get_matrix_item_case_id, $get_matrix_item_item_id, $get_matrix_item_record_id, $get_matrix_item_record_seized_year, $get_matrix_item_record_seized_journal, $get_matrix_item_record_seized_district_number, $get_matrix_item_numeric_serial_number, $get_matrix_item_title) = $row;
			

							$inp_year = $_POST["inp_year_$get_matrix_item_id"];
							$inp_year = output_html($inp_year);
							$inp_year_mysql = quote_smart($link, $inp_year);			

							$inp_journal = $_POST["inp_journal_$get_matrix_item_id"];
							$inp_journal = output_html($inp_journal);
							$inp_journal_mysql = quote_smart($link, $inp_journal);			

							$inp_district_number = $_POST["inp_district_number_$get_matrix_item_id"];
							$inp_district_number = output_html($inp_district_number);
							$inp_district_number_mysql = quote_smart($link, $inp_district_number);			

							$inp_number = $_POST["inp_number_$get_matrix_item_id"];
							$inp_number = output_html($inp_number);
							$inp_number_mysql = quote_smart($link, $inp_number);			

							$inp_title = $_POST["inp_title_$get_matrix_item_id"];
							$inp_title = output_html($inp_title);
							$inp_title_mysql = quote_smart($link, $inp_title);
							
							$inp_parent_matrix_item_id = $_POST["inp_parent_matrix_item_id_$get_matrix_item_id"];
							$inp_parent_matrix_item_id = output_html($inp_parent_matrix_item_id);
							$inp_parent_matrix_item_id_mysql = quote_smart($link, $inp_parent_matrix_item_id);

							// Update
							$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_review_matrix_items SET 
													matrix_item_record_seized_year=$inp_year_mysql, 
													matrix_item_record_seized_journal=$inp_journal_mysql, 
													matrix_item_record_seized_district_number=$inp_district_number_mysql, 
													matrix_item_numeric_serial_number=$inp_number_mysql, 
													matrix_item_title=$inp_title_mysql, 
													matrix_item_parent_matrix_item_id=$inp_parent_matrix_item_id_mysql 
													WHERE
													matrix_item_id=$get_matrix_item_id");

						}
						$url = "open_case_review_matrix_edit_matrix_items.php?case_id=$case_id&l=$l&ft=success&fm=changes_saved";
						header("Location: $url");
						exit;
					}
					echo"
					<h2>$l_edit_review_matrix_items</h2>
		
					<!-- Feedback -->
						";
						if($ft != ""){
							if($fm == "changes_saved"){
								$fm = "$l_changes_saved";
							}
							else{
								$fm = ucfirst($fm);
								$fm = str_replace("_", " ", $fm);
							}
							echo"<div class=\"$ft\"><span>$fm</span></div>";
						}
						echo"	
					<!-- //Feedback -->


					<!-- Navigation -->
						<p>
						<a href=\"open_case_review_matrix_edit_matrix_items.php?case_id=$get_current_case_id&amp;action=add_item&amp;l=$l\" class=\"btn_default\">$l_add_item</a>
						</p>
						<div style=\"height: 10px;\"></div>
					<!-- //Navigation -->

					<!-- Matrix items -->

					
						<form method=\"post\" action=\"open_case_review_matrix_edit_matrix_items.php?case_id=$get_current_case_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

						<table class=\"hor-zebra\">
						 <thead>
						  <tr>
						   <th scope=\"col\">
							<span><b>$l_id</b></span>
						   </th>
	 					   <th scope=\"col\">
							<span><b>$l_year</b></span>
						   </th>
						   <th scope=\"col\">
							<span><b>$l_journal</b></span>
						   </th>
						   <th scope=\"col\">
							<span><b>$l_district_number</b></span>
						   </th>
						   <th scope=\"col\">
							<span><b>$l_number</b></span>
						   </th>
						   <th scope=\"col\">
							<span><b>$l_title</b></span>
						   </th>
						   <th scope=\"col\">
							<span><b>$l_parent</b></span>
						   </th>
						   <th scope=\"col\">
							<span><b>$l_action</b></span>
						   </th>
						  </tr>
						 </thead>
						";
						$human_counter = 1;
						$query = "SELECT matrix_item_id, matrix_item_case_id, matrix_item_item_id, matrix_item_record_id, matrix_item_record_seized_year, matrix_item_record_seized_journal, matrix_item_record_seized_district_number, matrix_item_numeric_serial_number, matrix_item_title, matrix_item_parent_item_id, matrix_item_parent_matrix_item_id FROM $t_edb_case_index_review_matrix_items WHERE matrix_item_case_id=$get_current_case_id ORDER BY matrix_item_record_seized_year, matrix_item_record_seized_journal, matrix_item_record_seized_district_number, matrix_item_numeric_serial_number ASC";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_matrix_item_id, $get_matrix_item_case_id, $get_matrix_item_item_id, $get_matrix_item_record_id, $get_matrix_item_record_seized_year, $get_matrix_item_record_seized_journal, $get_matrix_item_record_seized_district_number, $get_matrix_item_numeric_serial_number, $get_matrix_item_title, $get_matrix_item_parent_item_id, $get_matrix_item_parent_matrix_item_id) = $row;
			
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
								<span>$get_matrix_item_id</span>
							  </td>
							  <td class=\"$style\">
								<span><input type=\"text\" name=\"inp_year_$get_matrix_item_id\" value=\"$get_matrix_item_record_seized_year\" size=\"5\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" /></span>
							  </td>
							  <td class=\"$style\">
								<span><input type=\"text\" name=\"inp_journal_$get_matrix_item_id\" value=\"$get_matrix_item_record_seized_journal\" size=\"5\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" /></span>
							  </td>
							  <td class=\"$style\">
								<span><input type=\"text\" name=\"inp_district_number_$get_matrix_item_id\" value=\"$get_matrix_item_record_seized_district_number\" size=\"5\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" /></span>
							  </td>
							  <td class=\"$style\">
								<span><input type=\"text\" name=\"inp_number_$get_matrix_item_id\" value=\"$get_matrix_item_numeric_serial_number\" size=\"5\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" /></span>
							  </td>
							  <td class=\"$style\">
								<span><input type=\"text\" name=\"inp_title_$get_matrix_item_id\" value=\"$get_matrix_item_title\" size=\"40\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" /></span>
							  </td>
							  <td class=\"$style\">
								<span>
								<select name=\"inp_parent_matrix_item_id_$get_matrix_item_id\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\">
									<option value=\"0\""; if($get_matrix_item_parent_matrix_item_id == "0"){ echo" selected=\"selected\""; } echo">-</option>\n";


								$query_list = "SELECT matrix_item_id, matrix_item_case_id, matrix_item_item_id, matrix_item_record_id, matrix_item_record_seized_year, matrix_item_record_seized_journal, matrix_item_record_seized_district_number, matrix_item_numeric_serial_number, matrix_item_title FROM $t_edb_case_index_review_matrix_items WHERE matrix_item_case_id=$get_current_case_id AND matrix_item_parent_matrix_item_id=0 ORDER BY matrix_item_record_seized_year, matrix_item_record_seized_journal, matrix_item_record_seized_district_number, matrix_item_numeric_serial_number ASC";
								$result_list = mysqli_query($link, $query_list);
								while($row_list = mysqli_fetch_row($result_list)) {
									list($get_list_matrix_item_id, $get_list_matrix_item_case_id, $get_list_matrix_item_item_id, $get_list_matrix_item_record_id, $get_list_matrix_item_record_seized_year, $get_list_matrix_item_record_seized_journal, $get_list_matrix_item_record_seized_district_number, $get_list_matrix_item_numeric_serial_number, $get_list_matrix_item_title) = $row_list;
									if($get_matrix_item_id != "$get_list_matrix_item_id"){
										echo"									";
										echo"<option value=\"$get_list_matrix_item_id\""; if($get_matrix_item_parent_matrix_item_id == "$get_list_matrix_item_id"){ echo" selected=\"selected\""; } echo">$get_list_matrix_item_record_id/$get_list_matrix_item_record_seized_year-$get_list_matrix_item_record_seized_journal-$get_list_matrix_item_record_seized_district_number $get_list_matrix_item_numeric_serial_number $get_list_matrix_item_title</option>\n";
									}
								}
								echo"
								</select>
								</span>
							  </td>
							  <td class=\"$style\">
								<span>
								<a href=\"open_case_review_matrix_edit_matrix_items.php?case_id=$get_current_case_id&amp;action=delete_matrix_item&amp;matrix_item_id=$get_matrix_item_id&amp;l=$l\">$l_delete</a>
								</span>
							  </td>
							 </tr>";
						} // while
	
						echo"
						 </tbody>
						</table>

						<p><input type=\"submit\" value=\"$l_save_changes\" class=\"btn_default\" />
						</p>
					
						</form>
					<!-- //Matrix items -->
					";
				} // action == ""
				elseif($action == "add_item"){
					if($process == "1"){
						// Dates
						$datetime = date("Y-m-d H:i:s");
						$date = date("Y-m-d");
						$time = time();
						$date_saying = date("j M Y");
						$date_ddmmyy = date("d.m.y");
						$date_ddmmyyyy = date("d.m.Y");
						$date_yyyy = date("Y");
						$date_mm = date("m");
						
						// My user
						$inp_my_user_name_mysql = quote_smart($link, $get_my_station_member_user_name);
						
						// Requester (Requester = me)
						$query = "SELECT user_id, user_email, user_name, user_alias, user_language, user_last_online, user_rank, user_login_tries FROM $t_users WHERE user_name=$get_my_station_member_user_id";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_requester_user_id, $get_requester_user_email, $get_requester_user_name, $get_requester_user_alias, $get_requester_user_language, $get_requester_user_last_online, $get_requester_user_rank, $get_requester_user_login_tries) = $row;

						if($get_requester_user_id == ""){
							$get_requester_user_id = 0;
							$inp_requester_user_image_path = "";
							$get_requester_photo_destination = "";
							$get_requester_photo_thumb_40 = "";
							$get_requester_photo_thumb_50 = "";
							$get_requester_profile_first_name = "";
							$get_requester_profile_middle_name = "";
							$get_requester_profile_last_name = "";
							$get_requester_professional_position = "";
							$get_requester_professional_department = "";
							$get_requester_professional_company_location = "";
						}
						else{
							// Requester photo
							$query = "SELECT photo_id, photo_destination, photo_thumb_40, photo_thumb_50 FROM $t_users_profile_photo WHERE photo_user_id=$get_my_station_member_user_id AND photo_profile_image='1'";
							$result = mysqli_query($link, $query);
							$row = mysqli_fetch_row($result);
							list($get_requester_photo_id, $get_requester_photo_destination, $get_requester_photo_thumb_40, $get_requester_photo_thumb_50) = $row;

							// Requester Profile
							$query = "SELECT profile_id, profile_first_name, profile_middle_name, profile_last_name, profile_about FROM $t_users_profile WHERE profile_user_id=$get_my_station_member_user_id";
							$result = mysqli_query($link, $query);
							$row = mysqli_fetch_row($result);
							list($get_requester_profile_id, $get_requester_profile_first_name, $get_requester_profile_middle_name, $get_requester_profile_last_name, $get_requester_profile_about) = $row;

							// Requester professional
							$query = "SELECT professional_id, professional_user_id, professional_company, professional_company_location, professional_department, professional_work_email, professional_position FROM $t_users_professional WHERE professional_user_id=$get_my_station_member_user_id";
							$result = mysqli_query($link, $query);
							$row = mysqli_fetch_row($result);
							list($get_requester_professional_id, $get_requester_professional_user_id, $get_requester_professional_company, $get_requester_professional_company_location, $get_requester_professional_department, $get_requester_professional_work_email, $get_requester_professional_position) = $row;
						}
			
						$inp_requester_user_name_mysql = quote_smart($link, $get_requester_user_name);
						$inp_requester_user_alias_mysql = quote_smart($link, $get_requester_user_alias);
						$inp_requester_user_email_mysql = quote_smart($link, $get_requester_user_email);

						$inp_requester_user_image_path = "_uploads/users/images/$get_requester_user_id";
						$inp_requester_user_image_path_mysql = quote_smart($link, $inp_requester_user_image_path);
	
						$inp_requester_user_image_file_mysql = quote_smart($link, $get_requester_photo_destination);

						$inp_requester_user_image_thumb_a_mysql = quote_smart($link, $get_requester_photo_thumb_40);
						$inp_requester_user_image_thumb_b_mysql = quote_smart($link, $get_requester_photo_thumb_50);

						$inp_requester_user_first_name_mysql = quote_smart($link, $get_requester_profile_first_name);
						$inp_requester_user_middle_name_mysql = quote_smart($link, $get_requester_profile_middle_name);
						$inp_requester_user_last_name_mysql = quote_smart($link, $get_requester_profile_last_name);
			
						$inp_requester_user_job_title_mysql = quote_smart($link, $get_requester_professional_position);
						$inp_requester_user_department_mysql = quote_smart($link, $get_requester_professional_department);
						$inp_requester_professional_company_location_mysql = quote_smart($link, $get_requester_professional_company_location);


						// Data about evidence
						$inp_seized_year = $_POST['inp_seized_year'];
						$inp_seized_year = output_html($inp_seized_year);
						$inp_seized_year_mysql = quote_smart($link, $inp_seized_year);

						$inp_seized_journal = $_POST['inp_seized_journal'];
						$inp_seized_journal = output_html($inp_seized_journal);
						$inp_seized_journal_mysql = quote_smart($link, $inp_seized_journal);

						$inp_seized_district_number = $_POST['inp_seized_district_number'];
						$inp_seized_district_number = output_html($inp_seized_district_number);
						$inp_seized_district_number_mysql = quote_smart($link, $inp_seized_district_number);

						// District ID
						$query = "SELECT district_id, district_title FROM $t_edb_districts_index WHERE district_number=$inp_seized_district_number_mysql";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_district_id, $get_district_title) = $row;

						$inp_seized_district_id_mysql = quote_smart($link, $get_district_id);
						$inp_seized_district_title_mysql = quote_smart($link, $get_district_title);

						$inp_numeric_serial_number = $_POST['inp_numeric_serial_number'];
						$inp_numeric_serial_number = output_html($inp_numeric_serial_number);
						$inp_numeric_serial_number_mysql = quote_smart($link, $inp_numeric_serial_number);

						$inp_title = $_POST['inp_title'];
						$inp_title = output_html($inp_title);
						$inp_title_mysql = quote_smart($link, $inp_title);

						// Type
						$inp_item_type_id = $_POST['inp_item_type_id'];
						$inp_item_type_id = output_html($inp_item_type_id);
						$inp_item_type_id_mysql = quote_smart($link, $inp_item_type_id);

						$query = "SELECT item_type_id, item_type_title FROM $t_edb_item_types WHERE item_type_id=$inp_item_type_id_mysql";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_item_type_id, $get_item_type_title) = $row;
						
						if($get_item_type_id == ""){
							$get_item_type_id = "0";
						}
						$inp_item_type_title_mysql = quote_smart($link, $get_item_type_title);

						// Look for evidence_records
						$query = "SELECT record_id FROM $t_edb_case_index_evidence_records WHERE record_case_id=$get_current_case_id AND record_seized_year=$inp_seized_year_mysql  AND record_seized_journal=$inp_seized_journal_mysql AND record_seized_district_id=$get_district_id";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_record_id) = $row;
						
						if($get_record_id == ""){
							// Create record
							mysqli_query($link, "INSERT INTO $t_edb_case_index_evidence_records
							(record_id, record_case_id, record_seized_year, record_seized_journal, record_seized_district_id, 
							record_seized_district_number, record_seized_district_title, record_confirmed_by_human, record_human_rejected, record_notes, record_created_datetime, 
							record_created_date, record_created_time, record_created_date_saying, record_created_date_ddmmyy, record_created_date_ddmmyyyy) 
							VALUES 
							(NULL, $get_current_case_id, $inp_seized_year_mysql, $inp_seized_journal_mysql, $inp_seized_district_id_mysql, 
							$inp_seized_district_number_mysql, $inp_seized_district_title_mysql, 1, 0, '', '$datetime',
							'$date', '$time', '$date_saying', '$date_ddmmyy', '$date_ddmmyyyy')")
							or die(mysqli_error($link));

							// Get ID
							$query = "SELECT record_id FROM $t_edb_case_index_evidence_records WHERE record_case_id=$get_current_case_id AND record_created_datetime='$datetime'";
							$result = mysqli_query($link, $query);
							$row = mysqli_fetch_row($result);
							list($get_record_id) = $row;

						}

						// Insert evidence

						mysqli_query($link, "INSERT INTO $t_edb_case_index_evidence_items
						(item_id, item_case_id, item_record_id, item_record_seized_year, item_record_seized_journal, 
						item_record_seized_district_number, item_numeric_serial_number, item_title, item_parent_item_id,
						item_type_id, item_type_title, 
						item_in_datetime, item_in_date, item_in_time, item_in_date_saying, item_in_date_ddmmyy, 
						item_requester_user_id, item_requester_user_name, item_requester_user_alias, 
						item_requester_user_email, item_requester_user_image_path, item_requester_user_image_file, item_requester_user_image_thumb_40, item_requester_user_image_thumb_50, item_requester_user_first_name, item_requester_user_middle_name, item_requester_user_last_name, item_requester_user_job_title, item_requester_user_department,
						item_acquired_date, item_acquired_time, item_acquired_date_saying, item_acquired_date_ddmmyy, item_acquired_date_ddmmyyyy, item_acquired_user_id, item_acquired_user_name) 
						VALUES 
						(NULL, $get_current_case_id, $get_record_id, $inp_seized_year_mysql, $inp_seized_journal_mysql, 
						$inp_seized_district_number_mysql, $inp_numeric_serial_number_mysql, $inp_title_mysql, 0,
						$get_item_type_id, $inp_item_type_title_mysql, 
						'$datetime', '$date', '$time', '$date_saying', '$date_ddmmyy',
						$get_requester_user_id, $inp_requester_user_name_mysql, $inp_requester_user_alias_mysql, 
						$inp_requester_user_email_mysql, $inp_requester_user_image_path_mysql, $inp_requester_user_image_file_mysql, $inp_requester_user_image_thumb_a_mysql, 
						$inp_requester_user_image_thumb_b_mysql, $inp_requester_user_first_name_mysql, $inp_requester_user_middle_name_mysql, $inp_requester_user_last_name_mysql, $inp_requester_user_job_title_mysql, 
						$inp_requester_user_department_mysql,
						'$date', '$time', '$date_saying', '$date_ddmmyy', '$date_ddmmyyyy', $my_user_id_mysql , $inp_my_user_name_mysql)")
						or die(mysqli_error($link));

						// Get Evidence Item ID
						$query = "SELECT item_id FROM $t_edb_case_index_evidence_items WHERE item_case_id=$get_current_case_id AND item_in_datetime='$datetime'";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_item_id) = $row;
						


						mysqli_query($link, "INSERT INTO $t_edb_case_index_review_matrix_items
						(matrix_item_id, matrix_item_case_id, matrix_item_item_id, matrix_item_record_id, matrix_item_record_seized_year, matrix_item_record_seized_journal, matrix_item_record_seized_district_number, matrix_item_numeric_serial_number, matrix_item_title) 
						VALUES 
						(NULL, $get_current_case_id, $get_item_id, $get_record_id, $inp_seized_year_mysql, $inp_seized_journal_mysql, $inp_numeric_serial_number_mysql, $inp_numeric_serial_number_mysql, $inp_title_mysql)")
						or die(mysqli_error($link));

						$url = "open_case_review_matrix_edit_matrix_items.php?case_id=$get_current_case_id&l=$l&ft=success&fm=item_added";
						header("Location: $url");
						exit;
					}
					echo"
					<h2>$l_add_review_matrix_item</h2>
		
					<!-- Feedback -->
						";
						if($ft != ""){
							if($fm == "changes_saved"){
								$fm = "$l_changes_saved";
							}
							else{
								$fm = ucfirst($fm);
								$fm = str_replace("_", " ", $fm);
							}
							echo"<div class=\"$ft\"><span>$fm</span></div>";
						}
						echo"	
					<!-- //Feedback -->

					<!-- Add evidence -->
						<form method=\"post\" action=\"open_case_review_matrix_edit_matrix_items.php?case_id=$get_current_case_id&amp;action=$action&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

						<!-- Focus -->
							<script>
							\$(document).ready(function(){
								\$('[name=\"inp_seized_journal\"]').focus();
							});
							</script>
						<!-- //Focus -->

						<table>
						 <tr>
						  <td style=\"padding-right: 4px;text-align:center;\">
							<p><b>$l_year</b><br />";
							$inp_year = date("Y");
							echo"
							<input type=\"text\" name=\"inp_seized_year\" value=\"$inp_year\" size=\"4\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" style=\"text-align:center;border: #fff 1px solid;border-bottom: #ccc 1px dashed;\" />
							</p>
						  </td>
						  <td style=\"padding-right: 4px;text-align:center;vertical-align:top;\">
							<p><b>/</b></p>
						  </td>
						  <td style=\"padding-right: 4px;text-align:center;\">
							<p><b>$l_journal</b><br />
							<input type=\"text\" name=\"inp_seized_journal\" value=\"\" size=\"6\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" style=\"text-align:center;border: #fff 1px solid;border-bottom: #ccc 1px dashed;\" />
							</p>
						  </td>
						  <td style=\"padding-right: 4px;text-align:center;vertical-align:top;\">
							<p><b>-</b></p>
						  </td>
						  <td style=\"padding-right: 4px;text-align:center;\">
							<p><b>$l_district</b><br />";
							$query = "SELECT district_id, district_number FROM $t_edb_districts_index WHERE district_id=$get_current_case_district_id";
							$result = mysqli_query($link, $query);
							$row = mysqli_fetch_row($result);
							list($get_current_district_id, $get_current_district_number) = $row;
	
							echo"
							<input type=\"text\" name=\"inp_seized_district_number\" value=\"$get_current_district_number\" size=\"6\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" style=\"text-align:center;border: #fff 1px solid;border-bottom: #ccc 1px dashed;\" />
							</p>
						  </td>
						  <td style=\"padding-right: 4px;text-align:center;vertical-align:top;\">
							<p><b>-</b></p>
						  </td>
						  <td style=\"padding-right: 4px;text-align:center;\">
							<p><b>$l_number_abbreviation</b><br />
							<input type=\"text\" name=\"inp_numeric_serial_number\" value=\"\" size=\"2\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" style=\"text-align:center;border: #fff 1px solid;border-bottom: #ccc 1px dashed;\" />
							</p>
						  </td>
						 </tr>
						</table>

						<p><b>$l_title</b><br />
						<input type=\"text\" name=\"inp_title\" value=\"\" size=\"25\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
						</p>

						<p><b>$l_type</b><br />
						<select name=\"inp_item_type_id\" class=\"on_change_submit_form\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\">\n";
							$query_sub = "SELECT item_type_id, item_type_title, item_type_image_path, item_type_image_file FROM $t_edb_item_types ORDER BY item_type_title ASC";
							$result_sub = mysqli_query($link, $query_sub);
							while($row_sub = mysqli_fetch_row($result_sub)) {
								list($get_types_item_type_id, $get_types_item_type_title, $get_types_item_type_image_path, $get_types_item_type_image_file) = $row_sub;
								echo"			";
								echo"<option value=\"$get_types_item_type_id\">$get_types_item_type_title</option>\n";
							}
							echo"
						</select>
						</p>

						<p><input type=\"submit\" value=\"$l_save_changes\" class=\"btn_default\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
						</p>
					<!-- //Add evidence -->
					";
				} // add
				elseif($action == "delete_matrix_item"){
					// Find matrix item
					$matrix_item_id_mysql = quote_smart($link, $matrix_item_id);
					$query = "SELECT matrix_item_id, matrix_item_case_id, matrix_item_item_id, matrix_item_record_id, matrix_item_record_seized_year, matrix_item_record_seized_journal, matrix_item_record_seized_district_number, matrix_item_numeric_serial_number, matrix_item_title FROM $t_edb_case_index_review_matrix_items WHERE matrix_item_id=$matrix_item_id_mysql AND matrix_item_case_id=$get_current_case_id";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_current_matrix_item_id, $get_current_matrix_item_case_id, $get_current_matrix_item_item_id, $get_current_matrix_item_record_id, $get_current_matrix_item_record_seized_year, $get_current_matrix_item_record_seized_journal, $get_current_matrix_item_record_seized_district_number, $get_current_matrix_item_numeric_serial_number, $get_current_matrix_item_title) = $row;
	
					if($get_current_matrix_item_id == ""){
						echo"
						<h1>Server error 404</h1>
						";
					}
					else{
						if($process == "1"){
	
			
							$result = mysqli_query($link, "DELETE FROM $t_edb_case_index_review_matrix_items WHERE matrix_item_id=$get_current_matrix_item_id AND matrix_item_case_id=$get_current_case_id");
							
							$url = "open_case_review_matrix_edit_matrix_items.php?case_id=$get_current_case_id&l=$l&ft=success&fm=item_deleted";
							header("Location: $url");
							exit;
						}
						echo"
						<h1>Delete $get_current_matrix_item_record_seized_year / $get_current_matrix_item_record_seized_journal - $get_current_matrix_item_record_seized_district_number - $get_current_matrix_item_numeric_serial_number $get_current_matrix_item_title</h1>


						<!-- Where am I? -->
							<p><b>You are here:</b><br />
							<a href=\"open_case_review_matrix.php?case_id=$get_current_case_id&amp;l=$l\">$l_review_matrix</a>
							&gt;
							<a href=\"open_case_review_matrix_edit_matrix_items.php?case_id=$get_current_case_id&amp;l=$l\">$l_edit_review_matrix_items</a>
							&gt;
							<a href=\"open_case_review_matrix_edit_matrix_items.php?case_id=$get_current_case_id&amp;action=$action&amp;matrix_item_id=$get_current_matrix_item_id&amp;l=$l\">Delete</a>
							</p>
						<!-- //Where am I? -->

						<!-- Feedback -->
							";
							if($ft != ""){
								if($fm == "changes_saved"){
									$fm = "$l_changes_saved";
								}
								else{
									$fm = str_replace("_", " ", $fm);
									$fm = ucfirst($fm);
								}
								echo"<div class=\"$ft\"><span>$fm</span></div>";
							}
							echo"	
						<!-- //Feedback -->


						<!-- Delete title form -->
							<p>
							Are you sure you want to delete?
							</p>

							<p>
							<a href=\"open_case_review_matrix_edit_matrix_items.php?case_id=$get_current_case_id&amp;action=$action&amp;matrix_item_id=$get_current_matrix_item_id&amp;l=$l&amp;process=1\" class=\"btn_danger\">Confirm</a>
							</p>
						<!-- //Delete  title form -->

						";
					} // title found
				} // delete_title
			} // access 
			else{
				echo"<p>$l_access_denied</p>";
			} // is not admin, moderator, editor, editor_limited
		} // access to station
	} // case found

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