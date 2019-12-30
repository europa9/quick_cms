<?php
/**
*
* File: _admin/_inc/edb/reports.php
* Version 11:55 30.12.2017
* Copyright (c) 2008-2017 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}
/*- Tables ---------------------------------------------------------------------------- */
$t_edb_case_index				= $mysqlPrefixSav . "edb_case_index";
$t_edb_case_index_events			= $mysqlPrefixSav . "edb_case_index_events";
$t_edb_case_index_evidence_records		= $mysqlPrefixSav . "edb_case_index_evidence_records";
$t_edb_case_index_evidence_items		= $mysqlPrefixSav . "edb_case_index_evidence_items";
$t_edb_case_index_evidence_items_sim_cards	= $mysqlPrefixSav . "edb_case_index_evidence_items_sim_cards";
$t_edb_case_index_evidence_items_sd_cards	= $mysqlPrefixSav . "edb_case_index_evidence_items_sd_cards";
$t_edb_case_index_evidence_items_networks	= $mysqlPrefixSav . "edb_case_index_evidence_items_networks";
$t_edb_case_index_evidence_items_hard_disks	= $mysqlPrefixSav . "edb_case_index_evidence_items_hard_disks";
$t_edb_case_index_evidence_items_mirror_files	= $mysqlPrefixSav . "edb_case_index_evidence_items_mirror_files";
$t_edb_case_index_statuses			= $mysqlPrefixSav . "edb_case_index_statuses";
$t_edb_case_index_human_tasks			= $mysqlPrefixSav . "edb_case_index_human_tasks";
$t_edb_case_index_automated_tasks		= $mysqlPrefixSav . "edb_case_index_automated_tasks";
$t_edb_case_index_notes				= $mysqlPrefixSav . "edb_case_index_notes";
$t_edb_case_index_open_case_menu_counters	= $mysqlPrefixSav . "edb_case_index_open_case_menu_counters";
$t_edb_case_codes				= $mysqlPrefixSav . "edb_case_codes";
$t_edb_case_statuses				= $mysqlPrefixSav . "edb_case_statuses";
$t_edb_case_statuses_district_case_counter	= $mysqlPrefixSav . "edb_case_statuses_district_case_counter";
$t_edb_case_statuses_station_case_counter	= $mysqlPrefixSav . "edb_case_statuses_station_case_counter";
$t_edb_case_statuses_user_case_counter		= $mysqlPrefixSav . "edb_case_statuses_user_case_counter";
$t_edb_case_priorities				= $mysqlPrefixSav . "edb_case_priorities";
$t_edb_case_reports				= $mysqlPrefixSav . "edb_case_reports";

$t_edb_districts_index			= $mysqlPrefixSav . "edb_districts_index";
$t_edb_districts_members		= $mysqlPrefixSav . "edb_districts_members";
$t_edb_districts_membership_requests	= $mysqlPrefixSav . "edb_districts_membership_requests";

$t_edb_stations_index			= $mysqlPrefixSav . "edb_stations_index";
$t_edb_stations_members			= $mysqlPrefixSav . "edb_stations_members";
$t_edb_stations_membership_requests	= $mysqlPrefixSav . "edb_stations_membership_requests";
$t_edb_stations_directories		= $mysqlPrefixSav . "edb_stations_directories";
$t_edb_stations_jour			= $mysqlPrefixSav . "edb_stations_jour";

$t_edb_item_types		= $mysqlPrefixSav . "edb_item_types";

$t_edb_software_index	= $mysqlPrefixSav . "edb_software_index";

$t_edb_machines_index				= $mysqlPrefixSav . "edb_machines_index";
$t_edb_machines_types				= $mysqlPrefixSav . "edb_machines_types";
$t_edb_machines_all_tasks_available		= $mysqlPrefixSav . "edb_machines_all_tasks_available";
$t_edb_machines_all_tasks_available_to_item  	= $mysqlPrefixSav . "edb_machines_all_tasks_available_to_item";

