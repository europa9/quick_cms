<?php 
/**
*
* File: edb/open_case_index.php
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

if(isset($_GET['q']) && $_GET['q'] != ''){
	$q = $_GET['q'];
	$q = strip_tags(stripslashes($q));
	$q = trim($q);
	$q = strtolower($q);
	$q = output_html($q);
	$q = $q . "%";
	$part_mysql = quote_smart($link, $q);


	//get matched data from skills table
	$last_user_name = "";
	$count_results = 0;
	$query = "SELECT station_member_id, station_member_user_id, station_member_rank, station_member_user_name, station_member_user_alias, station_member_first_name, station_member_middle_name, station_member_last_name, station_member_user_email, station_member_user_image_path, station_member_user_image_file, station_member_user_image_thumb_40, station_member_user_image_thumb_50, station_member_user_image_thumb_60 FROM $t_edb_stations_members WHERE station_member_user_name LIKE $part_mysql OR station_member_first_name LIKE $part_mysql OR station_member_last_name LIKE $part_mysql";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_station_member_id, $get_station_member_user_id, $get_station_member_rank, $get_station_member_user_name, $get_station_member_user_alias, $get_station_member_first_name, $get_station_member_middle_name, $get_station_member_last_name, $get_station_member_user_email, $get_station_member_user_image_path, $get_station_member_user_image_file, $get_station_member_user_image_thumb_40, $get_station_member_user_image_thumb_50, $get_station_member_user_image_thumb_60) = $row;


		if($last_user_name != "$get_station_member_user_name"){
			echo"			";
			echo"
			<table>
			 <tr>
			  <td style=\"padding-right: 5px;\">
				<!-- Img -->
				<p>";
				if($get_station_member_user_image_file != "" && file_exists("$root/$get_station_member_user_image_path/$get_station_member_user_image_file")){
					if(file_exists("$root/$get_station_member_user_image_path/$get_station_member_user_image_thumb_50") && $get_station_member_user_image_thumb_50 != ""){
						echo"
						<a href=\"#\" data-divid=\"$get_station_member_user_name\" class=\"tags_select\"><img src=\"$root/$get_station_member_user_image_path/$get_station_member_user_image_thumb_50\" alt=\"$get_station_member_user_image_file\" /></a>
						";
					}
					else{
						if($get_station_member_user_image_thumb_50 != ""){
							// Make thumb
							$inp_new_x = 50; // 950
							$inp_new_y = 50; // 640
							resize_crop_image($inp_new_x, $inp_new_y, "$root/$get_station_member_user_image_path/$get_station_member_user_image_file", "$root/$get_station_member_user_image_path/$get_station_member_user_image_thumb_50");
							echo"
							<a href=\"#\" data-divid=\"$get_station_member_user_name\" class=\"tags_select\"><img src=\"$root/$get_station_member_user_image_path/$get_station_member_user_image_thumb_50\" alt=\"$get_station_member_user_image_file\" /></a>
							";
						}
						else{
							// Update thumb name
							$ext = get_extension($get_station_member_user_image_file);
							$inp_thumb_name = str_replace($ext, "", $get_station_member_user_image_file);
							$inp_thumb_name = $inp_thumb_name . "_50." . $ext;
							$inp_thumb_name_mysql = quote_smart($link, $inp_thumb_name);
							$result_update = mysqli_query($link, "UPDATE $t_edb_stations_members SET station_member_user_image_thumb_50=$inp_thumb_name_mysql WHERE station_member_id=$get_station_member_id") or die(mysqli_error($link));

						}
					}
				}
				else{
					echo"
					<a href=\"#\" data-divid=\"$get_station_member_user_name\" class=\"tags_select\"><img src=\"_gfx/avatar_blank_50.png\" alt=\"avatar_blank_50.png\" /></a>
					";
				}

				echo"
				</p>
				<!-- //Img -->
			  </td>
			  <td>
				<!-- Name -->	
				<p>
				<a href=\"#\" class=\"tags_select\" data-divid=\"$get_station_member_user_name\">$get_station_member_user_name</a><br />
				<a href=\"#\" class=\"tags_select\" data-divid=\"$get_station_member_user_name\" style=\"color:black;\">$get_station_member_first_name  $get_station_member_middle_name $get_station_member_last_name</a>
				</p>
				<!-- //Name -->
			  </td>
			 </tr>
			</table>
			";
			$count_results++;
		} // last user id != station member id

		$last_user_name = "$get_station_member_user_name";
	}
	echo"
	<!-- Javascript on click add text to text input -->
		<script type=\"text/javascript\">
		\$(function() {
			\$('.tags_select').click(function() {
				var value = \$(this).data('divid');
            			var input = \$('#autosearch_inp_search_for_requester');
            			input.val(value);

				// Close
				\$(\".open_requester_results\").html(''); 
            			return false;
       			});
    		});
		</script>
	<!-- //Javascript on click add text to text input -->
	";


	if($count_results == "0"){
		echo"<span>No results</span>";
		// We can try to search in all users. If we find the person in all users, then add user from t_users to t_edb_stations_members
		// First we need to determine what station number I am at

		// Me
		$my_user_id = $_SESSION['user_id'];
		$my_user_id = output_html($my_user_id);
		$my_user_id_mysql = quote_smart($link, $my_user_id);


		// Check that I am member of this station
		$query = "SELECT station_member_id, station_member_station_id, station_member_station_title, station_member_district_id, station_member_district_title FROM $t_edb_stations_members WHERE station_member_user_id=$my_user_id_mysql LIMIT 0,1";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_my_station_member_id, $get_my_station_member_station_id, $get_my_station_member_station_title, $get_my_station_member_district_id, $get_my_station_member_district_title) = $row;

		if($get_my_station_member_id == ""){
			echo"<p style=\"color:red\">Could not find station for user $my_user_id</p>\n";
		}
		else{

			// Inputs
			$inp_station_title_mysql = quote_smart($link, $get_my_station_member_station_title);
			$inp_district_title_mysql = quote_smart($link, $get_my_station_member_district_title);

		
			$query = "SELECT user_id, user_email, user_name, user_alias, user_password, user_password_replacement, user_password_date, user_salt, user_security, user_language, user_gender, user_height, user_measurement, user_dob, user_date_format, user_registered, user_registered_time, user_last_online, user_last_online_time, user_rank, user_points, user_points_rank, user_likes, user_dislikes, user_status, user_login_tries, user_last_ip, user_synchronized, user_verified_by_moderator, user_notes, user_marked_as_spammer FROM $t_users WHERE user_email LIKE $part_mysql OR user_name LIKE $part_mysql";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_user_id, $get_user_email, $get_user_name, $get_user_alias, $get_user_password, $get_user_password_replacement, $get_user_password_date, $get_user_salt, $get_user_security, $get_user_language, $get_user_gender, $get_user_height, $get_user_measurement, $get_user_dob, $get_user_date_format, $get_user_registered, $get_user_registered_time, $get_user_last_online, $get_user_last_online_time, $get_user_rank, $get_user_points, $get_user_points_rank, $get_user_likes, $get_user_dislikes, $get_user_status, $get_user_login_tries, $get_user_last_ip, $get_user_synchronized, $get_user_verified_by_moderator, $get_user_notes, $get_user_marked_as_spammer) = $row;

	
				// Check if exists in station members
				$query_station_member = "SELECT station_member_id, station_member_station_id, station_member_station_title, station_member_district_id, station_member_district_title, station_member_user_id, station_member_rank, station_member_user_name, station_member_user_alias, station_member_first_name, station_member_middle_name, station_member_last_name, station_member_user_email, station_member_user_image_path, station_member_user_image_file, station_member_user_image_thumb_40, station_member_user_image_thumb_50, station_member_user_image_thumb_60, station_member_user_image_thumb_200, station_member_user_position, station_member_user_department, station_member_user_location, station_member_user_about, station_member_added_datetime, station_member_added_date_saying, station_member_added_by_user_id, station_member_added_by_user_name, station_member_added_by_user_alias, station_member_added_by_user_image FROM $t_edb_stations_members WHERE station_member_user_id=$get_user_id";
				$result_station_member = mysqli_query($link, $query_station_member);
				$row_station_member = mysqli_fetch_row($result_station_member);
				list($get_station_member_id, $get_station_member_station_id, $get_station_member_station_title, $get_station_member_district_id, $get_station_member_district_title, $get_station_member_user_id, $get_station_member_rank, $get_station_member_user_name, $get_station_member_user_alias, $get_station_member_first_name, $get_station_member_middle_name, $get_station_member_last_name, $get_station_member_user_email, $get_station_member_user_image_path, $get_station_member_user_image_file, $get_station_member_user_image_thumb_40, $get_station_member_user_image_thumb_50, $get_station_member_user_image_thumb_60, $get_station_member_user_image_thumb_200, $get_station_member_user_position, $get_station_member_user_department, $get_station_member_user_location, $get_station_member_user_about, $get_station_member_added_datetime, $get_station_member_added_date_saying, $get_station_member_added_by_user_id, $get_station_member_added_by_user_name, $get_station_member_added_by_user_alias, $get_station_member_added_by_user_imag) = $row_station_member;
				if($get_station_member_id == ""){

					// Requester photo
					$query = "SELECT photo_id, photo_user_id, photo_profile_image, photo_title, photo_destination, photo_thumb_40, photo_thumb_50, photo_thumb_60, photo_thumb_200, photo_uploaded, photo_uploaded_ip, photo_views, photo_views_ip_block, photo_likes, photo_comments, photo_x_offset, photo_y_offset, photo_text FROM $t_users_profile_photo WHERE photo_user_id=$get_user_id AND photo_profile_image='1'";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_photo_id, $get_photo_user_id, $get_photo_profile_image, $get_photo_title, $get_photo_destination, $get_photo_thumb_40, $get_photo_thumb_50, $get_photo_thumb_60, $get_photo_thumb_200, $get_photo_uploaded, $get_photo_uploaded_ip, $get_photo_views, $get_photo_views_ip_block, $get_photo_likes, $get_photo_comments, $get_photo_x_offset, $get_photo_y_offset, $get_photo_text) = $row;
	
					// Requester Profile
					$query = "SELECT profile_id, profile_first_name, profile_middle_name, profile_last_name, profile_about FROM $t_users_profile WHERE profile_user_id=$get_user_id";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_profile_id, $get_profile_first_name, $get_profile_middle_name, $get_profile_last_name, $get_profile_about) = $row;

					// Requester Professional
					$query = "SELECT professional_id, professional_user_id, professional_company, professional_company_location, professional_department, professional_work_email, professional_position FROM $t_users_professional WHERE professional_user_id=$get_user_id";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_professional_id, $get_professional_user_id, $get_professional_company, $get_professional_company_location, $get_professional_department, $get_professional_work_email, $get_professional_position) = $row;


					// Inputs
					$inp_user_id_mysql = quote_smart($link, $get_user_id);

					$inp_user_name_mysql = quote_smart($link, $get_user_name);
					$inp_user_alias_mysql = quote_smart($link, $get_user_alias);
					$inp_user_first_name_mysql = quote_smart($link, $get_profile_first_name);
					$inp_user_middle_name_mysql = quote_smart($link, $get_profile_middle_name);
					$inp_user_last_name_mysql = quote_smart($link, $get_profile_last_name);
					$inp_user_email_mysql = quote_smart($link, $get_user_email);

					$inp_user_image_path = "_uploads/users/images/$get_user_id";
					$inp_user_image_path_mysql = quote_smart($link, $inp_user_image_path);

					$inp_user_image_file_mysql = quote_smart($link, $get_photo_destination);
					$inp_user_image_thumb_a_mysql = quote_smart($link, $get_photo_thumb_40);
					$inp_user_image_thumb_b_mysql = quote_smart($link, $get_photo_thumb_50);
					$inp_user_image_thumb_c_mysql = quote_smart($link, $get_photo_thumb_60);
					$inp_user_image_thumb_d_mysql = quote_smart($link, $get_photo_thumb_200);

					$inp_user_position_mysql = quote_smart($link, $get_professional_position);
					$inp_user_department_mysql = quote_smart($link, $get_professional_department);
					$inp_user_location_mysql = quote_smart($link, $get_professional_company_location);
					$inp_user_about_mysql = quote_smart($link, $get_profile_about);

					$inp_added_datetime = date("Y-m-d H:i:s");
					$inp_added_date_saying = date("j M Y");

					// Insert the user as station member
					mysqli_query($link, "INSERT INTO $t_edb_stations_members
					(station_member_id, station_member_station_id, station_member_station_title, station_member_district_id, station_member_district_title, 
					station_member_user_id, station_member_rank, station_member_user_name, station_member_user_alias, station_member_first_name, 
					station_member_middle_name, station_member_last_name, station_member_user_email, station_member_user_image_path, station_member_user_image_file, 
					station_member_user_image_thumb_40, station_member_user_image_thumb_50, station_member_user_image_thumb_60, station_member_user_image_thumb_200, station_member_user_position, 
					station_member_user_department, station_member_user_location, station_member_user_about, station_member_added_datetime, station_member_added_date_saying, 
					station_member_added_by_user_id) 
					VALUES 
					(NULL, $get_my_station_member_station_id, $inp_station_title_mysql, $get_my_station_member_district_id, $inp_district_title_mysql, 
					$get_user_id, 'member', $inp_user_name_mysql, $inp_user_alias_mysql, $inp_user_first_name_mysql, 
					$inp_user_middle_name_mysql, $inp_user_last_name_mysql, $inp_user_email_mysql, $inp_user_image_path_mysql, $inp_user_image_file_mysql, 
					$inp_user_image_thumb_a_mysql, $inp_user_image_thumb_b_mysql, $inp_user_image_thumb_c_mysql, $inp_user_image_thumb_d_mysql, $inp_user_position_mysql, 
					$inp_user_department_mysql, $inp_user_location_mysql, $inp_user_about_mysql, '$inp_added_datetime', '$inp_added_date_saying', 
					$my_user_id_mysql)")
					or die(mysqli_error($link));

					echo"<p style=\"color:orange\">Added $get_user_name to station $get_station_member_station_title</p>\n";
				}
			}
		} // search in users
	} // no results 
}
else{
	echo"Missing q";
}

?>