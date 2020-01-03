<?php 
/**
*
* File: edb/open_case_usr_psw.php
* Version 1.0
* Date 16:31 13.11.2019
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


/*- Tables ---------------------------------------------------------------------------- */

$t_edb_item_types_available_passwords 		= $mysqlPrefixSav . "edb_item_types_available_passwords";
$t_edb_case_index_evidence_items_passwords 	= $mysqlPrefixSav . "edb_case_index_evidence_items_passwords";
$t_edb_most_used_passwords 			= $mysqlPrefixSav . "edb_most_used_passwords";

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
		$website_title = "$l_edb - $get_current_case_district_title - $get_current_case_station_title - $get_current_case_number";
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
					<a href=\"open_case_usr_psw.php?case_id=$get_current_case_id&amp;l=$l\">$l_user_password</a>
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
			if($action == ""){
				if($process == "1" && ($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor" OR $get_my_station_member_rank == "editor_limited")){
					$query = "SELECT item_id, item_case_id, item_record_id, item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number, item_title, item_type_id, item_type_title FROM $t_edb_case_index_evidence_items WHERE item_case_id=$get_current_case_id ORDER BY item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number ASC";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_item_id, $get_item_case_id, $get_item_record_id, $get_item_record_seized_year, $get_item_record_seized_journal, $get_item_record_seized_district_number, $get_item_numeric_serial_number, $get_item_title, $get_item_type_id, $get_item_type_title) = $row;

						// Each item can have multible passwords presents (multible "rows" of passwords)
						// First find amoiunt of password sets
						$query_set = "SELECT DISTINCT(password_set_number) FROM $t_edb_case_index_evidence_items_passwords WHERE password_case_id=$get_current_case_id AND password_item_id=$get_item_id";
						$result_set = mysqli_query($link, $query_set);
						while($row_set = mysqli_fetch_row($result_set)) {
							list($get_current_password_set_number) = $row_set;
					
							$inp_item_type_id = $_POST["inp_item_type_id_$get_item_id"];
							$inp_item_type_id = output_html($inp_item_type_id);
							$inp_item_type_id_mysql = quote_smart($link, $inp_item_type_id);
							if($inp_item_type_id == "0"){
								$get_types_item_type_id = "0";
								$get_types_item_type_title = "";
							}
							else{
								$query_i = "SELECT item_type_id, item_type_title FROM $t_edb_item_types WHERE item_type_id=$inp_item_type_id_mysql";
								$result_i = mysqli_query($link, $query_i);
								$row_i = mysqli_fetch_row($result_i);
								list($get_types_item_type_id, $get_types_item_type_title) = $row_i;
							}
							$inp_item_type_title_mysql = quote_smart($link, $get_types_item_type_title);

							
							$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items SET 
												item_type_id=$get_types_item_type_id,
												item_type_title=$inp_item_type_title_mysql
												WHERE item_id=$get_item_id AND item_case_id=$get_current_case_id") or die(mysqli_error($link));

						} // while password set
					} // while items

					$url = "open_case_usr_psw.php?case_id=$get_current_case_id&l=$l&ft=success&fm=changes_saved";
					header("Location: $url");
					exit;

				} // process== 1

				echo"
				<h2>$l_user_password</h2>

				<!-- usr psw actions -->
						<p>";
					if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor" OR $get_my_station_member_rank == "editor_limited"){
						echo"
						<a href=\"open_case_usr_psw.php?case_id=$get_current_case_id&amp;action=add&amp;l=$l\" class=\"btn_default\">$l_add</a>
						
						";
					}	
					echo"
					<a href=\"most_used_passwords.php?l=$l\" class=\"btn_default\">$l_most_used_passwords</a>
					</p>
					<div style=\"height: 10px;\"></div>
				<!-- //Usr psw actions -->


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

				<!-- List of username / passwords -->

					";
					if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor" OR $get_my_station_member_rank == "editor_limited"){
						echo"
						<form method=\"POST\" action=\"open_case_usr_psw.php?case_id=$get_current_case_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
						";
					}
					echo"

					<table class=\"hor-zebra\">
					 <thead>
					  <tr>
					   <th scope=\"col\">
						<span>$l_related_to</span>
					   </th>
					   <th scope=\"col\">
						<span>$l_type</span>
					   </th>";
					// Make headline with correct username, password, pin etc
					// To do this we neeed to 1) Loop trough evidence distinct evidence type id
					//			  2) Loop trough item_types_available_passwords
					$available_title_array[0] = "";
					$headline_count = 0;
					$query = "SELECT DISTINCT item_type_id FROM $t_edb_case_index_evidence_items WHERE item_case_id=$get_current_case_id";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_item_type_id) = $row;

						if($get_item_type_id == ""){
							// Give a list of type id that we have to select for the evidence we are missing type id for
							echo"
							 <span style=\"color:red;font-weight:bold;\"><img src=\"_gfx/warning_16x16.png\" alt=\"warning_16x16.png\" /> $l_missing_item_type</span>
							";
						}
						else{
							// Check if there are passwords for this evidence item
							$query_av = "SELECT DISTINCT available_title FROM $t_edb_item_types_available_passwords WHERE available_item_type_id=$get_item_type_id";
							$result_av = mysqli_query($link, $query_av);
							while($row_av = mysqli_fetch_row($result_av)) {
								list($get_available_title) = $row_av;

								if(!(in_array($get_available_title, $available_title_array))){
									$available_title_array[$headline_count] = "$get_available_title";
									$headline_count++;
								}
							}
						}
					} // while evidence headline
					for($x=0;$x<sizeof($available_title_array);$x++){
						if(isset($available_title_array[$x])){
							if($available_title_array[$x] != ""){
								$headline = $available_title_array[$x];
								echo"
								   <th scope=\"col\">
									<span>$headline</span>
								   </th>
								";
							}
						}
					} // headline print
					echo"
					   <th scope=\"col\">
						<span>$l_actions</span>
					   </th>
					  </tr>
					 </thead>
					 <tbody>
					";
					$count_items=0;
					$query = "SELECT item_id, item_case_id, item_record_id, item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number, item_title, item_type_id, item_type_title FROM $t_edb_case_index_evidence_items WHERE item_case_id=$get_current_case_id ORDER BY item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number ASC";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_item_id, $get_item_case_id, $get_item_record_id, $get_item_record_seized_year, $get_item_record_seized_journal, $get_item_record_seized_district_number, $get_item_numeric_serial_number, $get_item_title, $get_item_type_id, $get_item_type_title) = $row;

						// Each item can have multible passwords presents (multible "rows" of passwords)
						// First find amoiunt of password sets
						$query_set = "SELECT DISTINCT(password_set_number) FROM $t_edb_case_index_evidence_items_passwords WHERE password_case_id=$get_current_case_id AND password_item_id=$get_item_id";
						$result_set = mysqli_query($link, $query_set);
						while($row_set = mysqli_fetch_row($result_set)) {
							list($get_current_password_set_number) = $row_set;
					

							if(isset($style) && $style == ""){
								$style = "odd";
							}
							else{
								$style = "";
							}

							echo"
							 <tr>
							  <td class=\"$style\">
								<span><a href=\"open_case_evidence_edit_evidence_item_item.php?case_id=$get_current_case_id&amp;item_id=$get_item_id&amp;mode=item&amp;l=$l\">$get_item_record_seized_year/$get_item_record_seized_journal-$get_item_record_seized_district_number-$get_item_numeric_serial_number $get_item_title</a></span>
							  </td>
							  <td class=\"$style\">
								
								<span>";
								if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor" OR $get_my_station_member_rank == "editor_limited"){
									echo"
									<select name=\"inp_item_type_id_$get_item_id\" class=\"on_change_submit_form\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
									<option value=\"0\""; if($get_item_type_id == ""){ echo" selected=\"selected\""; } echo">-</option>\n";
									$query_sub = "SELECT item_type_id, item_type_title, item_type_image_path, item_type_image_file FROM $t_edb_item_types ORDER BY item_type_title ASC";
									$result_sub = mysqli_query($link, $query_sub);
									while($row_sub = mysqli_fetch_row($result_sub)) {
										list($get_types_item_type_id, $get_types_item_type_title, $get_types_item_type_image_path, $get_types_item_type_image_file) = $row_sub;
										echo"			";
										echo"<option value=\"$get_types_item_type_id\""; if($get_types_item_type_id == "$get_item_type_id"){ echo" selected=\"selected\""; } echo">$get_types_item_type_title</option>\n";
									}
									echo"
									</select>
									";
								}
								else{
									echo"<span>$get_item_type_title</span>";
								}
								echo"</span>
							  </td>
							";
							if($get_item_type_id != ""){

								for($x=0;$x<sizeof($available_title_array);$x++){
									$available_title = $available_title_array[$x];
									$available_title_mysql = quote_smart($link, $available_title);
	
									// Get available information
									$query_av = "SELECT available_id, available_item_type_id, available_title, available_type, available_size, available_last_updated_datetime, available_last_updated_user_id FROM $t_edb_item_types_available_passwords WHERE available_title=$available_title_mysql AND available_item_type_id=$get_item_type_id";
									$result_av = mysqli_query($link, $query_av);
									$row_av = mysqli_fetch_row($result_av);
									list($get_available_id, $get_available_item_type_id, $get_available_title, $get_available_type, $get_available_size, $get_available_last_updated_datetime, $get_available_last_updated_user_id) = $row_av;

									if($get_available_id == ""){
										echo"
										  <td class=\"$style\">
									
										  </td>";
									}
									else{
										// Fetch password
										$query_psw = "SELECT password_id, password_case_id, password_item_id, password_available_id, password_item_type_id, password_set_number, password_value, password_created_by_user_id, password_created_by_user_name, password_created_datetime, password_updated_by_user_id, password_updated_by_user_name, password_updated_datetime FROM $t_edb_case_index_evidence_items_passwords WHERE password_case_id=$get_current_case_id AND password_item_id=$get_item_id AND password_available_id=$get_available_id AND password_item_type_id=$get_available_item_type_id AND password_set_number=$get_current_password_set_number";
										$result_psw = mysqli_query($link, $query_psw);
										$row_psw = mysqli_fetch_row($result_psw);
										list($get_password_id, $get_password_case_id, $get_password_item_id, $get_password_available_id, $get_password_item_type_id, $get_password_set_number, $get_password_value, $get_password_created_by_user_id, $get_password_created_by_user_name, $get_password_created_datetime, $get_password_updated_by_user_id, $get_password_updated_by_user_name, $get_password_updated_datetime) = $row_psw;

										echo"
										  <td class=\"$style\">
											";
										if($get_available_type == "unlock_pattern"){
											if($get_password_value != ""){
												echo"<span><img src=\"most_used_passwords_unlock_pattern_drawer_to_image.php?pattern=$get_password_value\" alt=\"$get_password_value\" /><br />$get_password_value</span>";
											}
										}
										else{
											echo"<span>$get_password_value</span>";
										}
										echo"
										  </td>";
									} // Type doesnt exists for this
						


									} // Loop trough headline
								} // item type id not empty
								echo"
								  <td class=\"$style\">
									<span>
									<a href=\"open_case_usr_psw.php?action=edit&amp;case_id=$get_current_case_id&amp;item_id=$get_item_id&amp;password_set_number=$get_current_password_set_number&amp;l=$l\">$l_edit</a>
									|
									<a href=\"open_case_usr_psw.php?action=delete&amp;case_id=$get_current_case_id&amp;item_id=$get_item_id&amp;password_set_number=$get_current_password_set_number&amp;l=$l\">$l_delete</a>
									</span>
								  </td>";
							echo"
							 </tr>
							";
						} // while password sets
						$count_items++;
					} // while evidence items
					if($count_items != "$get_current_menu_counter_usr_psw"){
						$result = mysqli_query($link, "UPDATE $t_edb_case_index_open_case_menu_counters SET menu_counter_usr_psw=$count_items WHERE menu_counter_case_id=$get_current_case_id") or die(mysqli_error($link));
					}
				echo"
				 </tbody>
				</table>
					";
					if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor" OR $get_my_station_member_rank == "editor_limited"){
						echo"
						<p>
						<input type=\"submit\" value=\"$l_save_changes\" class=\"btn_default\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
						</p>
						</form>
						<!-- Submit form after change type -->
						<script>
						\$(function() {
							\$('.on_change_submit_form').change(function() {
								this.form.submit();
							});
						});
						</script>
						<!-- //Submit form after change type -->
						";
					}
					echo"

				<!-- List of username and passwords -->
				";
			} // $action == ""
			elseif($action == "add" && ($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor" OR $get_my_station_member_rank == "editor_limited")){
				// We first want to select a item id and item type
				
				if($process == "1"){
					// Dates
					$datetime = date("Y-m-d H:i:s");
					$date_saying = date("j. M Y");
					$time = time();
				
					// Me $my_user_id_mysql 
					$query = "SELECT user_id, user_email, user_name, user_alias, user_language, user_last_online, user_rank, user_login_tries FROM $t_users WHERE user_id=$my_user_id_mysql";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_my_user_id, $get_my_user_email, $get_my_user_name, $get_my_user_alias, $get_my_user_language, $get_my_user_last_online, $get_my_user_rank, $get_my_user_login_tries) = $row;
			
					$inp_my_user_name_mysql = quote_smart($link, $get_my_user_name);

					// Related to
					$item_id = $_GET['item_id'];
					$item_id = output_html($item_id);
					$item_id_mysql = quote_smart($link, $item_id);


					// Password set
					$inp_password_set_new = rand(100, 9999);
					$inp_password_set_new_mysql = quote_smart($link, $inp_password_set_new);

					// Focus
					$focus = "";

					// Find item
					$query = "SELECT item_id, item_record_id, item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number, item_title, item_type_id, item_type_title FROM $t_edb_case_index_evidence_items WHERE item_id=$item_id_mysql AND item_case_id=$case_id_mysql";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_item_id, $get_item_record_id, $get_item_record_seized_year, $get_item_record_seized_journal, $get_item_record_seized_district_number, $get_item_numeric_serial_number, $get_item_title, $get_item_type_id, $get_item_type_title) = $row;
			
					if($get_item_id != ""){
						$query = "SELECT available_id, available_item_type_id, available_title, available_type, available_size, available_last_updated_datetime, available_last_updated_user_id FROM $t_edb_item_types_available_passwords WHERE available_item_type_id=$get_item_type_id";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_available_id, $get_available_item_type_id, $get_available_title, $get_available_type, $get_available_size, $get_available_last_updated_datetime, $get_available_last_updated_user_id) = $row;
							$inp_available_title_mysql = quote_smart($link, $get_available_title);
					
							mysqli_query($link, "INSERT INTO $t_edb_case_index_evidence_items_passwords
							(password_id, password_case_id, password_item_id, password_available_id, password_available_title, password_item_type_id, password_set_number, password_value, password_created_by_user_id, password_created_by_user_name, password_created_datetime) 
							VALUES 
							(NULL, $get_current_case_id, $get_item_id, $get_available_id, $inp_available_title_mysql, $get_available_item_type_id, $inp_password_set_new_mysql, NULL, $my_user_id_mysql, $inp_my_user_name_mysql, '$datetime')")
							or die(mysqli_error($link));

							if($focus == ""){
								// Get ID, so we can put focus on it
								$query = "SELECT password_id FROM $t_edb_case_index_evidence_items_passwords WHERE password_case_id=$get_current_case_id AND password_item_id=$get_item_id AND password_available_id=$get_available_id AND password_item_type_id=$get_available_item_type_id AND password_created_datetime='$datetime'";
								$result = mysqli_query($link, $query);
								$row = mysqli_fetch_row($result);
								list($get_current_password_id) = $row;

								$focus = "inp_password_value_$get_current_password_id";
							}
					
						} // Passwords New

						$url = "open_case_usr_psw.php?case_id=$get_current_case_id&l=$l&item_id=$transfer_item_id&ft=success&fm=password_row_created&focus=$focus";
						header("Location: $url");
						exit;

					} // item found 
					else{
						echo"Transfer item missing";
					}
				}
				echo"
				<h2>$l_add</h2>

				

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

				<!-- New usr psw form -->

					<!-- Focus -->
						<script>
							\$(document).ready(function(){
								\$('[name=\"inp_related_to\"]').focus();
							});
						</script>
					<!-- //Focus -->

					<form method=\"POST\" id=\"form\" action=\"open_case_usr_psw.php?case_id=$get_current_case_id&amp;action=$action&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
		
					<p>$l_related_to:<br />
					<input type=\"text\" name=\"inp_related_to\" id=\"autosearch_inp_related_to\" value=\"\" size=\"35\" autocomplete=\"off\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
					</p>

					<!-- Related to autocomplete -->
						<script>
						\$(document).ready(function () {
							\$('#autosearch_inp_related_to').keyup(function () {
								// getting the value that user typed
      								var searchString    = $(\"#autosearch_inp_related_to\").val();
 								// forming the queryString
      								var data            = 'case_id=$get_current_case_id&l=$l&q=' + searchString;
        							// if searchString is not empty
        							if(searchString) {
        								// ajax call
        								\$.ajax({
        									type: \"GET\",
             									url: \"open_case_usr_psw_search_for_related_to_jquery.php\",
                								data: data,
										beforeSend: function(html) { // this happens before actual call
											\$(\".open_case_usr_psw_search_for_related_to_results\").html(''); 
										},
               									success: function(html){
                									\$(\".open_case_usr_psw_search_for_related_to_results\").append(html);
              									}
            								});
       								}
        							return false;
            						});
         					 });
						</script>
						<div class=\"open_case_usr_psw_search_for_related_to_results\"></div>
					<!-- //Related to autocomplete -->

				<!-- //New usr psw form -->

				<!-- Previous -->
					<p><a href=\"open_case_usr_psw.php?case_id=$get_current_case_id&amp;l=$l\">$l_previous</a></p>
				<!-- //Previous -->
				
				";
			} // add
			elseif($action == "edit" && ($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor" OR $get_my_station_member_rank == "editor_limited")){
				// item id
				$item_id = $_GET['item_id'];
				$item_id = output_html($item_id);
				$item_id_mysql = quote_smart($link, $item_id);

				// password_set_number
				$password_set_number = $_GET['password_set_number'];
				$password_set_number = output_html($password_set_number);
				$password_set_number_mysql = quote_smart($link, $password_set_number);

				// Find that item
				$query = "SELECT item_id, item_case_id, item_record_id, item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number, item_title, item_parent_item_id, item_type_id, item_type_title, item_confirmed_by_human, item_human_rejected, item_request_text, item_requester_user_id, item_requester_user_name, item_requester_user_alias, item_requester_user_email, item_requester_user_image_path, item_requester_user_image_file, item_requester_user_image_thumb_40, item_requester_user_image_thumb_50, item_requester_user_first_name, item_requester_user_middle_name, item_requester_user_last_name, item_requester_user_job_title, item_requester_user_department, item_in_datetime, item_in_date, item_in_time, item_in_date_saying, item_in_date_ddmmyy, item_in_date_ddmmyyyy, item_storage_shelf_id, item_storage_shelf_title, item_storage_location_id, item_storage_location_abbr, item_comment, item_condition, item_serial_number, item_imei_a, item_imei_b, item_imei_c, item_imei_d, item_os_title, item_os_version, item_name, item_timezone, item_date_now_date, item_date_now_saying, item_date_now_ddmmyy, item_date_now_ddmmyyyy, item_time_now, item_correct_date_now_date, item_correct_date_now_saying, item_correct_date_now_ddmmyy, item_correct_date_now_ddmmyyyy, item_correct_time_now, item_adjust_clock_automatically, item_adjust_time_zone_automatically, item_acquired_software_id_a, item_acquired_software_title_a, item_acquired_software_notes_a, item_acquired_software_id_b, item_acquired_software_title_b, item_acquired_software_notes_b, item_acquired_software_id_c, item_acquired_software_title_c, item_acquired_software_notes_c, item_acquired_date, item_acquired_time, item_acquired_date_saying, item_acquired_date_ddmmyy, item_acquired_date_ddmmyyyy, item_acquired_user_id, item_acquired_user_name, item_acquired_user_alias, item_acquired_user_email, item_acquired_user_image_path, item_acquired_user_image_file, item_acquired_user_image_thumb_40, item_acquired_user_image_thumb_50, item_acquired_user_first_name, item_acquired_user_middle_name, item_acquired_user_last_name, item_out_date, item_out_time, item_out_date_saying, item_out_date_ddmmyy, item_out_date_ddmmyyyy, item_out_notes FROM $t_edb_case_index_evidence_items WHERE item_id=$item_id_mysql AND item_case_id=$get_current_case_id";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_current_item_id, $get_current_item_case_id, $get_current_item_record_id, $get_current_item_record_seized_year, $get_current_item_record_seized_journal, $get_current_item_record_seized_district_number, $get_current_item_numeric_serial_number, $get_current_item_title, $get_current_item_parent_item_id, $get_current_item_type_id, $get_current_item_type_title, $get_current_item_confirmed_by_human, $get_current_item_human_rejected, $get_current_item_request_text, $get_current_item_requester_user_id, $get_current_item_requester_user_name, $get_current_item_requester_user_alias, $get_current_item_requester_user_email, $get_current_item_requester_user_image_path, $get_current_item_requester_user_image_file, $get_current_item_requester_user_image_thumb_40, $get_current_item_requester_user_image_thumb_50, $get_current_item_requester_user_first_name, $get_current_item_requester_user_middle_name, $get_current_item_requester_user_last_name, $get_current_item_requester_user_job_title, $get_current_item_requester_user_department, $get_current_item_in_datetime, $get_current_item_in_date, $get_current_item_in_time, $get_current_item_in_date_saying, $get_current_item_in_date_ddmmyy, $get_current_item_in_date_ddmmyyyy, $get_current_item_storage_shelf_id, $get_current_item_storage_shelf_title, $get_current_item_storage_location_id, $get_current_item_storage_location_abbr, $get_current_item_comment, $get_current_item_condition, $get_current_item_serial_number, $get_current_item_imei_a, $get_current_item_imei_b, $get_current_item_imei_c, $get_current_item_imei_d, $get_current_item_os_title, $get_current_item_os_version, $get_current_item_name, $get_current_item_timezone, $get_current_item_date_now_date, $get_current_item_date_now_saying, $get_current_item_date_now_ddmmyy, $get_current_item_date_now_ddmmyyyy, $get_current_item_time_now, $get_current_item_correct_date_now_date, $get_current_item_correct_date_now_saying, $get_current_item_correct_date_now_ddmmyy, $get_current_item_correct_date_now_ddmmyyyy, $get_current_item_correct_time_now, $get_current_item_adjust_clock_automatically, $get_current_item_adjust_time_zone_automatically, $get_current_item_acquired_software_id_a, $get_current_item_acquired_software_title_a, $get_current_item_acquired_software_notes_a, $get_current_item_acquired_software_id_b, $get_current_item_acquired_software_title_b, $get_current_item_acquired_software_notes_b, $get_current_item_acquired_software_id_c, $get_current_item_acquired_software_title_c, $get_current_item_acquired_software_notes_c, $get_current_item_acquired_date, $get_current_item_acquired_time, $get_current_item_acquired_date_saying, $get_current_item_acquired_date_ddmmyy, $get_current_item_acquired_date_ddmmyyyy, $get_current_item_acquired_user_id, $get_current_item_acquired_user_name, $get_current_item_acquired_user_alias, $get_current_item_acquired_user_email, $get_current_item_acquired_user_image_path, $get_current_item_acquired_user_image_file, $get_current_item_acquired_user_image_thumb_40, $get_current_item_acquired_user_image_thumb_50, $get_current_item_acquired_user_first_name, $get_current_item_acquired_user_middle_name, $get_current_item_acquired_user_last_name, $get_current_item_out_date, $get_current_item_out_time, $get_current_item_out_date_saying, $get_current_item_out_date_ddmmyy, $get_current_item_out_date_ddmmyyyy, $get_current_item_out_notes) = $row;
	

				if($get_current_item_id == ""){
					echo"<p>Server error 404</p> <p>Item not found</p>";
				}
				else{

					if($process == "1"){	
						// Dates
						$datetime = date("Y-m-d H:i:s");
						$date_saying = date("j. M Y");
						$time = time();
				

						// Me $my_user_id_mysql 
						$query = "SELECT user_id, user_email, user_name, user_alias, user_language, user_last_online, user_rank, user_login_tries FROM $t_users WHERE user_id=$my_user_id_mysql";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_my_user_id, $get_my_user_email, $get_my_user_name, $get_my_user_alias, $get_my_user_language, $get_my_user_last_online, $get_my_user_rank, $get_my_user_login_tries) = $row;
				
						$inp_my_user_name_mysql = quote_smart($link, $get_my_user_name);

						$query_set = "SELECT DISTINCT(password_set_number) FROM $t_edb_case_index_evidence_items_passwords WHERE password_case_id=$get_current_case_id AND password_item_id=$get_current_item_id";
						$result_set = mysqli_query($link, $query_set);
						while($row_set = mysqli_fetch_row($result_set)) {
							list($get_current_password_set_number) = $row_set;

							$query_av = "SELECT available_id, available_item_type_id, available_title, available_type, available_size, available_last_updated_datetime, available_last_updated_user_id FROM $t_edb_item_types_available_passwords WHERE available_item_type_id=$get_current_item_type_id";
							$result_av = mysqli_query($link, $query_av);
							while($row_av = mysqli_fetch_row($result_av)) {
								list($get_available_id, $get_available_item_type_id, $get_available_title, $get_available_type, $get_available_size, $get_available_last_updated_datetime, $get_available_last_updated_user_id) = $row_av;

								// Fetch data
								$query_psw = "SELECT password_id, password_case_id, password_item_id, password_available_id, password_item_type_id, password_set_number, password_value, password_created_by_user_id, password_created_by_user_name, password_created_datetime, password_updated_by_user_id, password_updated_by_user_name, password_updated_datetime FROM $t_edb_case_index_evidence_items_passwords WHERE password_case_id=$get_current_case_id AND password_item_id=$get_current_item_id AND password_available_id=$get_available_id AND password_item_type_id=$get_available_item_type_id AND password_set_number=$get_current_password_set_number";
								$result_psw = mysqli_query($link, $query_psw);
								$row_psw = mysqli_fetch_row($result_psw);
								list($get_password_id, $get_password_case_id, $get_password_item_id, $get_password_available_id, $get_password_item_type_id, $get_password_set_number, $get_password_value, $get_password_created_by_user_id, $get_password_created_by_user_name, $get_password_created_datetime, $get_password_updated_by_user_id, $get_password_updated_by_user_name, $get_password_updated_datetime) = $row_psw;
								

								if($get_available_type == "text" OR $get_available_type == "numeric"){
									$inp_password_value = $_POST["inp_password_value_$get_password_id"];
									$inp_password_value = output_html($inp_password_value);
									$inp_password_value_mysql = quote_smart($link, $inp_password_value);

									$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items_passwords SET 
												password_value=$inp_password_value_mysql, 
												password_updated_by_user_id=$my_user_id_mysql, 
												password_updated_by_user_name=$inp_my_user_name_mysql, 
												password_updated_datetime='$datetime'
												WHERE password_id=$get_password_id") or die(mysqli_error($link));


									if($inp_password_value != "$get_password_value"){


										// Most used passwords
	  									$inp_available_title_mysql = quote_smart($link, $get_available_title);
	   									$inp_available_title_clean = clean($get_available_title);
	  									$inp_available_title_clean_mysql = quote_smart($link, $inp_available_title_clean);

										// Most used passwords
										$query_most = "SELECT password_id, password_count FROM $t_edb_most_used_passwords WHERE password_available_id=$get_available_id AND password_item_type_id=$get_available_item_type_id AND password_pass=$inp_password_value_mysql";
										$result_most = mysqli_query($link, $query_most);
										$row_most = mysqli_fetch_row($result_most);
										list($get_password_id, $get_password_count) = $row_most;
										if($get_password_id == ""){
											mysqli_query($link, "INSERT INTO $t_edb_most_used_passwords 
											(password_id, password_available_id, password_available_title, password_available_title_clean, password_item_type_id, password_pass, password_count, password_first_used_datetime, password_first_used_time, password_first_used_saying, password_last_used_datetime, password_last_used_time, password_last_used_saying) 
											VALUES 
											(NULL, $get_available_id, $inp_available_title_mysql, $inp_available_title_clean_mysql, $get_available_item_type_id, $inp_password_value_mysql, 1, '$datetime', '$time', '$date_saying', '$datetime', '$time', '$date_saying')")
											or die(mysqli_error($link));
										}
										else{
											$inp_password_count = $get_password_count+1;
											$result_update = mysqli_query($link, "UPDATE $t_edb_most_used_passwords SET password_available_title=$inp_available_title_mysql, password_available_title_clean=$inp_available_title_clean_mysql, password_count=$inp_password_count, password_last_used_datetime='$datetime', password_last_used_time='$time', password_last_used_saying='$date_saying' WHERE password_id=$get_password_id") or die(mysqli_error($link));
										}
							
									} // password changed, update most used passwords
								}
								elseif($get_available_type == "unlock_pattern"){
								
								}
							} // available
						} // distinct password sets

						// Send password to API
						include("open_case_evidence_edit_evidence_item_item_ping_new_passwords.php");

						$url = "open_case_usr_psw.php?case_id=$get_current_case_id&item_id=$get_current_item_id&password_set_number=$password_set_number&amp;l=$l&ft=success&fm=user_password_saved";
						header("Location: $url");
						exit;
					}

					echo"
					<h2>$l_edit</h2>


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

		
					<!-- Edit usr psw form -->

						<form method=\"POST\" action=\"open_case_usr_psw.php?case_id=$get_current_case_id&amp;action=$action&amp;item_id=$get_current_item_id&amp;password_set_number=$password_set_number&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
							<table>
							 <tr>";
						

						// Count number of password stored for this item
						$set_counter = 0;
						$count_availables = 0;
						$focus =  "";
						$query_set = "SELECT DISTINCT(password_set_number) FROM $t_edb_case_index_evidence_items_passwords WHERE password_case_id=$get_current_case_id AND password_item_id=$get_current_item_id";
						$result_set = mysqli_query($link, $query_set);
						while($row_set = mysqli_fetch_row($result_set)) {
							list($get_current_password_set_number) = $row_set;

							echo"
							  <td style=\"padding-right: 10px;vertical-align:top;\">";

							$query_av = "SELECT available_id, available_item_type_id, available_title, available_type, available_size, available_last_updated_datetime, available_last_updated_user_id FROM $t_edb_item_types_available_passwords WHERE available_item_type_id=$get_current_item_type_id";
							$result_av = mysqli_query($link, $query_av);
							while($row_av = mysqli_fetch_row($result_av)) {
								list($get_available_id, $get_available_item_type_id, $get_available_title, $get_available_type, $get_available_size, $get_available_last_updated_datetime, $get_available_last_updated_user_id) = $row_av;

								// Fetch data
								$query_psw = "SELECT password_id, password_case_id, password_item_id, password_available_id, password_item_type_id, password_set_number, password_value, password_created_by_user_id, password_created_by_user_name, password_created_datetime, password_updated_by_user_id, password_updated_by_user_name, password_updated_datetime FROM $t_edb_case_index_evidence_items_passwords WHERE password_case_id=$get_current_case_id AND password_item_id=$get_current_item_id AND password_available_id=$get_available_id AND password_item_type_id=$get_available_item_type_id AND password_set_number=$get_current_password_set_number";
								$result_psw = mysqli_query($link, $query_psw);
								$row_psw = mysqli_fetch_row($result_psw);
								list($get_password_id, $get_password_case_id, $get_password_item_id, $get_password_available_id, $get_password_item_type_id, $get_password_set_number, $get_password_value, $get_password_created_by_user_id, $get_password_created_by_user_name, $get_password_created_datetime, $get_password_updated_by_user_id, $get_password_updated_by_user_name, $get_password_updated_datetime) = $row_psw;
								if($get_password_id == ""){
									// Insert
									$inp_available_title_mysql = quote_smart($link, $get_available_title);
									mysqli_query($link, "INSERT INTO $t_edb_case_index_evidence_items_passwords 
									(password_id, password_case_id, password_item_id, password_available_id, password_available_title, password_item_type_id, password_set_number) 
									VALUES 
									(NULL, $get_current_case_id, $get_current_item_id, $get_available_id, $inp_available_title_mysql, $get_available_item_type_id, $get_current_password_set_number)")
									or die(mysqli_error($link));

									// Get new ID
									$query_psw = "SELECT password_id, password_case_id, password_item_id, password_available_id, password_item_type_id, password_set_number, password_value, password_created_by_user_id, password_created_by_user_name, password_created_datetime, password_updated_by_user_id, password_updated_by_user_name, password_updated_datetime FROM $t_edb_case_index_evidence_items_passwords WHERE password_case_id=$get_current_case_id AND password_item_id=$get_current_item_id AND password_available_id=$get_available_id AND password_item_type_id=$get_available_item_type_id AND password_set_number=$get_current_password_set_number";
									$result_psw = mysqli_query($link, $query_psw);
									$row_psw = mysqli_fetch_row($result_psw);
									list($get_password_id, $get_password_case_id, $get_password_item_id, $get_password_available_id, $get_password_item_type_id, $get_password_set_number, $get_password_value, $get_password_created_by_user_id, $get_password_created_by_user_name, $get_password_created_datetime, $get_password_updated_by_user_id, $get_password_updated_by_user_name, $get_password_updated_datetime) = $row_psw;
								}

								// Check set number
								if($set_counter != "$get_password_set_number"){
									$result_up = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items_passwords SET password_set_number=$set_counter WHERE password_id=$get_password_id");
								}

								if($get_available_type == "text" OR $get_available_type == "numeric"){
									if($focus == ""){
										echo"
										<!-- Focus -->
											<script>
												\$(document).ready(function(){
													\$('[name=\"inp_password_value_$get_password_id\"]').focus();
												});
											</script>
										<!-- //Focus -->
										";
										$focus = "inp_password_value_$get_password_id";
									}
									echo"
								
									<p><b>$get_available_title</b><br />
									<span><input type=\"text\" name=\"inp_password_value_$get_password_id\" size=\"$get_available_size\" value=\"$get_password_value\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" /></span>
									";
								}
								elseif($get_available_type == "unlock_pattern"){
									echo"
									<p><b>$get_available_title</b><br />
									(<a href=\"open_case_evidence_edit_evidence_item_item_unlock_pattern_selecter.php?case_id=$get_current_case_id&amp;item_id=$get_current_item_id&amp;mode=item&amp;password_id=$get_password_id&amp;l=$l\" target=\"_blank\">$l_select_pattern</a>)
									";
									if($get_password_value != ""){
										echo"<br />
										<a href=\"most_used_passwords_unlock_pattern_drawer_to_image.php?pattern=$get_password_value\">$get_password_value</a>";
									}
								}
								echo"
								</p>
								";
							} // available


							echo"
							  </td>
							";
							$set_counter++;
						} // distinct password sets

						echo"
							 </tr>
							</table>
						";

						echo"

						<p><input type=\"submit\" value=\"$l_save\" class=\"btn_default\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />

						</form>
						<div style=\"height: 10px;\"></div>
					<!-- //New usr psw form -->
					";
				} // usr_psw found
			} // action == edit_usr_psw
			elseif($action == "delete" && ($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor" OR $get_my_station_member_rank == "editor_limited")){
				// item id
				$item_id = $_GET['item_id'];
				$item_id = output_html($item_id);
				$item_id_mysql = quote_smart($link, $item_id);

				// password_set_number
				$password_set_number = $_GET['password_set_number'];
				$password_set_number = output_html($password_set_number);
				$password_set_number_mysql = quote_smart($link, $password_set_number);

				// Find that item
				$query = "SELECT item_id, item_case_id, item_record_id, item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number, item_title, item_parent_item_id, item_type_id, item_type_title, item_confirmed_by_human, item_human_rejected, item_request_text, item_requester_user_id, item_requester_user_name, item_requester_user_alias, item_requester_user_email, item_requester_user_image_path, item_requester_user_image_file, item_requester_user_image_thumb_40, item_requester_user_image_thumb_50, item_requester_user_first_name, item_requester_user_middle_name, item_requester_user_last_name, item_requester_user_job_title, item_requester_user_department, item_in_datetime, item_in_date, item_in_time, item_in_date_saying, item_in_date_ddmmyy, item_in_date_ddmmyyyy, item_storage_shelf_id, item_storage_shelf_title, item_storage_location_id, item_storage_location_abbr, item_comment, item_condition, item_serial_number, item_imei_a, item_imei_b, item_imei_c, item_imei_d, item_os_title, item_os_version, item_name, item_timezone, item_date_now_date, item_date_now_saying, item_date_now_ddmmyy, item_date_now_ddmmyyyy, item_time_now, item_correct_date_now_date, item_correct_date_now_saying, item_correct_date_now_ddmmyy, item_correct_date_now_ddmmyyyy, item_correct_time_now, item_adjust_clock_automatically, item_adjust_time_zone_automatically, item_acquired_software_id_a, item_acquired_software_title_a, item_acquired_software_notes_a, item_acquired_software_id_b, item_acquired_software_title_b, item_acquired_software_notes_b, item_acquired_software_id_c, item_acquired_software_title_c, item_acquired_software_notes_c, item_acquired_date, item_acquired_time, item_acquired_date_saying, item_acquired_date_ddmmyy, item_acquired_date_ddmmyyyy, item_acquired_user_id, item_acquired_user_name, item_acquired_user_alias, item_acquired_user_email, item_acquired_user_image_path, item_acquired_user_image_file, item_acquired_user_image_thumb_40, item_acquired_user_image_thumb_50, item_acquired_user_first_name, item_acquired_user_middle_name, item_acquired_user_last_name, item_out_date, item_out_time, item_out_date_saying, item_out_date_ddmmyy, item_out_date_ddmmyyyy, item_out_notes FROM $t_edb_case_index_evidence_items WHERE item_id=$item_id_mysql AND item_case_id=$get_current_case_id";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_current_item_id, $get_current_item_case_id, $get_current_item_record_id, $get_current_item_record_seized_year, $get_current_item_record_seized_journal, $get_current_item_record_seized_district_number, $get_current_item_numeric_serial_number, $get_current_item_title, $get_current_item_parent_item_id, $get_current_item_type_id, $get_current_item_type_title, $get_current_item_confirmed_by_human, $get_current_item_human_rejected, $get_current_item_request_text, $get_current_item_requester_user_id, $get_current_item_requester_user_name, $get_current_item_requester_user_alias, $get_current_item_requester_user_email, $get_current_item_requester_user_image_path, $get_current_item_requester_user_image_file, $get_current_item_requester_user_image_thumb_40, $get_current_item_requester_user_image_thumb_50, $get_current_item_requester_user_first_name, $get_current_item_requester_user_middle_name, $get_current_item_requester_user_last_name, $get_current_item_requester_user_job_title, $get_current_item_requester_user_department, $get_current_item_in_datetime, $get_current_item_in_date, $get_current_item_in_time, $get_current_item_in_date_saying, $get_current_item_in_date_ddmmyy, $get_current_item_in_date_ddmmyyyy, $get_current_item_storage_shelf_id, $get_current_item_storage_shelf_title, $get_current_item_storage_location_id, $get_current_item_storage_location_abbr, $get_current_item_comment, $get_current_item_condition, $get_current_item_serial_number, $get_current_item_imei_a, $get_current_item_imei_b, $get_current_item_imei_c, $get_current_item_imei_d, $get_current_item_os_title, $get_current_item_os_version, $get_current_item_name, $get_current_item_timezone, $get_current_item_date_now_date, $get_current_item_date_now_saying, $get_current_item_date_now_ddmmyy, $get_current_item_date_now_ddmmyyyy, $get_current_item_time_now, $get_current_item_correct_date_now_date, $get_current_item_correct_date_now_saying, $get_current_item_correct_date_now_ddmmyy, $get_current_item_correct_date_now_ddmmyyyy, $get_current_item_correct_time_now, $get_current_item_adjust_clock_automatically, $get_current_item_adjust_time_zone_automatically, $get_current_item_acquired_software_id_a, $get_current_item_acquired_software_title_a, $get_current_item_acquired_software_notes_a, $get_current_item_acquired_software_id_b, $get_current_item_acquired_software_title_b, $get_current_item_acquired_software_notes_b, $get_current_item_acquired_software_id_c, $get_current_item_acquired_software_title_c, $get_current_item_acquired_software_notes_c, $get_current_item_acquired_date, $get_current_item_acquired_time, $get_current_item_acquired_date_saying, $get_current_item_acquired_date_ddmmyy, $get_current_item_acquired_date_ddmmyyyy, $get_current_item_acquired_user_id, $get_current_item_acquired_user_name, $get_current_item_acquired_user_alias, $get_current_item_acquired_user_email, $get_current_item_acquired_user_image_path, $get_current_item_acquired_user_image_file, $get_current_item_acquired_user_image_thumb_40, $get_current_item_acquired_user_image_thumb_50, $get_current_item_acquired_user_first_name, $get_current_item_acquired_user_middle_name, $get_current_item_acquired_user_last_name, $get_current_item_out_date, $get_current_item_out_time, $get_current_item_out_date_saying, $get_current_item_out_date_ddmmyy, $get_current_item_out_date_ddmmyyyy, $get_current_item_out_notes) = $row;
	

				if($get_current_item_id == ""){
					echo"<p>Server error 404</p> <p>Item not found</p>";
				}
				else{

					if($process == "1"){

						// Print what we are deleting
						$query_av = "SELECT available_id, available_item_type_id, available_title, available_type, available_size, available_last_updated_datetime, available_last_updated_user_id FROM $t_edb_item_types_available_passwords WHERE available_item_type_id=$get_current_item_type_id";
						$result_av = mysqli_query($link, $query_av);
						while($row_av = mysqli_fetch_row($result_av)) {
							list($get_available_id, $get_available_item_type_id, $get_available_title, $get_available_type, $get_available_size, $get_available_last_updated_datetime, $get_available_last_updated_user_id) = $row_av;

							// Fetch data
							$query_psw = "SELECT password_id, password_case_id, password_item_id, password_available_id, password_item_type_id, password_set_number, password_value, password_created_by_user_id, password_created_by_user_name, password_created_datetime, password_updated_by_user_id, password_updated_by_user_name, password_updated_datetime FROM $t_edb_case_index_evidence_items_passwords WHERE password_case_id=$get_current_case_id AND password_item_id=$get_current_item_id AND password_available_id=$get_available_id AND password_item_type_id=$get_available_item_type_id AND password_set_number=$password_set_number_mysql";
							$result_psw = mysqli_query($link, $query_psw);
							$row_psw = mysqli_fetch_row($result_psw);
							list($get_password_id, $get_password_case_id, $get_password_item_id, $get_password_available_id, $get_password_item_type_id, $get_password_set_number, $get_password_value, $get_password_created_by_user_id, $get_password_created_by_user_name, $get_password_created_datetime, $get_password_updated_by_user_id, $get_password_updated_by_user_name, $get_password_updated_datetime) = $row_psw;
							if($get_password_id != ""){
								

								$result_delete = mysqli_query($link, "DELETE FROM $t_edb_case_index_evidence_items_passwords WHERE password_id=$get_password_id") or die(mysqli_error($link));

							}

						} // available

						$url = "open_case_usr_psw.php?case_id=$get_current_case_id&item_id=$get_current_item_id&password_set_number=$password_set_number&amp;l=$l&ft=success&fm=user_password_deleted";
						header("Location: $url");
						exit;
					}

					echo"
					<h2>$l_delete</h2>


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

		
					<!-- Delete usr psw form -->
						<p>$l_are_you_sure_you_want_to_delete</p>
						";
						

						// Print what we are deleting
						$query_av = "SELECT available_id, available_item_type_id, available_title, available_type, available_size, available_last_updated_datetime, available_last_updated_user_id FROM $t_edb_item_types_available_passwords WHERE available_item_type_id=$get_current_item_type_id";
						$result_av = mysqli_query($link, $query_av);
						while($row_av = mysqli_fetch_row($result_av)) {
							list($get_available_id, $get_available_item_type_id, $get_available_title, $get_available_type, $get_available_size, $get_available_last_updated_datetime, $get_available_last_updated_user_id) = $row_av;

							// Fetch data
							$query_psw = "SELECT password_id, password_case_id, password_item_id, password_available_id, password_item_type_id, password_set_number, password_value, password_created_by_user_id, password_created_by_user_name, password_created_datetime, password_updated_by_user_id, password_updated_by_user_name, password_updated_datetime FROM $t_edb_case_index_evidence_items_passwords WHERE password_case_id=$get_current_case_id AND password_item_id=$get_current_item_id AND password_available_id=$get_available_id AND password_item_type_id=$get_available_item_type_id AND password_set_number=$password_set_number_mysql";
							$result_psw = mysqli_query($link, $query_psw);
							$row_psw = mysqli_fetch_row($result_psw);
							list($get_password_id, $get_password_case_id, $get_password_item_id, $get_password_available_id, $get_password_item_type_id, $get_password_set_number, $get_password_value, $get_password_created_by_user_id, $get_password_created_by_user_name, $get_password_created_datetime, $get_password_updated_by_user_id, $get_password_updated_by_user_name, $get_password_updated_datetime) = $row_psw;
							if($get_password_id == ""){
								// Insert
								$inp_available_title_mysql = quote_smart($link, $get_available_title);
								mysqli_query($link, "INSERT INTO $t_edb_case_index_evidence_items_passwords 
								(password_id, password_case_id, password_item_id, password_available_id, password_available_title, password_item_type_id, password_set_number) 
								VALUES 
								(NULL, $get_current_case_id, $get_current_item_id, $get_available_id, $inp_available_title_mysql, $get_available_item_type_id, $get_current_password_set_number)")
								or die(mysqli_error($link));

								// Get new ID
								$query_psw = "SELECT password_id, password_case_id, password_item_id, password_available_id, password_item_type_id, password_set_number, password_value, password_created_by_user_id, password_created_by_user_name, password_created_datetime, password_updated_by_user_id, password_updated_by_user_name, password_updated_datetime FROM $t_edb_case_index_evidence_items_passwords WHERE password_case_id=$get_current_case_id AND password_item_id=$get_current_item_id AND password_available_id=$get_available_id AND password_item_type_id=$get_available_item_type_id AND password_set_number=$get_current_password_set_number";
								$result_psw = mysqli_query($link, $query_psw);
								$row_psw = mysqli_fetch_row($result_psw);
								list($get_password_id, $get_password_case_id, $get_password_item_id, $get_password_available_id, $get_password_item_type_id, $get_password_set_number, $get_password_value, $get_password_created_by_user_id, $get_password_created_by_user_name, $get_password_created_datetime, $get_password_updated_by_user_id, $get_password_updated_by_user_name, $get_password_updated_datetime) = $row_psw;
							}

							if($get_available_type == "text" OR $get_available_type == "numeric"){
								echo"
								<p><b>$get_available_title</b><br />
								$get_password_value
								</p>
								";
							}
							elseif($get_available_type == "unlock_pattern"){
								echo"
								<p><b>$get_available_title</b><br />
								";
								if($get_password_value != ""){
									echo"<br />
									$get_password_value";
								}
								echo"
								</p>
								";
							}
						} // available

						echo"

						<p>
						<a href=\"open_case_usr_psw.php?case_id=$get_current_case_id&amp;action=$action&amp;item_id=$get_current_item_id&amp;password_set_number=$password_set_number&amp;l=$l&amp;process=1\" class=\"btn_danger\">$l_delete</a>
						</p>

						<div style=\"height: 10px;\"></div>
					<!-- //Delete usr psw form -->
					";
				} // usr_psw found
			} // action == delete
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