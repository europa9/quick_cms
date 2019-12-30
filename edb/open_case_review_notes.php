<?php 
/**
*
* File: edb/open_case_review_notes.php
* Version 2.0
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
$t_edb_case_index_review_notes			= $mysqlPrefixSav . "edb_case_index_review_notes";
$t_edb_case_index_review_matrix_titles		= $mysqlPrefixSav . "edb_case_index_review_matrix_index";
$t_edb_case_index_review_matrix_fields		= $mysqlPrefixSav . "edb_case_index_review_matrix_fields";
$t_edb_case_index_review_matrix_contents	= $mysqlPrefixSav . "edb_case_index_review_matrix_contents";


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
		$website_title = "$l_edb - $get_current_case_district_title - $get_current_case_station_title - $get_current_case_number - $l_review_notes";
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
					<a href=\"open_case_review_notes.php?case_id=$get_current_case_id&amp;l=$l\">$l_review_notes</a>
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


				// Me
				$query = "SELECT user_id, user_email, user_name, user_alias, user_language, user_last_online, user_rank, user_login_tries FROM $t_users WHERE user_id=$my_user_id_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_my_user_id, $get_my_user_email, $get_my_user_name, $get_my_user_alias, $get_my_user_language, $get_my_user_last_online, $get_my_user_rank, $get_my_user_login_tries) = $row;
					
				// My photo
				$query = "SELECT photo_id, photo_destination, photo_thumb_40, photo_thumb_50 FROM $t_users_profile_photo WHERE photo_user_id=$my_user_id_mysql AND photo_profile_image='1'";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_my_photo_id, $get_my_photo_destination, $get_my_photo_thumb_40, $get_my_photo_thumb_50) = $row;

				// My Profile
				$query = "SELECT profile_id, profile_first_name, profile_middle_name, profile_last_name, profile_about FROM $t_users_profile WHERE profile_user_id=$my_user_id_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_my_profile_id, $get_my_profile_first_name, $get_my_profile_middle_name, $get_my_profile_last_name, $get_my_profile_about) = $row;

				$inp_my_user_name_mysql = quote_smart($link, $get_my_user_name);
				$inp_my_user_alias_mysql = quote_smart($link, $get_my_user_alias);
				$inp_my_user_email_mysql = quote_smart($link, $get_my_user_email);
				$inp_my_user_rank_mysql = quote_smart($link, $get_my_user_rank);

				$inp_my_user_image_path = "_uploads/users/images/$get_my_user_id";
				$inp_my_user_image_path_mysql = quote_smart($link, $inp_my_user_image_path);

				$inp_my_user_image_file_mysql = quote_smart($link, $get_my_photo_destination);

				$inp_my_user_image_thumb_a_mysql = quote_smart($link, $get_my_photo_thumb_40);
				$inp_my_user_image_thumb_b_mysql = quote_smart($link, $get_my_photo_thumb_50);

				$inp_my_user_first_name_mysql = quote_smart($link, $get_my_profile_first_name);
				$inp_my_user_middle_name_mysql = quote_smart($link, $get_my_profile_middle_name);
				$inp_my_user_last_name_mysql = quote_smart($link, $get_my_profile_last_name);

				// Dates
				$inp_datetime = date("Y-m-d H:i:s");
				$inp_date = date("Y-m-d");
				$inp_time = time();
				$inp_date_saying = date("j M Y");
				$inp_date_ddmmyy = date("d.m.y");
				$inp_date_ddmmyyyy = date("d.m.Y");



				// Fetch notes
				$query = "SELECT review_id, review_case_id, review_text, review_updated_datetime, review_updated_date, review_updated_time, review_updated_saying, review_updated_ddmmyy, review_updated_ddmmyyyy, review_updated_by_user_id, review_updated_by_user_rank, review_updated_by_user_name, review_updated_by_user_alias, review_updated_by_user_email, review_updated_by_user_image_path, review_updated_by_user_image_file, review_updated_by_user_image_thumb_40, review_updated_by_user_image_thumb_50, review_updated_by_user_first_name, review_updated_by_user_middle_name, review_updated_by_user_last_name FROM $t_edb_case_index_review_notes WHERE review_case_id=$get_current_case_id";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_current_review_id, $get_current_review_case_id, $get_current_review_text, $get_current_review_updated_datetime, $get_current_review_updated_date, $get_current_review_updated_time, $get_current_review_updated_saying, $get_current_review_updated_ddmmyy, $get_current_review_updated_ddmmyyyy, $get_current_review_updated_by_user_id, $get_current_review_updated_by_user_rank, $get_current_review_updated_by_user_name, $get_current_review_updated_by_user_alias, $get_current_review_updated_by_user_email, $get_current_review_updated_by_user_image_path, $get_current_review_updated_by_user_image_file, $get_current_review_updated_by_user_image_thumb_40, $get_current_review_updated_by_user_image_thumb_50, $get_current_review_updated_by_user_first_name, $get_current_review_updated_by_user_middle_name, $get_current_review_updated_by_user_last_name) = $row;
				if($get_current_review_id == ""){


					// Insert
					mysqli_query($link, "INSERT INTO $t_edb_case_index_review_notes
					(review_id, review_case_id, review_text, review_updated_datetime, review_updated_date, 
					review_updated_time, review_updated_saying, review_updated_ddmmyy, review_updated_ddmmyyyy, review_updated_by_user_id, 
					review_updated_by_user_rank, review_updated_by_user_name, review_updated_by_user_alias, review_updated_by_user_email, review_updated_by_user_image_path, review_updated_by_user_image_file, review_updated_by_user_image_thumb_40, review_updated_by_user_image_thumb_50, review_updated_by_user_first_name, review_updated_by_user_middle_name, review_updated_by_user_last_name) 
					VALUES 
					(NULL, $get_current_case_id, '', '$inp_datetime', '$inp_date', 
					'$inp_time', '$inp_date_saying', '$inp_date_ddmmyy', '$inp_date_ddmmyyyy', $get_my_user_id, 
					$inp_my_user_rank_mysql, $inp_my_user_name_mysql, $inp_my_user_alias_mysql, $inp_my_user_email_mysql, $inp_my_user_image_path_mysql, $inp_my_user_image_file_mysql, $inp_my_user_image_thumb_a_mysql, $inp_my_user_image_thumb_b_mysql, $inp_my_user_first_name_mysql, $inp_my_user_middle_name_mysql, $inp_my_user_last_name_mysql)")
					or die(mysqli_error($link));

					// Get ID
					$query = "SELECT review_id FROM $t_edb_case_index_review_notes WHERE review_case_id=$get_current_case_id";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_current_review_id) = $row;

				}
		

				// Process
				if($process == "1" && ($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor" OR $get_my_station_member_rank == "editor_limited")){
					// Save notes
					$inp_text = $_POST['inp_text'];
			
					$sql = "UPDATE $t_edb_case_index_review_notes SET review_text=? WHERE review_id=$get_current_review_id";
					$stmt = $link->prepare($sql);
					$stmt->bind_param("s", $inp_text);
					$stmt->execute();
					if ($stmt->errno) {
						echo "FAILURE!!! " . $stmt->error; die;
					}

					// Update meta data
					$result = mysqli_query($link, "UPDATE $t_edb_case_index_review_notes SET 
							review_updated_datetime='$inp_datetime', 
							review_updated_date='$inp_date', 
							review_updated_time='$inp_time', 
							review_updated_saying='$inp_date_saying', 
							review_updated_ddmmyy='$inp_date_ddmmyy', 
							review_updated_ddmmyyyy='$inp_date_ddmmyyyy', 
							review_updated_by_user_id=$get_my_user_id, 
							review_updated_by_user_rank=$inp_my_user_rank_mysql,
							review_updated_by_user_name=$inp_my_user_name_mysql, 
							review_updated_by_user_alias=$inp_my_user_alias_mysql, 
							review_updated_by_user_email=$inp_my_user_email_mysql, 
							review_updated_by_user_image_path=$inp_my_user_image_path_mysql, 
							review_updated_by_user_image_file=$inp_my_user_image_file_mysql, 
							review_updated_by_user_image_thumb_40=$inp_my_user_image_thumb_a_mysql, 
							review_updated_by_user_image_thumb_50=$inp_my_user_image_thumb_b_mysql, 
							review_updated_by_user_first_name=$inp_my_user_first_name_mysql, 
							review_updated_by_user_middle_name=$inp_my_user_middle_name_mysql, 
							review_updated_by_user_last_name=$inp_my_user_last_name_mysql 
							 WHERE review_id=$get_current_review_id") or die(mysqli_error($link));


					// Menu counter
					$query = "SELECT menu_counter_id, menu_counter_reviews FROM $t_edb_case_index_open_case_menu_counters WHERE menu_counter_case_id=$get_current_case_id";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_current_menu_counter_id, $get_current_menu_counter_reviews) = $row;

					$counter = $get_current_menu_counter_reviews+1;
					$result = mysqli_query($link, "UPDATE $t_edb_case_index_open_case_menu_counters SET menu_counter_reviews=$counter WHERE menu_counter_case_id=$get_current_case_id");

					$url = "open_case_review_notes.php?case_id=$get_current_case_id&l=$l&ft=success&fm=changes_saved";
					header("Location: $url");
					exit;

			
				}

				echo"
				<h2>$l_review_notes</h2>
		
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
					<!-- TinyMCE -->
						<script type=\"text/javascript\" src=\"$root/_admin/_javascripts/tinymce/tinymce.min.js\"></script>
						<script>
						tinymce.init({
							selector: 'textarea.editor',
							plugins: 'print preview searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern help',
							toolbar: 'formatselect | bold italic strikethrough forecolor backcolor permanentpen formatpainter | link image media pageembed | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent | removeformat | addcomment',
							image_advtab: true,
							content_css: [
								'$root/_admin/_javascripts/tinymce_includes/fonts/lato/lato_300_300i_400_400i.css',
								'$root/_admin/_javascripts/tinymce_includes/codepen.min.css'
							],";

							$count_photos = 0;
							$image_list = "";
							$query = "SELECT photo_id, photo_case_id, photo_path, photo_file, photo_ext, photo_thumb_60, photo_thumb_200, photo_title, photo_description, photo_uploaded_datetime, photo_weight FROM $t_edb_case_index_photos WHERE photo_case_id=$get_current_case_id ORDER BY photo_id DESC";
							$result = mysqli_query($link, $query);
							while($row = mysqli_fetch_row($result)) {
								list($get_photo_id, $get_photo_case_id, $get_photo_path, $get_photo_file, $get_photo_ext, $get_photo_thumb_60, $get_photo_thumb_200, $get_photo_title, $get_photo_description, $get_photo_uploaded_datetime, $get_photo_weight) = $row;

								if($count_photos == "0"){
									$image_list  = "{ title: '$get_photo_title', value: '$root/$get_photo_path/$get_photo_file' }";
								}
								else{
									$image_list  = $image_list  . ",\n" . "								{ title: '$get_photo_title', value: '$root/$get_photo_path/$get_photo_file' }";
								}
								$count_photos++;
							}
							if($count_photos != "0"){
								echo"
								image_list: [
									$image_list  
								],
								";
							}
							echo"
							importcss_append: true,
							height: 600
						});
						</script>
					<!-- //TinyMCE -->

					<!-- Focus -->
						<script>
						\$(document).ready(function(){
							\$('[name=\"inp_text\"]').focus();
						});
						</script>
					<!-- //Focus -->
				
						<!-- Edit page Form -->
						<form method=\"POST\" action=\"open_case_review_notes.php?case_id=$get_current_case_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
	
						<p>
						<textarea name=\"inp_text\" id=\"inp_text\" class=\"editor\" cols=\"40\" style=\"width: 100%;min-height:500px\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\">";
						if($get_current_review_text == ""){
							$get_current_review_text = "<p><b>$inp_date_ddmmyy $get_my_user_name</b><br />-</p>";
						}
						echo"$get_current_review_text</textarea>
						</p>

						<p>
						<input type=\"submit\" value=\"$l_save_changes\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
						</p>
						</form>
					<!-- //Edit page Form -->
					";
				} // can edit
				else{
					echo"$get_current_review_text";
				}
			} // action == ""

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