$t_edb_agent_log 	= $mysqlPrefixSav . "edb_agent_log";


$t_edb_stats_index 			= $mysqlPrefixSav . "edb_stats_index";
$t_edb_stats_case_codes			= $mysqlPrefixSav . "edb_stats_case_codes";
$t_edb_stats_case_priorites		= $mysqlPrefixSav . "edb_stats_case_priorites";
$t_edb_stats_item_types 		= $mysqlPrefixSav . "edb_stats_item_types";
$t_edb_stats_statuses_per_day		= $mysqlPrefixSav . "edb_stats_statuses_per_day";
$t_edb_stats_employee_of_the_month	= $mysqlPrefixSav . "edb_stats_employee_of_the_month";

/*- Variables -------------------------------------------------------------------------- */
if(isset($_GET['report_id'])) {
	$report_id = $_GET['report_id'];
	$report_id = strip_tags(stripslashes($report_id));
}
else{
	$report_id = "";
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


if($action == ""){
	echo"
	<h1>Reports</h1>


	<!-- Where am I? -->
		<p><b>You are here:</b><br />
		<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
		&gt;
		<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Reports</a>
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

	<!-- Navigation -->
		<p>
		<a href=\"index.php?open=edb&amp;page=$page&amp;action=new&amp;order_by=$;order_by&amp;order_method=$order_method&amp;editor_language=$editor_language&amp;l=$l\" class=\"btn_default\">New</a>
		</p>
	<!-- //Navigation -->


	<!-- Reports -->

		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\">
			<span><b>ID</b></span>
		   </th>
		   <th scope=\"col\">
			<span><b>Title</b></span>
		   </th>
		   <th scope=\"col\">
			<span><b>Type</b></span>
		   </th>
		  </tr>
		 </thead>

		";
		$query = "SELECT report_id, report_title, report_title_clean, report_logo_path, report_logo_file, report_type FROM $t_edb_case_reports ORDER BY report_title ASC";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_report_id, $get_report_title, $get_report_title_clean, $get_report_logo_path, $get_report_logo_file, $get_report_type) = $row;
			
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
				<span>
				<a href=\"index.php?open=$open&amp;page=$page&amp;action=edit&amp;report_id=$get_report_id&amp;l=$l&amp;editor_language=$editor_language\">$get_report_id</a>
				</span>
			  </td>
			  <td class=\"$style\">
				<span>$get_report_title</span>
			  </td>
			  <td class=\"$style\">
				<span>$get_report_type</span>
			  </td>
			 </tr>";
		} // while
		
		echo"
		 </tbody>
		</table>
	<!-- //Reports -->
	";
} // action == ""
elseif($action == "edit"){
	// Find
	$report_id_mysql = quote_smart($link, $report_id);
	$query = "SELECT report_id, report_title, report_title_clean, report_logo_path, report_logo_file, report_type FROM $t_edb_case_reports WHERE report_id=$report_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_report_id, $get_current_report_title, $get_current_report_title_clean, $get_current_report_logo_path, $get_current_report_logo_file, $get_current_report_type) = $row;
	
	if($get_current_report_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{

	

		if($process == "1"){


			$inp_title = $_POST['inp_title'];
			$inp_title = output_html($inp_title);
			$inp_title_mysql = quote_smart($link, $inp_title);

			$inp_type = $_POST['inp_type'];
			$inp_type = output_html($inp_type);
			$inp_type_mysql = quote_smart($link, $inp_type);

			$result = mysqli_query($link, "UPDATE $t_edb_case_reports SET 
					report_title=$inp_title_mysql, 
					report_type=$inp_type_mysql
					 WHERE report_id=$get_current_report_id") or die(mysqli_error($link));


			$url = "index.php?open=edb&page=$page&action=$action&report_id=$get_current_report_id&order_by=$order_by&order_method=$order_method&editor_language=$editor_language&l=$l&ft=success&fm=changes_saved";
			header("Location: $url");
			exit;
		}
		echo"
		<h1>$get_current_report_title</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=reports&amp;editor_language=$editor_language&amp;l=$l\">Reports</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;report_id=$get_current_report_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_report_title</a>
			</p>
		<!-- //Where am I? -->

		<!-- Tabs -->
			<div class=\"tabs\">
				<ul>
					<li><a href=\"index.php?open=edb&amp;page=$page&amp;action=edit&amp;report_id=$get_current_report_id&amp;editor_language=$editor_language&amp;l=$l\" class=\"active\">General</a></li>
					<li><a href=\"index.php?open=edb&amp;page=$page&amp;action=edit_image&amp;report_id=$get_current_report_id&amp;editor_language=$editor_language&amp;l=$l\">Image</a></li>
					<li><a href=\"index.php?open=edb&amp;page=$page&amp;action=delete&amp;report_id=$get_current_report_id&amp;editor_language=$editor_language&amp;l=$l\">Delete</a></li>
				</ul>
			</div>
			<div class=\"clear\"></div>
		<!-- //Tabs -->

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

		<!-- Focus -->
			<script>
			\$(document).ready(function(){
				\$('[name=\"inp_title\"]').focus();
			});
			</script>
		<!-- //Focus -->

		<!-- Edit form -->
			<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;report_id=$get_current_report_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

			<p>Title:<br />
			<input type=\"text\" name=\"inp_title\" value=\"$get_current_report_title\" size=\"25\" />
			</p>

			<p>Type:<br />
			<input type=\"text\" name=\"inp_type\" value=\"$get_current_report_type\" size=\"25\" />
			</p>
			<p><input type=\"submit\" value=\"Save changes\" class=\"btn_default\" />
			</p>
	
			</form>
		<!-- //Edit form -->

		";
	} // found
} // edit
elseif($action == "edit_image"){
	// Find
	$report_id_mysql = quote_smart($link, $report_id);
	$query = "SELECT report_id, report_title, report_title_clean, report_logo_path, report_logo_file, report_type FROM $t_edb_case_reports WHERE report_id=$report_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_report_id, $get_current_report_title, $get_current_report_title_clean, $get_current_report_logo_path, $get_current_report_logo_file, $get_current_report_type) = $row;
	
	if($get_current_report_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{

	


	

		if($process == "1"){


			// Sjekk filen
			$file_name = basename($_FILES['inp_image']['name']);
			$file_exp = explode('.', $file_name); 
			$file_type = $file_exp[count($file_exp) -1]; 
			$file_type = strtolower("$file_type");

			// Finnes mappen?
			$upload_path = "../_uploads/edb/report_logo";

			if(!(is_dir("../_uploads"))){
				mkdir("../_uploads");
			}
			if(!(is_dir("../_uploads/edb"))){
				mkdir("../_uploads/edb");
			}
			if(!(is_dir("../_uploads/edb/report_logo"))){
				mkdir("../_uploads/edb/report_logo");
			}

			// Sett variabler
			$new_name = $get_current_report_id . ".png";
			$target_path = $upload_path . "/" . $new_name;

			// Sjekk om det er en OK filendelse
			if($file_type == "jpg" OR $file_type == "jpeg" OR $file_type == "png" OR $file_type == "gif"){
				if(move_uploaded_file($_FILES['inp_image']['tmp_name'], $target_path)) {

					// Sjekk om det faktisk er et bilde som er lastet opp
					list($width,$height) = getimagesize($target_path);
					if(is_numeric($width) && is_numeric($height)){

						// Dette bildet er OK


						// image_path
						$inp_image_path = "_uploads/edb/report_logo";
						$inp_image_path_mysql = quote_smart($link, $inp_image_path);

						// image
						$inp_image = $new_name;
						$inp_image_mysql = quote_smart($link, $inp_image);

				
						// Update MySQL
						$result = mysqli_query($link, "UPDATE $t_edb_case_reports SET 
							report_logo_path=$inp_image_path_mysql, report_logo_file=$inp_image_mysql WHERE report_id=$get_current_report_id") or die(mysqli_error($link));

					
						$url = "index.php?open=edb&page=$page&action=edit_image&report_id=$get_current_report_id&editor_language=$editor_language&l=$l&ft=success&fm=image_uploaded";
						header("Location: $url");
						exit;
					}
					else{
						// Dette er en fil som har fått byttet filendelse...
						unlink("$target_path");
	
						$url = "index.php?open=edb&page=$page&action=edit_image&report_id=$get_current_report_id&editor_language=$editor_language&l=$l&ft=error&fm=file_is_not_an_image";
						header("Location: $url");
						exit;
					}
				}
				else{
					switch ($_FILES['inp_image'] ['error']){
					case 1:
						$url = "index.php?open=edb&page=$page&action=edit_image&report_id=$get_current_report_id&editor_language=$editor_language&l=$l&ft=error&fm=to_big_file";
						header("Location: $url");
						exit;
						break;
					case 2:
						$url = "index.php?open=edb&page=$page&action=edit_image&report_id=$get_current_report_id&editor_language=$editor_language&l=$l&ft=error&fm=to_big_file";
						header("Location: $url");
						exit;
						break;
					case 3:
						$url = "index.php?open=edb&page=$page&action=edit_image&report_id=$get_current_report_id&editor_language=$editor_language&l=$l&ft=error&fm=only_parts_uploaded";
						header("Location: $url");
						exit;
						break;
					case 4:
						$url = "index.php?open=edb&page=$page&action=edit_image&report_id=$get_current_report_id&editor_language=$editor_language&l=$l&ft=error&fm=no_file_uploaded";
						header("Location: $url");
						exit;
						break;
					}
				} // if(move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
			}
			else{
				$url = "index.php?open=edb&page=$page&action=edit_image&report_id=$get_current_report_id&editor_language=$editor_language&l=$l&ft=error&fm=invalid_file_type&file_type=$file_type";
				header("Location: $url");
				exit;
			}
		}
		echo"

		<h1>$get_current_report_title</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=reports&amp;editor_language=$editor_language&amp;l=$l\">Reports</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;report_id=$get_current_report_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_report_title</a>
			</p>
		<!-- //Where am I? -->

		<!-- Tabs -->
			<div class=\"tabs\">
				<ul>
					<li><a href=\"index.php?open=edb&amp;page=$page&amp;action=edit&amp;report_id=$get_current_report_id&amp;editor_language=$editor_language&amp;l=$l\">General</a></li>
					<li><a href=\"index.php?open=edb&amp;page=$page&amp;action=edit_image&amp;report_id=$get_current_report_id&amp;editor_language=$editor_language&amp;l=$l\" class=\"active\">Image</a></li>
					<li><a href=\"index.php?open=edb&amp;page=$page&amp;action=delete&amp;report_id=$get_current_report_id&amp;editor_language=$editor_language&amp;l=$l\">Delete</a></li>
				</ul>
			</div>
			<div class=\"clear\"></div>
		<!-- //Tabs -->

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

		<!-- Focus -->
			<script>
			\$(document).ready(function(){
				\$('[name=\"inp_title\"]').focus();
			});
			</script>
		<!-- //Focus -->

		<!-- Edit form -->
			<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;report_id=$get_current_report_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

			";

			if(file_exists("../$get_current_report_logo_path/$get_current_report_logo_file") && $get_current_report_logo_file != ""){
				echo"
				<p><b>Existing image:<br />
				<img src=\"../$get_current_report_logo_path/$get_current_report_logo_file\" alt=\"$get_current_report_logo_file\" />
				</p>
				";
			}

			echo"
				
			<p><b>New image (256x256 png):</b><br />
			<input type=\"file\" name=\"inp_image\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
			</p>

			<p><input type=\"submit\" value=\"Save changes\" class=\"btn_default\" />
			</p>
	
			</form>
		<!-- //Edit form -->

		";
	} // found
} // edit_image
elseif($action == "delete"){
	// Find
	$report_id_mysql = quote_smart($link, $report_id);
	$query = "SELECT report_id, report_title, report_title_clean, report_logo_path, report_logo_file, report_type FROM $t_edb_case_reports WHERE report_id=$report_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_report_id, $get_current_report_title, $get_current_report_title_clean, $get_current_report_logo_path, $get_current_report_logo_file, $get_current_report_type) = $row;
	
	if($get_current_report_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{


	

		if($process == "1"){

			
			$result = mysqli_query($link, "DELETE FROM $t_edb_case_reports WHERE report_id=$get_current_report_id") or die(mysqli_error($link));


			$url = "index.php?open=edb&page=$page&order_by=$order_by&order_method=$order_method&editor_language=$editor_language&l=$l&ft=success&fm=deleted";
			header("Location: $url");
			exit;
		}
		echo"

		<h1>$get_current_report_title</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=reports&amp;editor_language=$editor_language&amp;l=$l\">Reports</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;report_id=$get_current_report_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_report_title</a>
			</p>
		<!-- //Where am I? -->

		<!-- Tabs -->
			<div class=\"tabs\">
				<ul>
					<li><a href=\"index.php?open=edb&amp;page=$page&amp;action=edit&amp;report_id=$get_current_report_id&amp;editor_language=$editor_language&amp;l=$l\">General</a></li>
					<li><a href=\"index.php?open=edb&amp;page=$page&amp;action=edit_image&amp;report_id=$get_current_report_id&amp;editor_language=$editor_language&amp;l=$l\">Image</a></li>
					<li><a href=\"index.php?open=edb&amp;page=$page&amp;action=delete&amp;report_id=$get_current_report_id&amp;editor_language=$editor_language&amp;l=$l\" class=\"active\">Delete</a></li>
				</ul>
			</div>
			<div class=\"clear\"></div>
		<!-- //Tabs -->


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


		<!-- Delete -->
			
			<p>
			Are you sure you want to delete?
			</p>

			<p>
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;report_id=$get_current_report_id&amp;l=$l&amp;process=1\" class=\"btn_danger\">Confirm</a>
			</p>
	
		<!-- //Delete -->

		";
	} // found
} // delete
elseif($action == "new"){
	if($process == "1"){

		$inp_title = $_POST['inp_title'];
		$inp_title = output_html($inp_title);
		$inp_title_mysql = quote_smart($link, $inp_title);

		$inp_title_clean = clean($inp_title);
		$inp_title_clean_mysql = quote_smart($link, $inp_title_clean);

		$inp_type = $_POST['inp_type'];
		$inp_type = output_html($inp_type);
		$inp_type_mysql = quote_smart($link, $inp_type);


		mysqli_query($link, "INSERT INTO $t_edb_case_reports 
		(report_id, report_title, report_title_clean, report_type) 
		VALUES 
		(NULL, $inp_title_mysql, $inp_title_clean_mysql, $inp_type_mysql)")
		or die(mysqli_error($link));

		$url = "index.php?open=edb&page=$page&action=$action&editor_language=$editor_language&l=$l&ft=success&fm=saved";
		header("Location: $url");
		exit;
	}
	echo"
	<h1>New</h1>


	<!-- Where am I? -->
		<p><b>You are here:</b><br />
		<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
		&gt;
		<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Reports</a>
		&gt;
		<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;editor_language=$editor_language&amp;l=$l\">New</a>
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

	<!-- Focus -->
		<script>
		\$(document).ready(function(){
			\$('[name=\"inp_title\"]').focus();
		});
		</script>
	<!-- //Focus -->

	<!-- New form -->
		<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

		<p>Title:<br />
		<input type=\"text\" name=\"inp_title\" value=\"\" size=\"25\" />
		</p>

		<p>Type:<br />
		<select name=\"inp_type\">
			<option value=\"acquire_report\">acquire_report</option>
			<option value=\"analysis_report\">analysis_report</option>
		</select> 
		</p>

		<p><input type=\"submit\" value=\"Create\" class=\"btn_default\" />
		</p>
	
		</form>
	<!-- //New form -->

	";
} // new
?>