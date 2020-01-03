<?php 
/**
*
* File: edb/open_case_photos.php
* Version 1.0
* Date 13:06 25.08.2019
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
					&gt;
					<a href=\"open_case_photos.php?case_id=$get_current_case_id&amp;l=$l\">$l_photos</a>
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

				if($process == "1"){

					// Create dir
					if(!is_dir("$root/_uploads")){
						mkdir("$root/_uploads");
					}
					if(!is_dir("$root/_uploads/edb")){
						mkdir("$root/_uploads/edb");
					}
					if(!is_dir("$root/_uploads/edb/case_$get_current_case_id")){
						mkdir("$root/_uploads/edb/case_$get_current_case_id");
					}
					if(!is_dir("$root/_uploads/edb/case_$get_current_case_id/photos")){
						mkdir("$root/_uploads/edb/case_$get_current_case_id/photos");
					}

					$tmp_name = $_FILES["inp_image"]["tmp_name"];
					$filename = stripslashes($_FILES['inp_image']['name']);
					$extension = get_extension($filename);
					$extension = strtolower($extension);
					$inp_extension = output_html($extension);
					$inp_extension_mysql = quote_smart($link, $inp_extension);

					$inp_title = $_POST['inp_title'];
					if($inp_title == ""){
						$inp_title = "$filename";
					}
					$inp_title = output_html($inp_title);
					$inp_title_mysql = quote_smart($link, $inp_title);

					$inp_file_path = "_uploads/edb/case_$get_current_case_id/photos";
					$inp_file_path_mysql = quote_smart($link, $inp_file_path);


					// Transfer
					$ft = "";
					$fm = "";
				
					if($filename){
						if ($extension == "jpg" OR $extension == "jpeg" OR $extension == "png" OR $extension == "gif") {
							$inp_type = "image";
							$inp_type_mysql = quote_smart($link, $inp_type);

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
								$ft = "warning";
								$fm = "photo_could_not_be_uploaded_please_check_file_size";
							}
							else{
								$datetime = date("Y-m-d H:i:s");

								mysqli_query($link, "INSERT INTO $t_edb_case_index_photos
								(photo_id, photo_case_id, photo_path, photo_file, photo_ext, photo_thumb_60, photo_thumb_200, photo_title, photo_description, photo_uploaded_datetime) 
								VALUES 
								(NULL, $get_current_case_id, $inp_file_path_mysql, '', $inp_extension_mysql, '', '', $inp_title_mysql, '', '$datetime')")
								or die(mysqli_error($link));
						
								// Get ID
								$q = "SELECT photo_id FROM $t_edb_case_index_photos WHERE photo_case_id=$get_current_case_id AND photo_uploaded_datetime='$datetime'";
								$r = mysqli_query($link, $q);
								$rowb = mysqli_fetch_row($r);
								list($get_current_photo_id) = $rowb;

						

								// Update values
								$inp_file_name = $get_current_photo_id . "." . $extension;
								$inp_file_name_mysql = quote_smart($link, $inp_file_name);

								$inp_file_thumb_a = $get_current_photo_id . "_thumb_60." . $extension;
								$inp_file_thumb_a_mysql = quote_smart($link, $inp_file_thumb_a);

								$inp_file_thumb_b = $get_current_photo_id . "_thumb_200." . $extension;
								$inp_file_thumb_b_mysql = quote_smart($link, $inp_file_thumb_b);

								$result = mysqli_query($link, "UPDATE $t_edb_case_index_photos SET
									photo_file=$inp_file_name_mysql,
									photo_thumb_60=$inp_file_thumb_a_mysql,
									photo_thumb_200=$inp_file_thumb_b_mysql
									 WHERE photo_id=$get_current_photo_id");


								if(move_uploaded_file($tmp_name, "../$inp_file_path/$inp_file_name")){
								
									// Header
									$ft = "success";
									$fm = "image_uploaded";

								} // move_uploaded_file
								else{
									$ft = "warning";
									$fm = "move_uploaded_file_failed";
								} // move_uploaded_file failed
							}  // if($width == "" OR $height == ""){
						}
					} // image
					else{
						switch ($_FILES['inp_image']['error']) {
							case UPLOAD_ERR_OK:
								$fm = "photo_unknown_error";
								$ft = "warning";
								break;
							case UPLOAD_ERR_NO_FILE:
       								$fm = "no_file_selected";
								$ft = "warning";
								break;
							case UPLOAD_ERR_INI_SIZE:
           							$fm = "photo_exceeds_filesize";
								$ft = "warning";
								break;
							case UPLOAD_ERR_FORM_SIZE:
           							$fm_front = "photo_exceeds_filesize_form";
								$ft = "warning";
								break;
							default:
           							$fm_front = "unknown_upload_error";
								$ft = "warning";
								break;
						}


					} // else

	

					$url = "open_case_photos.php?case_id=$get_current_case_id&l=$l&ft=$ft&fm=$fm";
					header("Location: $url");
					exit;
				}
			

				echo"
				<h2>$l_photos</h2>
		
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

				<!-- Upload form -->
					";
					if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor" OR $get_my_station_member_rank == "editor_limited"){
						echo"
						<form method=\"POST\" action=\"open_case_photos.php?case_id=$get_current_case_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
						<table>
						 <tr>
						  <td style=\"padding-right: 4px;\">
							<p style=\"padding-bottom:0;margin-bottom:0;\">$l_file:</p>
					 	 </td>
						  <td style=\"padding-right: 4px;\">
							<p style=\"padding-bottom:0;margin-bottom:0;\">$l_title:</p>
						  </td>
						  <td style=\"padding-right: 4px;\">
						
						  </td>
						 </tr>
						 <tr>
						  <td style=\"padding-right: 4px;\">
							<p style=\"padding-top:0;margin-top:0;\"><input name=\"inp_image\" type=\"file\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
						  </td>
						  <td style=\"padding-right: 4px;\">
							<p style=\"padding-top:0;margin-top:0;\"><input type=\"text\" name=\"inp_title\" value=\"\" size=\"10\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
						  </td>
						  <td style=\"padding-right: 4px;\">
							<p style=\"padding-top:0;margin-top:0;\"><input type=\"submit\" value=\"$l_upload\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
						  </td>
						 </tr>
						</table>
						</form>
						";
					}
					echo"
				<!-- //Upload form -->
			
				<!-- Photos -->
				";
					$x = 0;
					$count_photos = 0;
					$query = "SELECT photo_id, photo_case_id, photo_path, photo_file, photo_ext, photo_thumb_60, photo_thumb_200, photo_title, photo_description, photo_uploaded_datetime, photo_weight FROM $t_edb_case_index_photos WHERE photo_case_id=$get_current_case_id ORDER BY photo_id DESC";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_photo_id, $get_photo_case_id, $get_photo_path, $get_photo_file, $get_photo_ext, $get_photo_thumb_60, $get_photo_thumb_200, $get_photo_title, $get_photo_description, $get_photo_uploaded_datetime, $get_photo_weight) = $row;


						// Look for image
						if(!(file_exists("$root/$get_photo_path/$get_photo_file")) OR $get_photo_file == ""){
							echo"<div class=\"info\"><p>Image doesnt exists. Deleting database reference.</p></div>\n";
							$result_delete = mysqli_query($link, "DELETE FROM $t_edb_case_index_photos WHERE photo_id=$get_photo_id");
						}
	
						// Look for thumb
						if(!(file_exists("$root/$get_photo_path/$get_photo_thumb_200")) && $get_photo_thumb_200 != ""){
							resize_crop_image(200, 200, "$root/$get_photo_path/$get_photo_file", "$root/$get_photo_path/$get_photo_thumb_200");
						}

						// Layout
						if($x == 0){
							echo"
							<div class=\"image_gallery_folder_browse_row\">
							";
						}
						echo"
								<div class=\"image_gallery_folder_browse_col\">
									<p>
									<a href=\"open_case_photos.php?case_id=$get_current_case_id&amp;photo_id=$get_photo_id&amp;action=view_photo&amp;l=$l\"><img src=\"$root/$get_photo_path/$get_photo_thumb_200\" alt=\"$get_photo_thumb_200\" /></a><br />
									<a href=\"open_case_photos.php?case_id=$get_current_case_id&amp;photo_id=$get_photo_id&amp;action=view_photo&amp;l=$l\">$get_photo_title</a>
									</p>
								</div>
						";

						// Layout
						if($x == 3){
							echo"
							</div>
							";
							$x = -1;
						}
						$x++;
						$count_photos = $count_photos + 1;

						// Weight
						if($get_photo_weight != "$count_photos"){
							$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_photos SET
									photo_weight=$count_photos
									 WHERE photo_id=$get_photo_id");

						}
					}
					if($count_photos != "$get_current_menu_counter_photos"){
						$result = mysqli_query($link, "UPDATE $t_edb_case_index_open_case_menu_counters SET menu_counter_photos=$count_photos WHERE menu_counter_case_id=$get_current_case_id");
					}
					if($x == "1"){
						echo"
								<div class=\"image_gallery_folder_browse_col\">
								</div>
								<div class=\"image_gallery_folder_browse_col\">
								</div>
								<div class=\"image_gallery_folder_browse_col\">
								</div>
						";
					}
					elseif($x == "2"){
						echo"
								<div class=\"image_gallery_folder_browse_col\">
								</div>
								<div class=\"image_gallery_folder_browse_col\">
								</div>
						";
					}
					elseif($x == "3"){
						echo"
								<div class=\"image_gallery_folder_browse_col\">
								</div>
						";
					}
					
					if($x != 0){
						echo"
							</div>
						";
					}
				echo"
				<!-- //Photos -->
				";
			} // action == ""
			elseif($action == "view_photo"){
				if(isset($_GET['photo_id'])) {
					$photo_id = $_GET['photo_id'];
					$photo_id = stripslashes(strip_tags($photo_id));
				}
				else{
					$photo_id = "";
				}
				$photo_id_mysql = quote_smart($link, $photo_id);

				$query = "SELECT photo_id, photo_case_id, photo_path, photo_file, photo_ext, photo_thumb_60, photo_thumb_200, photo_title, photo_description, photo_uploaded_datetime, photo_weight FROM $t_edb_case_index_photos WHERE photo_id=$photo_id_mysql AND photo_case_id=$get_current_case_id ";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_current_photo_id, $get_current_photo_case_id, $get_current_photo_path, $get_current_photo_file, $get_current_photo_ext, $get_current_photo_thumb_60, $get_current_photo_thumb_200, $get_current_photo_title, $get_current_photo_description, $get_current_photo_uploaded_datetime, $get_current_photo_weight) = $row;
				if($get_current_photo_id == ""){
					echo"photo not found";
				}
				else{
					// Next photo
					$next_weight = $get_current_photo_weight+1;

					$query = "SELECT photo_id, photo_case_id, photo_path, photo_file, photo_ext, photo_thumb_60, photo_thumb_200, photo_title, photo_description, photo_uploaded_datetime FROM $t_edb_case_index_photos WHERE photo_case_id=$get_current_case_id AND photo_weight = $next_weight LIMIT 0,1";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_next_photo_id, $get_next_photo_case_id, $get_next_photo_path, $get_next_photo_file, $get_next_photo_ext, $get_next_photo_thumb_60, $get_next_photo_thumb_200, $get_next_photo_title, $get_next_photo_description, $get_next_photo_uploaded_datetime) = $row;

					// Previous photo
					$previous_weight = $get_current_photo_weight-1;
					$query = "SELECT photo_id, photo_case_id, photo_path, photo_file, photo_ext, photo_thumb_60, photo_thumb_200, photo_title, photo_description, photo_uploaded_datetime FROM $t_edb_case_index_photos WHERE photo_case_id=$get_current_case_id AND photo_weight = $previous_weight LIMIT 0,1";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_previous_photo_id, $get_previous_photo_case_id, $get_previous_photo_path, $get_previous_photo_file, $get_previous_photo_ext, $get_previous_photo_thumb_60, $get_previous_photo_thumb_200, $get_previous_photo_title, $get_previous_photo_description, $get_previous_photo_uploaded_datetime) = $row;


					echo"
					<!-- Previous, title, next -->
						<table style=\"width: 100%;\">
						 <tr>
						  <td style=\"width:33%;\">
							";
							if($get_previous_photo_id != ""){
								echo"
								<a href=\"open_case_photos.php?case_id=$get_current_case_id&amp;photo_id=$get_previous_photo_id&amp;action=view_photo&amp;l=$l\">$l_previous</a><br />
								";
							}
							echo"
						  </td>
						  <td style=\"text-align: center;width:31%;\">
							<h2>$get_current_photo_title</h2>
						  </td>
						  <td style=\"width:33%;text-align: right;\">
							";
							if($get_next_photo_id != ""){
								echo"
								<a href=\"open_case_photos.php?case_id=$get_current_case_id&amp;photo_id=$get_next_photo_id&amp;action=view_photo&amp;l=$l\">$l_next</a><br />
								";
							}
							echo"
						  </td>
						 </tr>
						</table>
					<!-- //Previous, title, next -->
					
					

					<p><img src=\"$root/$get_current_photo_path/$get_current_photo_file\" alt=\"$get_current_photo_file\" /></p>
					";
					if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor" OR $get_my_station_member_rank == "editor_limited"){
						echo"
						<p>
						<a href=\"open_case_photos.php?case_id=$get_current_case_id&amp;photo_id=$get_current_photo_id&amp;action=edit_photo&amp;l=$l\">$l_edit</a>
						&middot;
						<a href=\"open_case_photos.php?case_id=$get_current_case_id&amp;photo_id=$get_current_photo_id&amp;action=rotate_photo&amp;l=$l&amp;process=1\">$l_rotate</a>
						&middot;
						<a href=\"open_case_photos.php?case_id=$get_current_case_id&amp;photo_id=$get_current_photo_id&amp;action=delete_photo&amp;l=$l\">$l_delete</a>
						</p>";
					}
				}
				
			} // action == "view_photo"
			elseif($action == "edit_photo" && ($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor" OR $get_my_station_member_rank == "editor_limited")){
				if(isset($_GET['photo_id'])) {
					$photo_id = $_GET['photo_id'];
					$photo_id = stripslashes(strip_tags($photo_id));
				}
				else{
					$photo_id = "";
				}
				$photo_id_mysql = quote_smart($link, $photo_id);

				$query = "SELECT photo_id, photo_case_id, photo_path, photo_file, photo_ext, photo_thumb_60, photo_thumb_200, photo_title, photo_description, photo_uploaded_datetime FROM $t_edb_case_index_photos WHERE photo_id=$photo_id_mysql AND photo_case_id=$get_current_case_id ";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_current_photo_id, $get_current_photo_case_id, $get_current_photo_path, $get_current_photo_file, $get_current_photo_ext, $get_current_photo_thumb_60, $get_current_photo_thumb_200, $get_current_photo_title, $get_current_photo_description, $get_current_photo_uploaded_datetime) = $row;
				if($get_current_photo_id == ""){
					echo"photo not found";
				}
				else{
					if($process == "1"){

						$inp_title = $_POST['inp_title'];
						$inp_title = output_html($inp_title);
						$inp_title_mysql = quote_smart($link, $inp_title);

						$inp_description = $_POST['inp_description'];
						$inp_description = output_html($inp_description);
						$inp_description_mysql = quote_smart($link, $inp_description);

						$result = mysqli_query($link, "UPDATE $t_edb_case_index_photos SET
									photo_title=$inp_title_mysql,
									photo_description=$inp_description_mysql 
									 WHERE photo_id=$get_current_photo_id");

						$url = "open_case_photos.php?case_id=$get_current_case_id&photo_id=$get_current_photo_id&action=edit_photo&l=$l&ft=success&fm=changes_saved";
						header("Location: $url");
						exit;
					}
					echo"
					<h2>$l_edit $get_current_photo_title</h2>

					<!-- Focus -->
						<script>
						\$(document).ready(function(){
							\$('[name=\"inp_title\"]').focus();
						});
						</script>
					<!-- //Focus -->
					<form method=\"POST\" action=\"open_case_photos.php?case_id=$get_current_case_id&amp;photo_id=$get_current_photo_id&amp;action=edit_photo&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
								  
					<p>$l_photo:<br />
					<img src=\"$root/$get_current_photo_path/$get_current_photo_thumb_200\" alt=\"$get_current_photo_thumb_200\" />
					</p>

					<p>$l_title:<br />
					<input type=\"text\" name=\"inp_title\" value=\"$get_current_photo_title\" size=\"25\" style=\"width: 50%;\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />	
					</p>
					
					<p>$l_description:<br />
					<textarea name=\"inp_description\" rows=\"4\" cols=\"80\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\">";
					$get_current_photo_description = str_replace("<br />", "\n", $get_current_photo_description);
					echo"$get_current_photo_description</textarea>
					</p>

					<p><input type=\"submit\" value=\"$l_save\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
					</form>

					<!-- Back -->
						<p>
						<a href=\"open_case_photos.php?case_id=$get_current_case_id&amp;photo_id=$get_current_photo_id&amp;l=$l\"><img src=\"_gfx/go-previous.png\" alt=\"go-previous.png\" /></a>
						<a href=\"open_case_photos.php?case_id=$get_current_case_id&amp;photo_id=$get_current_photo_id&amp;l=$l\">$l_photos</a>
						&nbsp;
						<a href=\"open_case_photos.php?case_id=$get_current_case_id&amp;photo_id=$get_current_photo_id&amp;action=view_photo&amp;l=$l\"><img src=\"_gfx/go-previous.png\" alt=\"go-previous.png\" /></a>
						<a href=\"open_case_photos.php?case_id=$get_current_case_id&amp;photo_id=$get_current_photo_id&amp;action=view_photo&amp;l=$l\">$get_current_photo_title</a>
						</p>
					<!-- //Back -->
					";
				}
			} // action == "edit photo
			elseif($action == "rotate_photo" && ($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor" OR $get_my_station_member_rank == "editor_limited")){
				if(isset($_GET['photo_id'])) {
					$photo_id = $_GET['photo_id'];
					$photo_id = stripslashes(strip_tags($photo_id));
				}
				else{
					$photo_id = "";
				}
				$photo_id_mysql = quote_smart($link, $photo_id);

				$query = "SELECT photo_id, photo_case_id, photo_path, photo_file, photo_ext, photo_thumb_60, photo_thumb_200, photo_title, photo_description, photo_uploaded_datetime FROM $t_edb_case_index_photos WHERE photo_id=$photo_id_mysql AND photo_case_id=$get_current_case_id ";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_current_photo_id, $get_current_photo_case_id, $get_current_photo_path, $get_current_photo_file, $get_current_photo_ext, $get_current_photo_thumb_60, $get_current_photo_thumb_200, $get_current_photo_title, $get_current_photo_description, $get_current_photo_uploaded_datetime) = $row;
				if($get_current_photo_id == ""){
					echo"photo not found";
				}
				else{
					if(file_exists("$root/$get_current_photo_path/$get_current_photo_thumb_60") && $get_current_photo_thumb_60 != ""){
						unlink("$root/$get_current_photo_path/$get_current_photo_thumb_60");
					}
					if(file_exists("$root/$get_current_photo_path/$get_current_photo_thumb_200") && $get_current_photo_thumb_200 != ""){
						unlink("$root/$get_current_photo_path/$get_current_photo_thumb_200");
					}


					// Rotate
					if($get_current_photo_ext == "jpg"){
						// Load
						$source = imagecreatefromjpeg("$root/$get_current_photo_path/$get_current_photo_file");

						// Rotate
						$rotate = imagerotate($source, -90, 0);

						// Save
						imagejpeg($rotate, "$root/$get_current_photo_path/$get_current_photo_file");
					}
					elseif($get_current_photo_ext == "png"){
						// Load
						$source = imagecreatefrompng("$root/$get_current_photo_path/$get_current_photo_file");

						// Bg
						$bgColor = imagecolorallocatealpha($source, 255, 255, 255, 127);

						// Rotate
						$rotate = imagerotate($source, -90, $bgColor);
	
						// Save
						imagesavealpha($rotate, true);
						imagepng($rotate, "$root/$get_current_photo_path/$get_current_photo_file");
					}
					else{
						echo"Unknown extension";
						die;
					}


					// Give new name
					$random = rand(0,1000);

					$inp_file_thumb_a = $get_current_photo_id . "_" . $random . "_thumb_60." . $extension;
					$inp_file_thumb_a_mysql = quote_smart($link, $inp_file_thumb_a);

					$inp_file_thumb_b = $get_current_photo_id . "_" . $random . "_thumb_200." . $extension;
					$inp_file_thumb_b_mysql = quote_smart($link, $inp_file_thumb_a);


					$result = mysqli_query($link, "UPDATE $t_edb_case_index_photos SET
									photo_file=$inp_file_name_mysql,
									photo_thumb_60=$inp_file_thumb_a_mysql,
									photo_thumb_200=$inp_file_thumb_b_mysql
									 WHERE photo_id=$get_current_photo_id");

					$url = "open_case_photos.php?case_id=$get_current_case_id&photo_id=$get_current_photo_id&action=view_photo&l=$l&ft=success&fm=rotated";
					header("Location: $url");
					exit;


				}
			} // $action == "rotate_photo"){
			elseif($action == "delete_photo" && ($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor" OR $get_my_station_member_rank == "editor_limited")){
				if(isset($_GET['photo_id'])) {
					$photo_id = $_GET['photo_id'];
					$photo_id = stripslashes(strip_tags($photo_id));
				}
				else{
					$photo_id = "";
				}
				$photo_id_mysql = quote_smart($link, $photo_id);

				$query = "SELECT photo_id, photo_case_id, photo_path, photo_file, photo_ext, photo_thumb_60, photo_thumb_200, photo_title, photo_description, photo_uploaded_datetime FROM $t_edb_case_index_photos WHERE photo_id=$photo_id_mysql AND photo_case_id=$get_current_case_id ";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_current_photo_id, $get_current_photo_case_id, $get_current_photo_path, $get_current_photo_file, $get_current_photo_ext, $get_current_photo_thumb_60, $get_current_photo_thumb_200, $get_current_photo_title, $get_current_photo_description, $get_current_photo_uploaded_datetime) = $row;
				if($get_current_photo_id == ""){
					echo"photo not found";
				}
				else{
					if($process == "1"){

						if(file_exists("$root/$get_current_photo_path/$get_current_photo_file") && $get_current_photo_file != ""){
							unlink("$root/$get_current_photo_path/$get_current_photo_file");
						}
						if(file_exists("$root/$get_current_photo_path/$get_current_photo_thumb_60") && $get_current_photo_thumb_60 != ""){
							unlink("$root/$get_current_photo_path/$get_current_photo_thumb_60");
						}
						if(file_exists("$root/$get_current_photo_path/$get_current_photo_thumb_200") && $get_current_photo_thumb_200 != ""){
							unlink("$root/$get_current_photo_path/$get_current_photo_thumb_200");
						}
						

						$result = mysqli_query($link, "DELETE FROM $t_edb_case_index_photos WHERE photo_id=$get_current_photo_id");

						$url = "open_case_photos.php?case_id=$get_current_case_id&l=$l&ft=success&fm=deleted";
						header("Location: $url");
						exit;
					}
					echo"
					<h2>$l_delete $get_current_photo_title</h2>

						  
					<p>$l_photo:<br />
					<img src=\"$root/$get_current_photo_path/$get_current_photo_thumb_200\" alt=\"$get_current_photo_thumb_200\" />
					</p>

					<p>$l_are_you_sure_you_want_to_delete_the_photo 
					</p>

					<p>
					<a href=\"open_case_photos.php?case_id=$get_current_case_id&amp;photo_id=$get_current_photo_id&amp;action=delete_photo&amp;l=$l&amp;process=1\" class=\"btn_danger\">$l_delete</a>
					<a href=\"open_case_photos.php?case_id=$get_current_case_id&amp;photo_id=$get_current_photo_id&amp;action=view_photo&amp;l=$l\" class=\"btn_default\">$l_cancel</a>
					</p>
					";
				}
			} // action == "delete photo
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