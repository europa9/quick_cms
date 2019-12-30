<?php 
/**
*
* File: edb/open_case_evidence_matrix.php
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
include("$root/_admin/_translations/site/$l/edb/ts_open_case_overview.php");
include("$root/_admin/_translations/site/$l/users/ts_users.php");


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


/*- Tables ----------------------------------------------------------------------------------- */
$t_edb_case_index_matrix_names			= $mysqlPrefixSav . "edb_case_index_matrix_names";
$t_edb_case_index_matrix_header 		= $mysqlPrefixSav . "edb_case_index_matrix_header";
$t_edb_case_index_matrix_body_titles 		= $mysqlPrefixSav . "edb_case_index_matrix_body_titles";
$t_edb_case_index_matrix_body_values 		= $mysqlPrefixSav . "edb_case_index_matrix_body_values";



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
		$website_title = "$l_edb - $get_current_case_district_title - $get_current_case_station_title - $get_current_case_number - $l_evidence_matrix";
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

	
			// Matrix name
			$query = "SELECT matrix_name_id, matrix_name_case_id, matrix_name_name FROM $t_edb_case_index_matrix_names WHERE matrix_name_case_id=$get_current_case_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_matrix_name_id, $get_current_matrix_name_case_id, $get_current_matrix_name_name) = $row;
			if($get_current_matrix_name_id == ""){
				$inp_default_name_mysql = quote_smart($link, $l_evidence_matrix);
				mysqli_query($link, "INSERT INTO $t_edb_case_index_matrix_names 
					(matrix_name_id, matrix_name_case_id, matrix_name_name) 
					VALUES 
					(NULL, $get_current_case_id, $inp_default_name_mysql)")
					or die(mysqli_error($link));
			}
			

			// Process
			if($process == "1" && ($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor" OR $get_my_station_member_rank == "editor_limited")){

				// Matrix name
				$inp_matrix_name_name = $_POST['inp_matrix_name_name'];
				$inp_matrix_name_name = output_html($inp_matrix_name_name);
				$inp_matrix_name_name_mysql = quote_smart($link, $inp_matrix_name_name);
					
				$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_matrix_names SET 
									matrix_name_name=$inp_matrix_name_name_mysql 
									WHERE matrix_name_id=$get_current_matrix_name_id") or die(mysqli_error($link));


				// Header updates
				$query = "SELECT header_id, header_content FROM $t_edb_case_index_matrix_header WHERE header_case_id=$get_current_case_id ORDER BY header_weight ASC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_header_id, $get_header_content) = $row;

					$inp_header = $_POST["inp_header_$get_header_id"];
					$inp_header = output_html($inp_header);
					$inp_header_mysql = quote_smart($link, $inp_header);
					
					$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_matrix_header SET 
									header_content=$inp_header_mysql
									WHERE header_id=$get_header_id") or die(mysqli_error($link));
					// Focus
					if($inp_header != "$get_header_content"){
						$focus = "inp_header_$get_header_id";
					}
				}

				// New header
				$inp_header_new = $_POST['inp_header_new'];
				$inp_header_new = output_html($inp_header_new);
				$inp_header_new_mysql = quote_smart($link, $inp_header_new);
				if($inp_header_new != ""){
					mysqli_query($link, "INSERT INTO $t_edb_case_index_matrix_header 
								(header_id, header_case_id, header_weight, header_content) 
								VALUES 
								(NULL, $get_current_case_id, 999, $inp_header_new_mysql)")
								or die(mysqli_error($link));
					$focus = "inp_header_new";
				}

				// Body titles
				$count_body_titles = 0;
				$query = "SELECT body_title_id, body_title_case_id, body_title_evidence_id, body_title_name, body_title_weight FROM $t_edb_case_index_matrix_body_titles WHERE body_title_case_id=$get_current_case_id ORDER BY body_title_weight ASC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_body_title_id, $get_body_title_case_id, $get_body_title_evidence_id, $get_body_title_name, $get_body_title_weight) = $row;

					$inp_body_title_name = $_POST["inp_body_title_name_$get_body_title_id"];
					$inp_body_title_name = output_html($inp_body_title_name);
					$inp_body_title_name_mysql = quote_smart($link, $inp_body_title_name);
					
					$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_matrix_body_titles SET 
									body_title_name=$inp_body_title_name_mysql
									WHERE body_title_id=$get_body_title_id") or die(mysqli_error($link));
					// Focus
					if($inp_body_title_name != "$get_body_title_name"){
						$focus = "inp_body_title_name_$get_body_title_id";
					}


					$count_body_titles = $count_body_titles+1;
				}
				$result = mysqli_query($link, "UPDATE $t_edb_case_index_open_case_menu_counters SET menu_counter_evidence_matrix=$count_body_titles WHERE menu_counter_case_id=$get_current_case_id");


				// New body titles
				$inp_body_title_new = $_POST['inp_body_title_new'];
				$inp_body_title_new = output_html($inp_body_title_new);
				$inp_body_title_new_mysql = quote_smart($link, $inp_body_title_new );

				if($inp_body_title_new != ""){
					mysqli_query($link, "INSERT INTO $t_edb_case_index_matrix_body_titles
								(body_title_id, body_title_case_id, body_title_evidence_id, body_title_name, body_title_weight) 
								VALUES 
								(NULL, $get_current_case_id, 0, $inp_body_title_new_mysql, 999)")
								or die(mysqli_error($link));
					$focus = "inp_body_title_new";
				}



				// Body values
				$query = "SELECT body_value_id, body_value_content FROM $t_edb_case_index_matrix_body_values WHERE body_value_case_id=$get_current_case_id ORDER BY body_value_weight ASC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_body_id, $get_body_content) = $row;
					
					$inp_body = $_POST["inp_body_value_$get_body_id"];
					$inp_body = output_html($inp_body);
					$inp_body_mysql = quote_smart($link, $inp_body);

					
					$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_matrix_body_values SET 
							body_value_content=$inp_body_mysql
							WHERE body_value_id=$get_body_id") or die(mysqli_error($link));

					// Focus
					if($inp_body != "$get_body_content"){
						$focus = "inp_body_value_$get_body_id";
					}
				}
	
				// Are all body values present?

				// Headers
				$query_headers = "SELECT header_id, header_content FROM $t_edb_case_index_matrix_header WHERE header_case_id=$get_current_case_id ORDER BY header_weight ASC";
				$result_headers = mysqli_query($link, $query_headers);
				while($row_headers = mysqli_fetch_row($result_headers)) {
					list($get_header_id, $get_header_content) = $row_headers;

					$query_body_titles = "SELECT body_title_id, body_title_case_id, body_title_evidence_id, body_title_name, body_title_weight FROM $t_edb_case_index_matrix_body_titles WHERE body_title_case_id=$get_current_case_id ORDER BY body_title_weight ASC";
					$result_body_titles = mysqli_query($link, $query_body_titles);
						while($row_body_titles = mysqli_fetch_row($result_body_titles)) {
						list($get_body_title_id, $get_body_title_case_id, $get_body_title_evidence_id, $get_body_title_name, $get_body_title_weight) = $row_body_titles;
					

						// Body value exists?
						$query = "SELECT body_value_id FROM $t_edb_case_index_matrix_body_values WHERE body_value_case_id=$get_current_case_id AND body_value_body_title_id=$get_body_title_id AND body_value_header_id=$get_header_id";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_body_value_id) = $row;
						if($get_body_value_id == ""){

							mysqli_query($link, "INSERT INTO $t_edb_case_index_matrix_body_values 
								(body_value_id, body_value_case_id, body_value_body_title_id, body_value_header_id, body_value_weight) 
								VALUES 
								(NULL, $get_current_case_id, $get_body_title_id, $get_header_id, 999)")
								or die(mysqli_error($link));
						}
					}
				} // body titles
				

				$save_time = date("H:i:s");
				$url = "open_case_evidence_matrix.php?case_id=$get_current_case_id&l=$l&ft=success&fm=changes_saved_$save_time";
				if(isset($focus)){
					$url = $url. "&focus=$focus";
				}
				header("Location: $url");
				exit;
			}
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
					<a href=\"open_case_evidence_matrix.php?case_id=$get_current_case_id&amp;l=$l\">$l_evidence_matrix</a>
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
			
			
			echo"
			<h2>$l_matrix</h2>
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
			
			";
			if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor" OR $get_my_station_member_rank == "editor_limited"){
				echo"
				<form method=\"POST\" action=\"open_case_evidence_matrix.php?case_id=$get_current_case_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
				<p>
				$l_name: <input type=\"text\" name=\"inp_matrix_name_name\" value=\"$get_current_matrix_name_name\" size=\"16\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" style=\"width: 50%;\" />
				</p>";
			}
			else{
				echo"
				<h3>$get_current_matrix_name_name</h3>
				";
			}
			echo"

			<!-- List of all items -->
				";
				if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor" OR $get_my_station_member_rank == "editor_limited"){
					

					if(isset($_GET['focus'])){
						$focus = $_GET['focus'];
						$focus = output_html($focus);
						echo"

						<script>
						\$(document).ready(function(){
							\$('[name=\"$focus\"]').focus();
							});
						</script>
						";
					}
				}
				echo"
				<div style=\"height: 10px;\"></div>
				<table class=\"hor-zebra\">
				 <thead>
				  <tr>
				   <th scope=\"col\">
				   </th>";
					// Row 0
					$header_counter = 0;
					$query = "SELECT header_id, header_case_id, header_weight, header_content, header_style_class, header_bg_color, header_txt_color, header_link_color, header_border FROM $t_edb_case_index_matrix_header WHERE header_case_id=$get_current_case_id ORDER BY header_weight ASC";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_header_id, $get_header_case_id, $get_header_weight, $get_header_content, $get_header_style_class, $get_header_bg_color, $get_header_txt_color, $get_header_link_color, $get_header_border) = $row;

						echo"
						   <th scope=\"col\">
							<span>";
							if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor" OR $get_my_station_member_rank == "editor_limited"){
								echo"<input type=\"text\" name=\"inp_header_$get_header_id\" value=\"$get_header_content\" size=\"20\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
							}
							else{
								echo"$get_header_content";
							}
							echo"</span>
						   </th>
						";

						// Header weight
						if($header_counter  != "$get_header_weight"){
							$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_matrix_header SET 
									header_weight=$header_counter
									WHERE header_id=$get_header_id") or die(mysqli_error($link));
						}
						$header_counter++;







					}
				if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor" OR $get_my_station_member_rank == "editor_limited"){
					echo"
					   <th scope=\"col\">
						<!-- New row=0, col=1 -->
						<span><input type=\"text\" name=\"inp_header_new\" value=\"\" size=\"16\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" /></span>
						<!-- New row=0, col=1 -->
					   </th>
					";
				}
				echo"
				 </thead>


				 <tbody>
				";

				

				// Body titles
				$body_counter = 0; // for transfer to new body title
				$query = "SELECT body_title_id, body_title_case_id, body_title_evidence_id, body_title_name, body_title_weight FROM $t_edb_case_index_matrix_body_titles WHERE body_title_case_id=$get_current_case_id ORDER BY body_title_weight ASC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_body_title_id, $get_body_title_case_id, $get_body_title_evidence_id, $get_body_title_name, $get_body_title_weight) = $row;


					if(isset($style) && $style == ""){
						$style = "odd";
					}
					else{
						$style = "";
					}
					echo"
					  <tr>
					   <td class=\"$style\">
						<span>";
						if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor" OR $get_my_station_member_rank == "editor_limited"){
							echo"<input type=\"text\" name=\"inp_body_title_name_$get_body_title_id\" value=\"$get_body_title_name\" size=\"20\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
						}
						else{
							echo"$get_body_title_name";
						}
						echo"</span>
					   </td>
					";

					$body_counter = 1;
					$query_b = "SELECT body_value_id, body_value_case_id, body_value_body_title_id, body_value_header_id, body_value_weight, body_value_content, body_value_style_class, body_value_bg_color, body_value_txt_color, body_link_color, body_value_border FROM $t_edb_case_index_matrix_body_values WHERE body_value_case_id=$get_current_case_id AND body_value_body_title_id=$get_body_title_id ORDER BY body_value_weight ASC";
					$result_b = mysqli_query($link, $query_b);
					while($row_b = mysqli_fetch_row($result_b)) {
						list($get_body_value_id, $get_body_value_case_id, $get_body_value_body_title_id, $get_body_value_header_id, $get_body_value_weight, $get_body_value_content, $get_body_value_style_class, $get_body_value_bg_color, $get_body_value_txt_color, $get_body_link_color, $get_body_value_border) = $row_b;
					
						echo"
						   <td class=\"$style\">
							<span>";
							if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor" OR $get_my_station_member_rank == "editor_limited"){
								echo"<input type=\"text\" name=\"inp_body_value_$get_body_value_id\" value=\"$get_body_value_content\" size=\"20\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
							}
							else{
								echo"$get_body_value_content";
							}
							echo"</span>
							
						   </td>
						";
						// Body weight
						if($body_counter  != "$get_body_value_weight"){
							$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_matrix_body_values SET 
									body_value_weight=$body_counter
									WHERE body_value_id=$get_body_value_id") or die(mysqli_error($link));
						}
						$body_counter++;
					}

					if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor" OR $get_my_station_member_rank == "editor_limited"){		
						echo"
						   <td class=\"$style\">
						
						   </td>
						";
					}
					echo"
					  </tr>
					";
					$body_counter = $body_counter+1;
				}

				// New title
				if(isset($style) && $style == ""){
					$style = "odd";
				}
				else{
					$style = "";
				}
				echo"
					  <tr>
					   <td class=\"$style\">
						<!-- New body title -->
						<span><input type=\"text\" name=\"inp_body_title_new\" value=\"\" size=\"20\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" /></span>
						<!-- New body title -->
					   </td>";
				$body_counter = $body_counter-2;
				for($x=0;$x<$body_counter;$x++){
					echo"
					   <td class=\"$style\">
					   </td>";	
				}
				echo"
					   <td class=\"$style\">
					   </td>
					  </tr>
				";

				echo"
				 </tbody>
				</table>

				<!-- Save -->

					";
					if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor" OR $get_my_station_member_rank == "editor_limited"){
						echo"
						<p>
						<input type=\"submit\" value=\"$l_save_changes\" class=\"btn_default\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
						</p>
						</form>
						";
					}
					echo"

				<!-- //Save -->
			<!-- List of all items -->
			";

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