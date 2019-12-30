<?php 
/**
*
* File: edb/open_case_review_matrix_jquery_save.php
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


/*- Tables ---------------------------------------------------------------------------- */
$t_edb_review_matrix_titles = $mysqlPrefixSav . "edb_review_matrix_titles";
$t_edb_review_matrix_fields = $mysqlPrefixSav . "edb_review_matrix_fields";

$t_edb_case_index_review_notes			= $mysqlPrefixSav . "edb_case_index_review_notes";
$t_edb_case_index_review_matrix_titles		= $mysqlPrefixSav . "edb_case_index_review_matrix_titles";
$t_edb_case_index_review_matrix_fields		= $mysqlPrefixSav . "edb_case_index_review_matrix_fields";
$t_edb_case_index_review_matrix_values		= $mysqlPrefixSav . "edb_case_index_review_matrix_values";
$t_edb_case_index_review_matrix_items		= $mysqlPrefixSav . "edb_case_index_review_matrix_items";


/*- Variables -------------------------------------------------------------------------- */
if(isset($_POST['case_id'])) {
	$case_id = $_POST['case_id'];
	$case_id = strip_tags(stripslashes($case_id));
}
else{
	$case_id = "";
}
$case_id_mysql = quote_smart($link, $case_id);



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
			";
		} // access to station denied
		else{
			// Body
			$query = "SELECT matrix_item_id, matrix_item_case_id, matrix_item_item_id, matrix_item_record_id, matrix_item_record_seized_year, matrix_item_record_seized_journal, matrix_item_record_seized_district_number, matrix_item_numeric_serial_number, matrix_item_title FROM $t_edb_case_index_review_matrix_items WHERE matrix_item_case_id=$get_current_case_id ORDER BY matrix_item_record_seized_year, matrix_item_record_seized_journal, matrix_item_record_seized_district_number, matrix_item_numeric_serial_number ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_matrix_item_id, $get_matrix_item_case_id, $get_matrix_item_item_id, $get_matrix_item_record_id, $get_matrix_item_record_seized_year, $get_matrix_item_record_seized_journal, $get_matrix_item_record_seized_district_number, $get_matrix_item_numeric_serial_number, $get_matrix_item_title) = $row;
			
				$query_fields = "SELECT field_id, field_case_id, field_name, field_title_id, field_title_name, field_weight, field_type, field_size, field_alt_a, field_alt_b, field_alt_c, field_alt_d, field_alt_e, field_alt_f, field_alt_g, field_alt_h, field_alt_i, field_alt_j, field_alt_k, field_alt_l, field_alt_m FROM $t_edb_case_index_review_matrix_fields WHERE field_case_id=$get_current_case_id ORDER BY field_title_id, field_weight ASC";
				$result_fields = mysqli_query($link, $query_fields);
				while($row_fields = mysqli_fetch_row($result_fields)) {
					list($get_field_id, $get_field_case_id, $get_field_name, $get_field_title_id, $get_field_title_name, $get_field_weight, $get_field_type, $get_field_size, $get_field_alt_a, $get_field_alt_b, $get_field_alt_c, $get_field_alt_d, $get_field_alt_e, $get_field_alt_f, $get_field_alt_g, $get_field_alt_h, $get_field_alt_i, $get_field_alt_j, $get_field_alt_k, $get_field_alt_l, $get_field_alt_m) = $row_fields;

							
					if(isset($_POST["inp_text_$get_matrix_item_id" . "_$get_field_id"])){
						$inp_text = $_POST["inp_text_$get_matrix_item_id" . "_$get_field_id"];
					}
					else{
						$inp_text = "";
					}
					$inp_text = output_html($inp_text);
					$inp_text_mysql = quote_smart($link, $inp_text);

					// Check if exists, if not then create it
					$query_value = "SELECT value_id, value_case_id, value_text, value_item_id, value_title_id, value_field_id FROM $t_edb_case_index_review_matrix_values WHERE value_case_id=$get_current_case_id AND value_item_id=$get_matrix_item_id AND value_title_id=$get_field_title_id AND value_field_id=$get_field_id";
					$result_value = mysqli_query($link, $query_value);
					$row_value = mysqli_fetch_row($result_value);
					list($get_value_id, $get_value_case_id, $get_value_text, $get_value_item_id, $get_value_title_id, $get_value_field_id) = $row_value;
					if($get_value_id == ""){
						mysqli_query($link, "INSERT INTO $t_edb_case_index_review_matrix_values 
						(value_id, value_case_id, value_text, value_item_id, value_title_id, value_field_id) 
						VALUES 
						(NULL, $get_current_case_id, $inp_text_mysql, $get_matrix_item_id, $get_field_title_id, $get_field_id)")
						or die(mysqli_error($link)); 
					}
					else{
						$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_review_matrix_values SET value_text=$inp_text_mysql WHERE value_id=$get_value_id") or die(mysqli_error($link));
					}

				} // fields
			} // Evidence items

			$time = date("H:i:s");
			echo"
			<div class=\"success\"><p>Saved $time</p></div>
			";
	
		} // access to station
	} // case found

} // logged in
else{
	// Log in
	echo"
	<div class=\"error\"><p>Not logged in!</p></div>
	";
} // not logged in
?>