<?php 
/**
*
* File: edb/open_case_overview.php
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

/*- Website config --------------------------------------------------------------------------- */
include("$root/_admin/_data/logo.php");


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
					<a href=\"open_case.php?case_id=$get_current_case_id&amp;l=$l\">$get_current_case_number</a>
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

	if($action == "" or $action == "create_new_user"){
		if($action == "create_new_user"){
			$inp_user_name = $_POST['inp_user_name'];
			$inp_user_name = preg_replace("/[^ \w]+/", "", $inp_user_name);
			$inp_user_name = output_html($inp_user_name);
			$inp_user_name = substr($inp_user_name, 0, 20);
			$inp_user_name_mysql = quote_smart($link, $inp_user_name);
			if(empty($inp_user_name)){
				$ft = "warning";
				$fm = "users_please_enter_a_user_name";
				$action = "";
			}


			$inp_email = $_POST['inp_email'];
			$inp_email = output_html($inp_email);
			$inp_email = strtolower($inp_email);
			$inp_email_mysql = quote_smart($link, $inp_email);
			if(empty($inp_email)){
				$ft = "warning";
				$fm = "users_please_enter_your_email_address";
				$action = "";
			}
			else{
				// Does that alias belong to someone else?
				$query = "SELECT user_id FROM $t_users WHERE user_name=$inp_user_name_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_user_id) = $row;
				if($get_user_id != ""){
					$ft = "warning";
					$fm = "users_name_taken";
					$action = "";
				}

				// Does that e-mail belong to someone else?
				$query = "SELECT user_id FROM $t_users WHERE user_email=$inp_email_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_user_id) = $row;
				if($get_user_id != ""){
					$ft = "warning";
					$fm = "users_email_taken";
					$action = "";
				}
			}

			$inp_password = $_POST['inp_password'];
			if(empty($inp_password)){
				$ft = "warning";
				$fm = "users_please_enter_a_password";
				
			}


			$inp_first_name = $_POST['inp_first_name'];
			$inp_first_name = output_html($inp_first_name);
			$inp_first_name_mysql = quote_smart($link, $inp_first_name);

			$inp_middle_name = $_POST['inp_middle_name'];
			$inp_middle_name = output_html($inp_middle_name);
			$inp_middle_name_mysql = quote_smart($link, $inp_middle_name);

			$inp_last_name = $_POST['inp_last_name'];
			$inp_last_name = output_html($inp_last_name);
			$inp_last_name_mysql = quote_smart($link, $inp_last_name);

			$inp_job_title = $_POST['inp_job_title'];
			$inp_job_title = output_html($inp_job_title);
			$inp_job_title_mysql = quote_smart($link, $inp_job_title);

			$inp_department = $_POST['inp_department'];
			$inp_department = output_html($inp_department);
			$inp_department_mysql = quote_smart($link, $inp_department);


			if($ft != "warning" && $ft != "error"){

				// Create salt
				$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    				$charactersLength = strlen($characters);
    				$salt = '';
    				for ($i = 0; $i < 6; $i++) {
        				$salt .= $characters[rand(0, $charactersLength - 1)];
    				}
				$inp_user_salt_mysql = quote_smart($link, $salt);

				// Password
				$inp_user_password_encrypted =  sha1($inp_password);
				$inp_user_password_mysql = quote_smart($link, $inp_user_password_encrypted);

				// Security
				$inp_user_security = rand(0,9999);

				// Language
				$l = output_html($l);
				$inp_user_language_mysql = quote_smart($link, $l);
				
				// Registered
				$datetime = date("Y-m-d H:i:s");
				$time = time();
				$date_saying = date("j M Y");
				$date_ddmmyy = date("d.m.y");

				// Measurement
				$inp_mesurment_mysql = quote_smart($link, "metric");

				// Date format
				if($l == "no"){
					$inp_user_date_format = "l d. f Y";
				}
				else{
					$inp_user_date_format = "l jS \of F Y";
				}
				$inp_user_date_format_mysql = quote_smart($link, $inp_user_date_format);


				// Ip
				$inp_user_last_ip_mysql = quote_smart($link, $inp_ip);


				// Insert user
				mysqli_query($link, "INSERT INTO $t_users
				(user_id, user_email, user_name, user_alias, user_password, user_salt, user_security, user_language, user_measurement, user_date_format, user_registered, user_registered_time, user_last_online, user_last_online_time, user_rank, user_points, user_points_rank, user_likes, user_dislikes, user_last_ip, user_marked_as_spammer) 
				VALUES 
				(NULL, $inp_email_mysql, $inp_user_name_mysql, $inp_user_name_mysql, $inp_user_password_mysql, $inp_user_salt_mysql, '$inp_user_security', $inp_user_language_mysql, $inp_mesurment_mysql, $inp_user_date_format_mysql, '$datetime', '$time', '$datetime', '$time', 'user', '0', 'Newbie', '0', '0', $inp_user_last_ip_mysql, '0')")
				or die(mysqli_error($link));

				// Get user id
				$query = "SELECT user_id FROM $t_users WHERE user_email=$inp_email_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_user_id) = $row;
			
				// Insert profile
				mysqli_query($link, "INSERT INTO $t_users_profile
				(profile_id, profile_user_id, profile_first_name, profile_middle_name, profile_last_name, profile_newsletter, profile_views, profile_privacy) 
				VALUES 
				(NULL, '$get_user_id', $inp_first_name_mysql, $inp_middle_name_mysql, $inp_last_name_mysql, 0, '0', 'public')")
				or die(mysqli_error($link));

				// Input professional
				mysqli_query($link, "INSERT INTO $t_users_professional
				(professional_id, professional_user_id, professional_company, professional_company_location, professional_department, professional_work_email, professional_position) 
				VALUES 
				(NULL, '$get_user_id', '', '', $inp_department_mysql, '', $inp_job_title_mysql)")
				or die(mysqli_error($link));

				
				// Send welcome mail
				$host = $_SERVER['HTTP_HOST'];

				$subject = $l_welcome_to_evidence_database_for . " " . $get_current_case_station_title;
			
				$message = "<html>\n";
				$message = $message. "<head>\n";
				$message = $message. "  <title>$subject</title>\n";
				$message = $message. " </head>\n";
				$message = $message. "<body>\n";

				$message = $message . "<p><a href=\"$configSiteURLSav\"><img src=\"$configSiteURLSav/$logoPathSav/$logoFileSav\" alt=\"($configWebsiteTitleSav logo)\" /></a></p>\n\n";
				$message = $message . "<h1>$l_welcome_to_evidence_database_for $get_current_case_station_title $l_at_lowercase $configWebsiteTitleSav</h1>\n\n";
				$message = $message . "<p>$l_hi $inp_user_name,<br /><br />\n";
				$message = $message . "$l_you_are_now_a_member_of_the_evidence_database\n";
				$message = $message . "$l_here_is_your_information</p>";

				$message = $message . "<p><b>$l_your_information</b><br />\n\n";
				$message = $message . "$l_email: $inp_email<br />\n";
				$message = $message . "$l_user_name: $inp_user_name</p>\n";

				$message = $message . "<p>\n\n--<br />\n$l_best_regards<br />\n$configWebsiteTitleSav<br />\n<a href=\"$configSiteURLSav\">$configSiteURLSav</a></p>";
				$message = $message. "</body>\n";
				$message = $message. "</html>\n";


				// Preferences for Subject field
				$headers[] = 'MIME-Version: 1.0';
				$headers[] = 'Content-type: text/html; charset=utf-8';
				$headers[] = "From: $configFromNameSav <" . $configFromEmailSav . ">";
				mail($inp_email, $subject, $message, implode("\r\n", $headers));


				// Image
				if(!(is_dir("$root/_uploads"))){
					mkdir("$root/_uploads");
				}
				if(!(is_dir("$root/_uploads/users"))){
					mkdir("$root/_uploads/users");
				}
				if(!(is_dir("$root/_uploads/users/images"))){
					mkdir("$root/_uploads/users/images");
				}
				if(!(is_dir("$root/_uploads/users/images/$get_user_id"))){
					mkdir("$root/_uploads/users/images/$get_user_id");
				}


				$ft_image = "";
				$fm_image = "";
				$image = $_FILES['inp_image']['name'];
				$uploadedfile = $_FILES['inp_image']['tmp_name'];
				
				$filename = stripslashes($_FILES['inp_image']['name']);
				$extension = get_extension($filename);
				$extension = strtolower($extension);

				if($image){

					if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
						$ft_image = "warning";
						$fm_image = "unknown_file_format";
						
					}
					else{
						$size=filesize($_FILES['inp_image']['tmp_name']);

						if($extension=="jpg" || $extension=="jpeg" ){
							ini_set ('gd.jpeg_ignore_warning', 1);
							error_reporting(0);
							$uploadedfile = $_FILES['inp_image']['tmp_name'];
							$src = imagecreatefromjpeg($uploadedfile);

						}
						elseif($extension=="png"){
							$uploadedfile = $_FILES['inp_image']['tmp_name'];
							$src = @imagecreatefrompng($uploadedfile);
						}
						else{
							$src = @imagecreatefromgif($uploadedfile);
						}
 
						list($width,$height) = @getimagesize($uploadedfile);

						if($width == "" OR $height == ""){
							$ft_image = "warning";
							$fm_image = "photo_could_not_be_uploaded_please_check_file_size";
					
						}
						else{
							// Keep orginal
							if($width > 969){
								$newwidth=970;
							}
							else{
								$newwidth=$width;
							}
							$newheight=round(($height/$width)*$newwidth, 0);
							$tmp_org =imagecreatetruecolor($newwidth,$newheight);

							imagecopyresampled($tmp_org,$src,0,0,0,0,$newwidth,$newheight, $width,$height);
	
							$datetime = date("ymdhis");
							$filename = "$root/_uploads/users/images/$get_user_id/". $get_user_id . "_" . $datetime . "." . $extension;

							imagejpeg($tmp_org,$filename,100);

							imagedestroy($tmp_org);

							// Insert to Mysql
							$inp_photo_destination = $get_user_id . "_" . $datetime . "." . $extension;
							$inp_photo_destination_mysql = quote_smart($link, $inp_photo_destination);
			
							// Thumb
							$inp_photo_thumb_a = $get_user_id . "_" . $datetime . "_40." . $extension;
							$inp_photo_thumb_a_mysql = quote_smart($link, $inp_photo_thumb_a);

							$inp_photo_thumb_b = $get_user_id . "_" . $datetime . "_50." . $extension;
							$inp_photo_thumb_b_mysql = quote_smart($link, $inp_photo_thumb_b);

							$inp_photo_thumb_c = $get_user_id . "_" . $datetime . "_60." . $extension;
							$inp_photo_thumb_c_mysql = quote_smart($link, $inp_photo_thumb_c);

							$inp_photo_thumb_d = $get_user_id . "_" . $datetime . "_200." . $extension;
							$inp_photo_thumb_d_mysql = quote_smart($link, $inp_photo_thumb_d);

							$inp_photo_uploaded = date("Y-m-d H:i:s");

							$inp_photo_uploaded_ip = $_SERVER['REMOTE_ADDR'];
							$inp_photo_uploaded_ip = output_html($inp_photo_uploaded_ip);
							$inp_photo_uploaded_ip_mysql = quote_smart($link, $inp_photo_uploaded_ip);

							$inp_title = "$l_profile_photo";
							$inp_title_mysql = quote_smart($link, $inp_title);

							mysqli_query($link, "INSERT INTO $t_users_profile_photo
							(photo_id, photo_user_id, photo_profile_image, photo_title, photo_destination, photo_thumb_40, photo_thumb_50, photo_thumb_60, photo_thumb_200, 
							photo_uploaded, photo_uploaded_ip, photo_views, photo_views_ip_block, photo_likes, photo_comments, photo_x_offset, photo_y_offset, photo_text) 
							VALUES 
							(NULL, '$get_user_id', '1', $inp_title_mysql, $inp_photo_destination_mysql, $inp_photo_thumb_a_mysql, $inp_photo_thumb_b_mysql, $inp_photo_thumb_c_mysql, $inp_photo_thumb_d_mysql,
							'$inp_photo_uploaded', $inp_photo_uploaded_ip_mysql, 0, '', '0', '0', '0', '0', '')")
							or die(mysqli_error($link));

							// Send feedback
							$ft_image = "success";
							$fm_image = "photo_uploaded";
						}  // if($width == "" OR $height == ""){
					}
				} // if($image){
				else{
					switch ($_FILES['inp_image']['error']) {
							case UPLOAD_ERR_OK:
           						$fm_image = "photo_unknown_error";
							break;
						case UPLOAD_ERR_NO_FILE:
           						$fm_image = "no_file_selected";
							break;
						case UPLOAD_ERR_INI_SIZE:
           						$fm_image = "photo_exceeds_filesize";
							break;
						case UPLOAD_ERR_FORM_SIZE:
           						$fm_image = "photo_exceeds_filesize_form";
							break;
						default:
           						$fm_image = "unknown_upload_error";
							break;
	
					}
					if(isset($fm_image) && $fm_image != ""){
						$ft_image  = "warning";
					}
				}

				// Get image (if any)
				$query = "SELECT photo_id, photo_user_id, photo_profile_image, photo_title, photo_destination, photo_thumb_40, photo_thumb_50, photo_thumb_60, photo_thumb_200, photo_uploaded, photo_uploaded_ip, photo_views, photo_views_ip_block, photo_likes, photo_comments, photo_x_offset, photo_y_offset, photo_text FROM $t_users_profile_photo WHERE photo_user_id=$get_user_id AND photo_profile_image='1'";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_photo_id, $get_photo_user_id, $get_photo_profile_image, $get_photo_title, $get_photo_destination, $get_photo_thumb_40, $get_photo_thumb_50, $get_photo_thumb_60, $get_photo_thumb_200, $get_photo_uploaded, $get_photo_uploaded_ip, $get_photo_views, $get_photo_views_ip_block, $get_photo_likes, $get_photo_comments, $get_photo_x_offset, $get_photo_y_offset, $get_photo_text) = $row;


				$inp_user_image_path = "_uploads/users/images/$get_user_id";
				$inp_user_image_path_mysql = quote_smart($link, $inp_user_image_path);

				$inp_user_image_file_mysql = quote_smart($link, $get_photo_destination);
				$inp_user_image_thumb_a_mysql = quote_smart($link, $get_photo_thumb_40);
				$inp_user_image_thumb_b_mysql = quote_smart($link, $get_photo_thumb_50);
				$inp_user_image_thumb_c_mysql = quote_smart($link, $get_photo_thumb_60);
				$inp_user_image_thumb_d_mysql = quote_smart($link, $get_photo_thumb_200);

				// Added by (me)
				$query = "SELECT user_id, user_email, user_name, user_alias, user_language, user_last_online, user_rank, user_login_tries FROM $t_users WHERE user_id=$my_user_id_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_my_user_id, $get_my_user_email, $get_my_user_name, $get_my_user_alias, $get_my_user_language, $get_my_user_last_online, $get_my_user_rank, $get_my_user_login_tries) = $row;
					
				// My photo
				$query = "SELECT photo_id, photo_destination, photo_thumb_40 FROM $t_users_profile_photo WHERE photo_user_id=$my_user_id_mysql AND photo_profile_image='1'";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_my_photo_id, $get_my_photo_destination, $get_my_photo_thumb_40) = $row;


				$inp_added_by_user_id_mysql = quote_smart($link, $get_my_user_id);
				$inp_added_by_user_name_mysql = quote_smart($link, $get_my_user_name);
				$inp_added_by_user_alias_mysql = quote_smart($link, $get_my_user_alias);
				$inp_added_by_user_image_mysql = quote_smart($link, $get_my_photo_destination);
				
				
				// Insert into station
				$inp_station_title_mysql = quote_smart($link, $get_current_case_station_title);
				$inp_district_title_mysql = quote_smart($link, $get_current_case_district_title);
				mysqli_query($link, "INSERT INTO $t_edb_stations_members
				(station_member_id, station_member_station_id, station_member_station_title, station_member_district_id, station_member_district_title, station_member_user_id, station_member_rank, station_member_user_name, station_member_user_alias, station_member_first_name, station_member_middle_name, station_member_last_name, station_member_user_email, station_member_user_image_path, station_member_user_image_file, station_member_user_image_thumb_40, station_member_user_image_thumb_50, station_member_user_image_thumb_60, station_member_user_image_thumb_200, station_member_user_position, station_member_user_department, station_member_added_datetime, station_member_added_date_saying, station_member_added_by_user_id, station_member_added_by_user_name, station_member_added_by_user_alias, station_member_added_by_user_image) 
				VALUES 
				(NULL, $get_current_case_station_id, $inp_station_title_mysql, $get_current_case_district_id, $inp_district_title_mysql, '$get_user_id', 'member', $inp_user_name_mysql, $inp_user_name_mysql, $inp_first_name_mysql, $inp_middle_name_mysql, $inp_last_name_mysql, $inp_email_mysql, $inp_user_image_path_mysql, $inp_user_image_file_mysql, $inp_user_image_thumb_a_mysql, $inp_user_image_thumb_b_mysql, $inp_user_image_thumb_c_mysql, $inp_user_image_thumb_d_mysql, $inp_job_title_mysql, $inp_department_mysql, '$datetime', '$date_saying', $inp_added_by_user_id_mysql, $inp_added_by_user_name_mysql, $inp_added_by_user_alias_mysql, $inp_added_by_user_image_mysql)")
				or die(mysqli_error($link));


				// Insert into district
				mysqli_query($link, "INSERT INTO $t_edb_districts_members
				(district_member_id, district_member_district_id, district_member_district_title, district_member_user_id, district_member_rank, 
				district_member_user_name, district_member_user_alias, district_member_user_first_name, district_member_user_middle_name, 
				district_member_user_last_name, district_member_user_email, district_member_user_image_path, district_member_user_image_file, district_member_user_image_thumb_40, 
				district_member_user_image_thumb_50, district_member_user_image_thumb_60, district_member_user_image_thumb_200, district_member_user_position, district_member_user_department, 
				district_member_added_datetime, district_member_added_date_saying, district_member_added_by_user_id, district_member_added_by_user_name, district_member_added_by_user_alias, 
				district_member_added_by_user_image) 
				VALUES 
				(NULL, $get_current_case_district_id, $inp_district_title_mysql, '$get_user_id', 'member', 
				$inp_user_name_mysql, $inp_user_name_mysql, $inp_first_name_mysql, $inp_middle_name_mysql, 
				$inp_last_name_mysql, $inp_email_mysql, $inp_user_image_path_mysql, $inp_user_image_file_mysql, $inp_user_image_thumb_a_mysql, 
				$inp_user_image_thumb_b_mysql, $inp_user_image_thumb_c_mysql, $inp_user_image_thumb_d_mysql, $inp_job_title_mysql, $inp_department_mysql, 
				'$datetime', '$date_saying', $inp_added_by_user_id_mysql, $inp_added_by_user_name_mysql, $inp_added_by_user_alias_mysql, 
				$inp_added_by_user_image_mysql)")
				or die(mysqli_error($link));


			


				// meta meta
				echo"
				<h1>$l_requester_created</h1>


				";
				if($ft_image != "" && $fm_image != ""){
					$fm_image = ucfirst($fm_image);
					$fm_image = str_replace("_", " ", $fm_image);
					echo"
					<div class=\"$ft_image\">$fm_image</div>
					";
				}

				echo"
				<p>
				<a href=\"$root/users/view_profile.php?user_id=$get_user_id&amp;l=$l\" class=\"btn_default\">$l_view_profile</a>
				</p>
				";

			} // ft != warning && ft != error

		}
		if($action == ""){
			echo"
			<h2>$l_new_requester</h2>

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

			<!-- Focus -->
				<script>
				\$(document).ready(function(){
					\$('[name=\"inp_user_name\"]').focus();
				});
				</script>
			<!-- //Focus -->
		
			<!-- New user form -->
			<form method=\"POST\" action=\"open_case_evidence_new_requester.php?case_id=$get_current_case_id&amp;action=create_new_user&amp;l=$l\" enctype=\"multipart/form-data\">

			<p><b>$l_user_name*:</b><br />
			<input type=\"text\" name=\"inp_user_name\" value=\""; if(isset($inp_user_name)){ echo"$inp_user_name"; } echo"\" size=\"25\" style=\"width: 100%;\" tabindex=\""; $tabindex++; echo"$tabindex\" />
			</p>

			<p><b>$l_email*:</b><br />
			<input type=\"text\" name=\"inp_email\" value=\""; if(isset($inp_email)){ echo"$inp_email"; } echo"\" size=\"25\" style=\"width: 100%;\" tabindex=\""; $tabindex++; echo"$tabindex\" />
			</p>

			<p><b>$l_password*:</b><br />";
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#/';
    			$charactersLength = strlen($characters);
    			$password = '';
    			for ($i = 0; $i < 10; $i++) {
        			$password .= $characters[rand(0, $charactersLength - 1)];
    			}
			
			echo"
			<input type=\"password\" name=\"inp_password\" value=\""; if(isset($inp_password)){ echo"$inp_password"; } echo"\" size=\"25\" style=\"width: 100%;\" tabindex=\""; $tabindex++; echo"$tabindex\" /><br />
			$l_suggestion: $password
			</p>

			<p><b>$l_first_name:</b><br />
			<input type=\"text\" name=\"inp_first_name\" value=\""; if(isset($inp_first_name)){ echo"$inp_first_name"; } echo"\" size=\"25\" style=\"width: 100%;\" tabindex=\""; $tabindex++; echo"$tabindex\" />
			</p>

			<p><b>$l_middle_name:</b><br />
			<input type=\"text\" name=\"inp_middle_name\" value=\""; if(isset($inp_middle_name)){ echo"$inp_middle_name"; } echo"\" size=\"25\" style=\"width: 100%;\" tabindex=\""; $tabindex++; echo"$tabindex\" />
			</p>

			<p><b>$l_last_name:</b><br />
			<input type=\"text\" name=\"inp_last_name\" value=\""; if(isset($inp_last_name)){ echo"$inp_last_name"; } echo"\" size=\"25\" style=\"width: 100%;\" tabindex=\""; $tabindex++; echo"$tabindex\" />
			</p>

			<p><b>$l_job_title:</b><br />
			<input type=\"text\" name=\"inp_job_title\" value=\""; if(isset($inp_job_title)){ echo"$inp_job_title"; } echo"\" size=\"25\" style=\"width: 100%;\" tabindex=\""; $tabindex++; echo"$tabindex\" />
			</p>

			<p><b>$l_department:</b><br />
			<input type=\"text\" name=\"inp_department\" value=\""; if(isset($inp_department)){ echo"$inp_department"; } echo"\" size=\"25\" style=\"width: 100%;\" tabindex=\""; $tabindex++; echo"$tabindex\" />
			</p>

			<p><b>$l_image (970x970):</b><br />
			<input name=\"inp_image\" type=\"file\" tabindex=\""; $tabindex++; echo"$tabindex\" />
			</p>

			<p>
			<input type=\"submit\" value=\"$l_save\" class=\"btn_default\" />
			</p>
			<!-- //New user form -->
			";
		} // action still == ""
	} // action == "" OR action == "create_new_user"

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