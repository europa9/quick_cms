<?php 
/**
*
* File: edb/open_case_glossaries.php
* Version 1.0
* Date 19:42 22.08.2019
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
if(isset($_GET['case_glossary_id'])) {
	$case_glossary_id = $_GET['case_glossary_id'];
	$case_glossary_id = strip_tags(stripslashes($case_glossary_id));
}
else{
	$case_glossary_id = "";
}
$case_glossary_id_mysql = quote_smart($link, $case_glossary_id);



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
					<a href=\"open_case_glossaries.php?case_id=$get_current_case_id&amp;l=$l\">$l_glossaries</a>
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
				echo"
				<h2>$l_glossaries</h2>

				<!-- Glossaries actions -->";
					if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
						echo"
						<p>
						<a href=\"open_case_glossaries.php?case_id=$get_current_case_id&amp;action=new&amp;l=$l\" class=\"btn_default\">$l_new_glossary</a>
						</p>
						<div style=\"height: 10px;\"></div>
						";
					}
					echo"
				<!-- //Glossaries actions -->
		

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

				<!-- List of all case glossaries -->
					<table class=\"hor-zebra\">
					 <thead>
					  <tr>
					   <th scope=\"col\">
						<span>$l_title</span>
					   </th>
					   <th scope=\"col\">
						<span>$l_actions</span>
					   </th>
					  </tr>
					 </thead>
					 <tbody>
					";
					$counter=0;
					$query = "SELECT case_glossary_id, case_glossary_glossary_title FROM $t_edb_case_index_glossaries WHERE case_glossary_case_id=$get_current_case_id ORDER BY case_glossary_glossary_title ASC";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_case_glossary_id, $get_case_glossary_glossary_title) = $row;
		
						if(isset($style) && $style == ""){
							$style = "odd";
						}
						else{
							$style = "";
						}
						echo"
						 <tr>
						  <td class=\"$style\">
							<a href=\"open_case_glossaries.php?case_id=$get_current_case_id&amp;action=edit&amp;case_glossary_id=$get_case_glossary_id&amp;l=$l\">$get_case_glossary_glossary_title</a>
						  </td>
						  <td class=\"$style\">";
							if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
								echo"<span>
								<a href=\"open_case_glossaries.php?case_id=$get_current_case_id&amp;action=edit&amp;case_glossary_id=$get_case_glossary_id&amp;l=$l\">$l_edit</a>
								&middot;
								<a href=\"open_case_glossaries.php?case_id=$get_current_case_id&amp;action=delete&amp;case_glossary_id=$get_case_glossary_id&amp;l=$l\">$l_delete</a>
								</span>";
							}
						echo"
						 </td>
						</tr>
						";
						$counter = $counter + 1;
					} // while events
					if($counter != "$get_current_menu_counter_glossaries"){
						$result = mysqli_query($link, "UPDATE $t_edb_case_index_open_case_menu_counters SET menu_counter_glossaries=$counter WHERE menu_counter_case_id=$get_current_case_id");
					}
					echo"
					 </tbody>
					</table>

				<!-- List of all case glossaries -->
				";
			} // $action == ""
			elseif($action == "new" && ($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor")){
				if($process == "1"){
			$inp_title = $_POST['inp_title'];
			$inp_title = output_html($inp_title);
			$inp_title_mysql = quote_smart($link, $inp_title);

			$inp_template_glossary_id = $_POST['inp_template_glossary_id'];
			$inp_template_glossary_id = output_html($inp_template_glossary_id);
			$inp_template_glossary_id_mysql = quote_smart($link, $inp_template_glossary_id);
				
			$query = "SELECT glossary_id, glossary_title, glossary_description, glossary_words, glossary_last_used_datetime FROM $t_edb_glossaries WHERE glossary_id=$inp_template_glossary_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_glossary_id, $get_current_glossary_title, $get_current_glossary_description, $get_current_glossary_words, $get_current_glossary_last_used_datetime) = $row;
			if($get_current_glossary_id == ""){
				$inp_template_glossary_id = 0;
				$inp_template_glossary_id_mysql = quote_smart($link, $inp_template_glossary_id);

				$get_current_glossary_words = "";
			}
			else{
				$inp_datetime = date("Y-m-d H:i:s");
				$result = mysqli_query($link, "UPDATE $t_edb_glossaries SET 
						glossary_last_used_datetime='$inp_datetime'
					 WHERE glossary_id=$get_current_glossary_id") or die(mysqli_error($link));
			}

			$inp_words_mysql = quote_smart($link, $get_current_glossary_words);


			// Insert
			mysqli_query($link, "INSERT INTO $t_edb_case_index_glossaries
			(case_glossary_id, case_glossary_case_id, case_glossary_glossary_id, case_glossary_glossary_title, case_glossary_words) 
			VALUES 
			(NULL, $get_current_case_id, $inp_template_glossary_id_mysql, $inp_title_mysql, $inp_words_mysql )")
			or die(mysqli_error($link));

			// Get ID
			$query = "SELECT case_glossary_id FROM $t_edb_case_index_glossaries WHERE case_glossary_glossary_title=$inp_title_mysql AND case_glossary_case_id='$get_current_case_id'";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_case_glossary_id) = $row;

			$url = "open_case_glossaries.php?case_id=$get_current_case_id&action=edit&case_glossary_id=$get_case_glossary_id&l=$l&ft=success&fm=case_glossary_saved";
			header("Location: $url");
			exit;
			}
		echo"
		<h2>$l_new_glossary</h2>

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
				\$('[name=\"inp_title\"]').focus();
			});
			</script>
		<!-- //Focus -->
		
		<!-- New glossary form -->
			<form method=\"POST\" action=\"open_case_glossaries.php?case_id=$get_current_case_id&amp;action=new&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">


			<p><b>$l_use_template_glossary:</b> (<a href=\"$root/_admin/index.php?open=edb&amp;page=glossaries&amp;editor_language=$l&amp;l=$l\" target=\"_blank\">Edit</a>)<br />
			<select name=\"inp_template_glossary_id\" class=\"on_change_get_option_and_put_into_inp_title\">
				<option value=\"\">$l_none</option>\n";

				$query = "SELECT glossary_id, glossary_title, glossary_description FROM $t_edb_glossaries ORDER BY glossary_title ASC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_glossary_id, $get_glossary_title, $get_glossary_description) = $row;
					echo"				";
					echo"<option value=\"$get_glossary_id\">$get_glossary_title</option>\n";
				}
				echo"
			</select>
			</p>

			<!-- On change get option and put into inp_title -->
				<script>
					\$('.on_change_get_option_and_put_into_inp_title').on('change',function(){
						var optionsText = this.options[this.selectedIndex].text;
						\$('#inp_title').val(optionsText);
					});
				</script>
			<!-- //On change get option and put into inp_title -->
	

			<p><b>$l_title:</b><br />
			<input type=\"text\" name=\"inp_title\" value=\"\" id=\"inp_title\" size=\"25\" style=\"width: 100%;\" />
			</p>

			<p>
			<input type=\"submit\" value=\"$l_save\" class=\"btn_default\" />
			</p>
		<!-- //New event form -->
		";
		} // action == new
		elseif($action == "edit"){
		
			// Find case glossary
			$query = "SELECT case_glossary_id, case_glossary_case_id, case_glossary_glossary_id, case_glossary_glossary_title, case_glossary_words FROM $t_edb_case_index_glossaries WHERE case_glossary_id=$case_glossary_id_mysql AND case_glossary_case_id=$get_current_case_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_case_glossary_id, $get_current_case_glossary_case_id, $get_current_case_glossary_glossary_id, $get_current_case_glossary_glossary_title, $get_current_case_glossary_words) = $row;
		
			if($get_current_case_glossary_id == ""){
				echo"
				<h2>Case glossary not found</h2>
				<p><a href=\"open_case_glossaries.php?case_id=$get_current_case_id&amp;action=new_event&amp;l=$l\">Case glossaries</a></p>
				";
			}
			else{

				if($process == "1" && ($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor")){
					$inp_title = $_POST['inp_title'];
					$inp_title = output_html($inp_title);
					$inp_title_mysql = quote_smart($link, $inp_title);
	
					$inp_words = $_POST['inp_words'];
					$inp_words = output_html($inp_words);
					$inp_words = str_replace("<br />", "\n", $inp_words);
					$inp_words_mysql = quote_smart($link, $inp_words);
				
					// Update
					$result = mysqli_query($link, "UPDATE $t_edb_case_index_glossaries SET 
								case_glossary_glossary_title=$inp_title_mysql, 
								case_glossary_words=$inp_words_mysql
								 WHERE case_glossary_id=$get_current_case_glossary_id") or die(mysqli_error($link));



					$url = "open_case_glossaries.php?case_id=$get_current_case_id&action=edit&case_glossary_id=$get_current_case_glossary_id&l=$l&ft=success&fm=case_glossary_saved";
					header("Location: $url");
					exit;

				}
				echo"
				<h2>$l_edit $get_current_case_glossary_glossary_title</h2>
	
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
				if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
					echo"
					<!-- Focus -->
						<script>
						\$(document).ready(function(){
							\$('[name=\"inp_title\"]').focus();
						});
						</script>
					<!-- //Focus -->
		
					<!-- Edit case glossary form -->
					<form method=\"POST\" action=\"open_case_glossaries.php?case_id=$get_current_case_id&amp;action=edit&amp;case_glossary_id=$get_current_case_glossary_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

					<p>$l_title:<br />
					<input type=\"text\" name=\"inp_title\" value=\"$get_current_case_glossary_glossary_title\" size=\"25\" style=\"width: 100%;\" />
					</p>

					<p>$l_words:<br />
					<textarea name=\"inp_words\" rows=\"20\" cols=\"80\" style=\"width: 100%;\">$get_current_case_glossary_words</textarea>
					</p>
					<p>
					<input type=\"submit\" value=\"$l_save\" class=\"btn_default\" />
					</p>
					<!-- //Edit case glossary form -->
					";
				}
				else{
					echo"
					<p><b>$l_title:</b><br />
					$get_current_case_glossary_glossary_title
					</p>

					<p><b>$l_words:</b><br />
					";
					$get_current_case_glossary_words = str_replace("\n", "<br />", $get_current_case_glossary_words);
					echo"$get_current_case_glossary_words
					</p>
					";
				}
			} // glossary found
		} // action == edit event
		elseif($action == "delete" && ($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor")){
		// Find case glossary
		$query = "SELECT case_glossary_id, case_glossary_case_id, case_glossary_glossary_id, case_glossary_glossary_title, case_glossary_words FROM $t_edb_case_index_glossaries WHERE case_glossary_id=$case_glossary_id_mysql AND case_glossary_case_id=$get_current_case_id";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_case_glossary_id, $get_current_case_glossary_case_id, $get_current_case_glossary_glossary_id, $get_current_case_glossary_glossary_title, $get_current_case_glossary_words) = $row;
		
		if($get_current_case_glossary_id == ""){
			echo"
			<h2>Case glossary not found</h2>
			<p><a href=\"open_case_glossaries.php?case_id=$get_current_case_id&amp;action=new_event&amp;l=$l\">Case glossaries</a></p>
			";
		}
		else{

			if($process == "1"){
				
				// Delete
				$result = mysqli_query($link, "DELETE FROM $t_edb_case_index_glossaries WHERE case_glossary_id=$get_current_case_glossary_id") or die(mysqli_error($link));



				$url = "open_case_glossaries.php?case_id=$get_current_case_id&page=events&l=$l&ft=success&fm=glossary_deleted";
				header("Location: $url");
				exit;

			}
			echo"
			<h2>$l_delete $get_current_case_glossary_glossary_title</h2>

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

		
			<!-- Delete glossary form -->
				<p>
				$l_are_you_sure
				</p>

				<div class=\"bodycell\">
					<table>
					 <tr>
					  <td style=\"padding-right: 5px;\">
						<span>$l_id:</span>
					  </td>
					  <td>
						<span>$get_current_case_glossary_id</span>
					  </td>
					 </tr>
					</table>
				</div>

				<p>
				<a href=\"open_case_glossaries.php?case_id=$get_current_case_id&amp;action=delete&amp;case_glossary_id=$get_current_case_glossary_id&amp;l=$l&amp;process=1\" class=\"btn_danger\">$l_confirm</a>
				<a href=\"open_case_glossaries.php?case_id=$get_current_case_id&amp;l=$l\" class=\"btn_default\">$l_cancel</a>
				</p>
			<!-- //Delete glossary form -->
			";
		} //  glossaries found
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