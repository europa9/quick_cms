<?php
/**
*
* File: _admin/_inc/edb/ping_on.php
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
$t_edb_liquidbase				= $mysqlPrefixSav . "edb_liquidbase";

$t_edb_home_page_user_remember			= $mysqlPrefixSav . "edb_home_page_user_remember";

$t_edb_cases_explorer_assigned_to_unique_users		= $mysqlPrefixSav . "edb_cases_explorer_assigned_to_unique_users";

$t_edb_case_index					= $mysqlPrefixSav . "edb_case_index";
$t_edb_case_index_events				= $mysqlPrefixSav . "edb_case_index_events";
$t_edb_case_index_evidence_records			= $mysqlPrefixSav . "edb_case_index_evidence_records";
$t_edb_case_index_evidence_items			= $mysqlPrefixSav . "edb_case_index_evidence_items";
$t_edb_case_index_evidence_items_sim_cards		= $mysqlPrefixSav . "edb_case_index_evidence_items_sim_cards";
$t_edb_case_index_evidence_items_sd_cards		= $mysqlPrefixSav . "edb_case_index_evidence_items_sd_cards";
$t_edb_case_index_evidence_items_networks		= $mysqlPrefixSav . "edb_case_index_evidence_items_networks";
$t_edb_case_index_evidence_items_hard_disks		= $mysqlPrefixSav . "edb_case_index_evidence_items_hard_disks";
$t_edb_case_index_evidence_items_volumes		= $mysqlPrefixSav . "edb_case_index_evidence_items_volumes";
$t_edb_case_index_evidence_items_mirror_files		= $mysqlPrefixSav . "edb_case_index_evidence_items_mirror_files";
$t_edb_case_index_evidence_items_mirror_files_hash	= $mysqlPrefixSav . "edb_case_index_evidence_items_mirror_files_hash";
$t_edb_case_index_evidence_items_passwords		= $mysqlPrefixSav . "edb_case_index_evidence_items_passwords";
$t_edb_case_index_evidence_items_zips			= $mysqlPrefixSav . "edb_case_index_evidence_items_zips";

$t_edb_case_index_statuses				= $mysqlPrefixSav . "edb_case_index_statuses";
$t_edb_case_index_human_tasks				= $mysqlPrefixSav . "edb_case_index_human_tasks";
$t_edb_case_index_human_tasks_responsible_counters	= $mysqlPrefixSav . "edb_case_index_human_tasks_responsible_counters";
$t_edb_case_index_automated_tasks			= $mysqlPrefixSav . "edb_case_index_automated_tasks";
$t_edb_case_index_notes					= $mysqlPrefixSav . "edb_case_index_notes";
$t_edb_case_index_open_case_menu_counters		= $mysqlPrefixSav . "edb_case_index_open_case_menu_counters";
$t_edb_case_index_glossaries				= $mysqlPrefixSav . "edb_case_index_glossaries";
$t_edb_case_index_photos				= $mysqlPrefixSav . "edb_case_index_photos";

$t_edb_case_index_usr_psw				= $mysqlPrefixSav . "edb_case_index_usr_psw";

$t_edb_case_index_item_info_level_a	= $mysqlPrefixSav . "edb_case_index_item_info_level_a";
$t_edb_case_index_item_info_level_b	= $mysqlPrefixSav . "edb_case_index_item_info_level_b";
$t_edb_case_index_item_info_level_c	= $mysqlPrefixSav . "edb_case_index_item_info_level_c";
$t_edb_case_index_item_info_level_d	= $mysqlPrefixSav . "edb_case_index_item_info_level_d";

$t_edb_case_codes					= $mysqlPrefixSav . "edb_case_codes";
$t_edb_case_codes_priority_counters			= $mysqlPrefixSav . "edb_case_codes_priority_counters";
$t_edb_case_statuses					= $mysqlPrefixSav . "edb_case_statuses";
$t_edb_case_statuses_district_case_counter		= $mysqlPrefixSav . "edb_case_statuses_district_case_counter";
$t_edb_case_statuses_station_case_counter		= $mysqlPrefixSav . "edb_case_statuses_station_case_counter";
$t_edb_case_statuses_user_case_counter			= $mysqlPrefixSav . "edb_case_statuses_user_case_counter";
$t_edb_case_priorities					= $mysqlPrefixSav . "edb_case_priorities";
$t_edb_case_reports					= $mysqlPrefixSav . "edb_case_reports";


$t_edb_districts_index			= $mysqlPrefixSav . "edb_districts_index";
$t_edb_districts_members		= $mysqlPrefixSav . "edb_districts_members";
$t_edb_districts_membership_requests	= $mysqlPrefixSav . "edb_districts_membership_requests";
$t_edb_districts_jour 			= $mysqlPrefixSav . "edb_districts_jour";

$t_edb_stations_index			= $mysqlPrefixSav . "edb_stations_index";
$t_edb_stations_members			= $mysqlPrefixSav . "edb_stations_members";
$t_edb_stations_membership_requests	= $mysqlPrefixSav . "edb_stations_membership_requests";
$t_edb_stations_directories		= $mysqlPrefixSav . "edb_stations_directories";
$t_edb_stations_jour			= $mysqlPrefixSav . "edb_stations_jour";
$t_edb_stations_user_view_method	= $mysqlPrefixSav . "edb_stations_user_view_method";

$t_edb_item_types			= $mysqlPrefixSav . "edb_item_types";
$t_edb_item_types_available_passwords	= $mysqlPrefixSav . "edb_item_types_available_passwords";

$t_edb_glossaries		= $mysqlPrefixSav . "edb_glossaries";

$t_edb_software_index	= $mysqlPrefixSav . "edb_software_index";

$t_edb_machines_index				= $mysqlPrefixSav . "edb_machines_index";
$t_edb_machines_index_types			= $mysqlPrefixSav . "edb_machines_index_types";
$t_edb_machines_types				= $mysqlPrefixSav . "edb_machines_types";
$t_edb_machines_all_tasks_available		= $mysqlPrefixSav . "edb_machines_all_tasks_available";
$t_edb_machines_all_tasks_available_to_item  	= $mysqlPrefixSav . "edb_machines_all_tasks_available_to_item";

$t_edb_agent_log 			= $mysqlPrefixSav . "edb_agent_log";
$t_edb_agent_user_active_inactive 	= $mysqlPrefixSav . "edb_agent_user_active_inactive";
$t_edb_agents_index		 	= $mysqlPrefixSav . "edb_agents_index";


$t_edb_stats_index 			= $mysqlPrefixSav . "edb_stats_index";
$t_edb_stats_case_codes			= $mysqlPrefixSav . "edb_stats_case_codes";
$t_edb_stats_case_priorites		= $mysqlPrefixSav . "edb_stats_case_priorites";
$t_edb_stats_item_types 		= $mysqlPrefixSav . "edb_stats_item_types";
$t_edb_stats_statuses_per_day		= $mysqlPrefixSav . "edb_stats_statuses_per_day";
$t_edb_stats_employee_of_the_month	= $mysqlPrefixSav . "edb_stats_employee_of_the_month";
$t_edb_stats_acquirements_per_month	= $mysqlPrefixSav . "edb_stats_acquirements_per_month";

$t_edb_stats_requests_user_per_month			= $mysqlPrefixSav . "edb_stats_requests_user_per_month";
$t_edb_stats_requests_user_case_codes_per_month		= $mysqlPrefixSav . "edb_stats_requests_user_case_codes_per_month";
$t_edb_stats_requests_user_item_types_per_month		= $mysqlPrefixSav . "edb_stats_requests_user_item_types_per_month";
$t_edb_stats_requests_department_per_month		= $mysqlPrefixSav . "edb_stats_requests_department_per_month";
$t_edb_stats_requests_department_case_codes_per_month	= $mysqlPrefixSav . "edb_stats_requests_department_case_codes_per_month";
$t_edb_stats_requests_department_item_types_per_month	= $mysqlPrefixSav . "edb_stats_requests_department_item_types_per_month";

$t_edb_ping_on 		= $mysqlPrefixSav . "edb_ping_on";
$t_edb_backup_disks 	= $mysqlPrefixSav . "edb_backup_disks";

/*- Functions ------------------------------------------------------------------------- */
function utf8ize($d) {
    if (is_array($d)) {
        foreach ($d as $k => $v) {
            $d[$k] = utf8ize($v);
        }
    } else if (is_string ($d)) {
        return utf8_encode($d);
    }
    return $d;
}



/*- Variables -------------------------------------------------------------------------- */
if(isset($_GET['id'])) {
	$id = $_GET['id'];
	$id = strip_tags(stripslashes($id));
}
else{
	$id = "";
}


if($action == ""){
	echo"
	<h1>Ping on</h1>


	<!-- Where am I? -->
		<p><b>You are here:</b><br />
		<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
		&gt;
		<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Ping on</a>
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
		<a href=\"index.php?open=edb&amp;page=$page&amp;action=new&amp;editor_language=$editor_language&amp;l=$l\" class=\"btn_default\">New</a>
		</p>
	<!-- //Navigation -->


	<!-- Ping ons -->

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
			<span><b>When</b></span>
		   </th>
		   <th scope=\"col\">
			<span><b>IP</b></span>
		   </th>
		   <th scope=\"col\">
			<span><b>Last pinged</b></span>
		   </th>
		   <th scope=\"col\">
			<span><b>Actions</b></span>
		   </th>
		  </tr>
		 </thead>

		";
		$query = "SELECT ping_on_id, ping_on_title, ping_on_when, ping_on_to_ip, ping_on_last_datetime FROM $t_edb_ping_on";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_ping_on_id, $get_ping_on_title, $get_ping_on_when, $get_ping_on_to_ip, $get_ping_on_last_datetime) = $row;
			
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
				<span>$get_ping_on_id</span>
			  </td>
			  <td class=\"$style\">
				<span>$get_ping_on_title</span>
			  </td>
			  <td class=\"$style\">
				<span>$get_ping_on_when</span>
			  </td>
			  <td class=\"$style\">
				<span>$get_ping_on_to_ip</span>
			  </td>
			  <td class=\"$style\">
				<span>$get_ping_on_last_datetime</span>
			  </td>
			  <td class=\"$style\">
				<span>
				<a href=\"index.php?open=$open&amp;page=$page&amp;action=edit&amp;id=$get_ping_on_id&amp;l=$l&amp;editor_language=$editor_language\">Edit</a>
				|
				<a href=\"index.php?open=$open&amp;page=$page&amp;action=delete&amp;id=$get_ping_on_id&amp;l=$l&amp;editor_language=$editor_language\">Delete</a>
				|
				<a href=\"index.php?open=$open&amp;page=$page&amp;action=test&amp;id=$get_ping_on_id&amp;l=$l&amp;editor_language=$editor_language\">Test</a>
				</span>
			  </td>
			 </tr>";
		} // while
		
		echo"
		 </tbody>
		</table>
	<!-- //Ping ons -->
	";
} // action == ""
elseif($action == "edit"){
	// Find
	$id_mysql = quote_smart($link, $id);
	$query = "SELECT ping_on_id, ping_on_title, ping_on_when, ping_on_to_ip, ping_on_last_datetime FROM $t_edb_ping_on WHERE ping_on_id=$id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_ping_on_id, $get_current_ping_on_title, $get_current_ping_on_when, $get_current_ping_on_to_ip, $get_current_ping_on_last_datetime) = $row;
	
	if($get_current_ping_on_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{
	

		if($process == "1"){

			$inp_title = $_POST['inp_title'];
			$inp_title = output_html($inp_title);
			$inp_title_mysql = quote_smart($link, $inp_title);

			$inp_when = $_POST['inp_when'];
			$inp_when = output_html($inp_when);
			$inp_when_mysql = quote_smart($link, $inp_when);

			$inp_to_ip = $_POST['inp_to_ip'];
			$inp_to_ip = output_html($inp_to_ip);
			$inp_to_ip_mysql = quote_smart($link, $inp_to_ip);


			$result = mysqli_query($link, "UPDATE $t_edb_ping_on SET 
					ping_on_title=$inp_title_mysql,
					ping_on_when=$inp_when_mysql, 
					ping_on_to_ip=$inp_to_ip_mysql 
					 WHERE ping_on_id=$get_current_ping_on_id") or die(mysqli_error($link));


			$url = "index.php?open=edb&page=$page&editor_language=$editor_language&l=$l&ft=success&fm=changes_saved";
			header("Location: $url");
			exit;
		}
		echo"
		<h1>Edit</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Ping on</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;id=$get_current_ping_on_id&amp;editor_language=$editor_language&amp;l=$l\">Edit</a>
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

		<!-- Edit form -->";
		
			echo"
			<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;id=$get_current_ping_on_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

			<p>Title:<br />
			<input type=\"text\" name=\"inp_title\" value=\"$get_current_ping_on_title\" size=\"25\" />
			</p>

			<p>When:<br />
			<select name=\"inp_when\">
				<option value=\"new_mirror_file\""; if($get_current_ping_on_when == "new_mirror_file"){ echo" selected=\"selected\""; } echo">New mirror file</option>
				<option value=\"mirror_file_ready_for_automated_machine\""; if($get_current_ping_on_when == "mirror_file_ready_for_automated_machine"){ echo" selected=\"selected\""; } echo">Mirror file ready for automated machine</option>
				<option value=\"new_password\""; if($get_current_ping_on_when == "new_password"){ echo" selected=\"selected\""; } echo">New password</option>
			</select>
			</p>

			<p>To IP:<br />
			<input type=\"text\" name=\"inp_to_ip\" value=\"$get_current_ping_on_to_ip\" size=\"25\" />
			</p>

			<p><input type=\"submit\" value=\"Save changes\" class=\"btn_default\" />
			</p>
			</form>
		<!-- //Edit form -->

		";
	} // found
} // edit
elseif($action == "delete"){
	// Find
	$id_mysql = quote_smart($link, $id);
	$query = "SELECT ping_on_id, ping_on_when, ping_on_to_ip, ping_on_last_datetime FROM $t_edb_ping_on WHERE ping_on_id=$id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_ping_on_id, $get_current_ping_on_when, $get_current_ping_on_to_ip, $get_current_ping_on_last_datetime) = $row;
	
	if($get_current_ping_on_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{
	

		if($process == "1"){


			

			$result = mysqli_query($link, "DELETE FROM $t_edb_ping_on WHERE ping_on_id=$get_current_ping_on_id") or die(mysqli_error($link));


			$url = "index.php?open=edb&page=$page&editor_language=$editor_language&l=$l&ft=success&fm=deleted";
			header("Location: $url");
			exit;
		}
		echo"
		<h1>Edit</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Ping on</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;id=$get_current_ping_on_id&amp;editor_language=$editor_language&amp;l=$l\">Delete</a>
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

		<!-- Delete form -->
			<p>Are you sure you want to delete?</p>
			<p>
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;id=$get_current_ping_on_id&amp;l=$l&amp;process=1\">Confirm</a>
			</p>
		<!-- //Delete form -->

		";
	} // found
} // delete
elseif($action == "new"){
	if($process == "1"){

		$inp_title = $_POST['inp_title'];
		$inp_title = output_html($inp_title);
		$inp_title_mysql = quote_smart($link, $inp_title);

		$inp_when = $_POST['inp_when'];
		$inp_when = output_html($inp_when);
		$inp_when_mysql = quote_smart($link, $inp_when);


		$inp_to_ip = $_POST['inp_to_ip'];
		$inp_to_ip = output_html($inp_to_ip);
		$inp_to_ip_mysql = quote_smart($link, $inp_to_ip);


		mysqli_query($link, "INSERT INTO $t_edb_ping_on
		(ping_on_id, ping_on_title, ping_on_when, ping_on_to_ip) 
		VALUES 
		(NULL, $inp_title_mysql, $inp_when_mysql, $inp_to_ip_mysql)")
		or die(mysqli_error($link));

		$url = "index.php?open=edb&page=$page&editor_language=$editor_language&l=$l&ft=success&fm=saved";
		header("Location: $url");
		exit;
	}
	echo"
	<h1>New</h1>


	<!-- Where am I? -->
		<p><b>You are here:</b><br />
		<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
		&gt;
		<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Ping on</a>
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

		<p>When:<br />
		<select name=\"inp_when\">
			<option value=\"new_mirror_file\">New mirror file</option>
			<option value=\"mirror_file_ready_for_automated_machine\">Mirror file ready for automated machine</option>
			<option value=\"new_password\">New password</option>
		</select>
		</p>

		<p>To IP:<br />
		<input type=\"text\" name=\"inp_to_ip\" value=\"\" size=\"25\" />
		</p>

		<p><input type=\"submit\" value=\"Create\" class=\"btn_default\" />
		</p>
	
		</form>
	<!-- //New form -->

	";
} // new
elseif($action == "test"){
	// Find
	$id_mysql = quote_smart($link, $id);
	$query = "SELECT ping_on_id, ping_on_title, ping_on_when, ping_on_to_ip, ping_on_last_datetime FROM $t_edb_ping_on WHERE ping_on_id=$id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_ping_on_id, $get_current_ping_on_title, $get_current_ping_on_when, $get_current_ping_on_to_ip, $get_current_ping_on_last_datetime) = $row;
	
	if($get_current_ping_on_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{
		if(isset($_GET['mirror_file_id'])) {
			$mirror_file_id = $_GET['mirror_file_id'];
			$mirror_file_id = strip_tags(stripslashes($mirror_file_id));
		}
		else{
			$mirror_file_id = "";
		}
		$mirror_file_id_mysql = quote_smart($link, $mirror_file_id);

		echo"
		<h1>Test $get_current_ping_on_title</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Ping on</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;editor_language=$editor_language&amp;l=$l\">Test</a>
			</p>
		<!-- //Where am I? -->
		";
		

		// Find the last mirror file
		$query = "SELECT mirror_file_id, mirror_file_case_id, mirror_file_record_id, mirror_file_item_id, mirror_file_path_windows, mirror_file_path_linux, mirror_file_file, mirror_file_ext, mirror_file_type, mirror_file_confirmed_by_human, mirror_file_human_rejected, mirror_file_created_datetime, mirror_file_created_date, mirror_file_created_time, mirror_file_created_date_saying, mirror_file_created_date_ddmmyy, mirror_file_created_date_ddmmyyyy, mirror_file_modified_datetime, mirror_file_modified_date, mirror_file_modified_time, mirror_file_modified_date_saying, mirror_file_modified_date_ddmmyy, mirror_file_modified_date_ddmmyyyy, mirror_file_size_bytes, mirror_file_size_mb, mirror_file_size_human, mirror_file_backup_disk, mirror_file_exists, mirror_file_exists_agent_tries_counter, mirror_file_ready_for_automated_machine, mirror_file_ready_agent_tries_counter, mirror_file_comments FROM $t_edb_case_index_evidence_items_mirror_files ORDER BY mirror_file_id DESC LIMIT 0,1";
		if($mirror_file_id != ""){
			$query = "SELECT mirror_file_id, mirror_file_case_id, mirror_file_record_id, mirror_file_item_id, mirror_file_path_windows, mirror_file_path_linux, mirror_file_file, mirror_file_ext, mirror_file_type, mirror_file_confirmed_by_human, mirror_file_human_rejected, mirror_file_created_datetime, mirror_file_created_date, mirror_file_created_time, mirror_file_created_date_saying, mirror_file_created_date_ddmmyy, mirror_file_created_date_ddmmyyyy, mirror_file_modified_datetime, mirror_file_modified_date, mirror_file_modified_time, mirror_file_modified_date_saying, mirror_file_modified_date_ddmmyy, mirror_file_modified_date_ddmmyyyy, mirror_file_size_bytes, mirror_file_size_mb, mirror_file_size_human, mirror_file_backup_disk, mirror_file_exists, mirror_file_exists_agent_tries_counter, mirror_file_ready_for_automated_machine, mirror_file_ready_agent_tries_counter, mirror_file_comments FROM $t_edb_case_index_evidence_items_mirror_files WHERE mirror_file_id=$mirror_file_id_mysql";
		}
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_mirror_file_id, $get_current_mirror_file_case_id, $get_current_mirror_file_record_id, $get_current_mirror_file_item_id, $get_current_mirror_file_path_windows, $get_current_mirror_file_path_linux, $get_current_mirror_file_file, $get_current_mirror_file_ext, $get_current_mirror_file_type, $get_current_mirror_file_confirmed_by_human, $get_current_mirror_file_human_rejected, $get_current_mirror_file_created_datetime, $get_current_mirror_file_created_date, $get_current_mirror_file_created_time, $get_current_mirror_file_created_date_saying, $get_current_mirror_file_created_date_ddmmyy, $get_current_mirror_file_created_date_ddmmyyyy, $get_current_mirror_file_modified_datetime, $get_current_mirror_file_modified_date, $get_current_mirror_file_modified_time, $get_current_mirror_file_modified_date_saying, $get_current_mirror_file_modified_date_ddmmyy, $get_current_mirror_file_modified_date_ddmmyyyy, $get_current_mirror_file_size_bytes, $get_current_mirror_file_size_mb, $get_current_mirror_file_size_human, $get_current_mirror_file_backup_disk, $get_current_mirror_file_exists, $get_current_mirror_file_exists_agent_tries_counter, $get_current_mirror_file_ready_for_automated_machine, $get_current_mirror_file_ready_agent_tries_counter, $get_current_mirror_file_comments) = $row;
		if($get_current_mirror_file_id == ""){
			echo"<div class=\"error\"><p>Mirror file not found!</p></div>";
			die;
		}

		// Find item
		$query = "SELECT item_id, item_case_id, item_record_id, item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number, item_title, item_parent_item_id, item_type_id, item_type_title, item_confirmed_by_human, item_human_rejected, item_request_text, item_requester_user_id, item_requester_user_name, item_requester_user_alias, item_requester_user_email, item_requester_user_image_path, item_requester_user_image_file, item_requester_user_image_thumb_40, item_requester_user_image_thumb_50, item_requester_user_first_name, item_requester_user_middle_name, item_requester_user_last_name, item_requester_user_job_title, item_requester_user_department, item_in_datetime, item_in_date, item_in_time, item_in_date_saying, item_in_date_ddmmyy, item_in_date_ddmmyyyy, item_storage_shelf_id, item_storage_shelf_title, item_storage_location_id, item_storage_location_abbr, item_comment, item_condition, item_serial_number, item_imei_a, item_imei_b, item_imei_c, item_imei_d, item_os_title, item_os_version, item_name, item_timezone, item_date_now_date, item_date_now_saying, item_date_now_ddmmyy, item_date_now_ddmmyyyy, item_time_now, item_correct_date_now_date, item_correct_date_now_saying, item_correct_date_now_ddmmyy, item_correct_date_now_ddmmyyyy, item_correct_time_now, item_adjust_clock_automatically, item_adjust_time_zone_automatically, item_acquired_software_id_a, item_acquired_software_title_a, item_acquired_software_notes_a, item_acquired_software_id_b, item_acquired_software_title_b, item_acquired_software_notes_b, item_acquired_software_id_c, item_acquired_software_title_c, item_acquired_software_notes_c, item_acquired_date, item_acquired_time, item_acquired_date_saying, item_acquired_date_ddmmyy, item_acquired_date_ddmmyyyy, item_acquired_user_id, item_acquired_user_name, item_acquired_user_alias, item_acquired_user_email, item_acquired_user_image_path, item_acquired_user_image_file, item_acquired_user_image_thumb_40, item_acquired_user_image_thumb_50, item_acquired_user_first_name, item_acquired_user_middle_name, item_acquired_user_last_name, item_out_date, item_out_time, item_out_date_saying, item_out_date_ddmmyy, item_out_date_ddmmyyyy, item_out_notes FROM $t_edb_case_index_evidence_items WHERE item_id=$get_current_mirror_file_item_id";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_item_id, $get_current_item_case_id, $get_current_item_record_id, $get_current_item_record_seized_year, $get_current_item_record_seized_journal, $get_current_item_record_seized_district_number, $get_current_item_numeric_serial_number, $get_current_item_title, $get_current_item_parent_item_id, $get_current_item_type_id, $get_current_item_type_title, $get_current_item_confirmed_by_human, $get_current_item_human_rejected, $get_current_item_request_text, $get_current_item_requester_user_id, $get_current_item_requester_user_name, $get_current_item_requester_user_alias, $get_current_item_requester_user_email, $get_current_item_requester_user_image_path, $get_current_item_requester_user_image_file, $get_current_item_requester_user_image_thumb_40, $get_current_item_requester_user_image_thumb_50, $get_current_item_requester_user_first_name, $get_current_item_requester_user_middle_name, $get_current_item_requester_user_last_name, $get_current_item_requester_user_job_title, $get_current_item_requester_user_department, $get_current_item_in_datetime, $get_current_item_in_date, $get_current_item_in_time, $get_current_item_in_date_saying, $get_current_item_in_date_ddmmyy, $get_current_item_in_date_ddmmyyyy, $get_current_item_storage_shelf_id, $get_current_item_storage_shelf_title, $get_current_item_storage_location_id, $get_current_item_storage_location_abbr, $get_current_item_comment, $get_current_item_condition, $get_current_item_serial_number, $get_current_item_imei_a, $get_current_item_imei_b, $get_current_item_imei_c, $get_current_item_imei_d, $get_current_item_os_title, $get_current_item_os_version, $get_current_item_name, $get_current_item_timezone, $get_current_item_date_now_date, $get_current_item_date_now_saying, $get_current_item_date_now_ddmmyy, $get_current_item_date_now_ddmmyyyy, $get_current_item_time_now, $get_current_item_correct_date_now_date, $get_current_item_correct_date_now_saying, $get_current_item_correct_date_now_ddmmyy, $get_current_item_correct_date_now_ddmmyyyy, $get_current_item_correct_time_now, $get_current_item_adjust_clock_automatically, $get_current_item_adjust_time_zone_automatically, $get_current_item_acquired_software_id_a, $get_current_item_acquired_software_title_a, $get_current_item_acquired_software_notes_a, $get_current_item_acquired_software_id_b, $get_current_item_acquired_software_title_b, $get_current_item_acquired_software_notes_b, $get_current_item_acquired_software_id_c, $get_current_item_acquired_software_title_c, $get_current_item_acquired_software_notes_c, $get_current_item_acquired_date, $get_current_item_acquired_time, $get_current_item_acquired_date_saying, $get_current_item_acquired_date_ddmmyy, $get_current_item_acquired_date_ddmmyyyy, $get_current_item_acquired_user_id, $get_current_item_acquired_user_name, $get_current_item_acquired_user_alias, $get_current_item_acquired_user_email, $get_current_item_acquired_user_image_path, $get_current_item_acquired_user_image_file, $get_current_item_acquired_user_image_thumb_40, $get_current_item_acquired_user_image_thumb_50, $get_current_item_acquired_user_first_name, $get_current_item_acquired_user_middle_name, $get_current_item_acquired_user_last_name, $get_current_item_out_date, $get_current_item_out_time, $get_current_item_out_date_saying, $get_current_item_out_date_ddmmyy, $get_current_item_out_date_ddmmyyyy, $get_current_item_out_notes) = $row;
		

		// Find case
		$query = "SELECT case_id, case_number, case_title, case_title_clean, case_suspect_in_custody, case_code_id, case_code_number, case_code_title, case_status_id, case_status_title, case_priority_id, case_priority_title, case_district_id, case_district_title, case_station_id, case_station_title, case_is_screened, case_physical_location, case_backup_disks, case_confirmed_by_human, case_human_rejected, case_last_event_text, case_path_windows, case_path_linux, case_path_folder_name, case_assigned_to_datetime, case_assigned_to_date, case_assigned_to_time, case_assigned_to_date_saying, case_assigned_to_date_ddmmyy, case_assigned_to_date_ddmmyyyy, case_assigned_to_user_id, case_assigned_to_user_name, case_assigned_to_user_alias, case_assigned_to_user_email, case_assigned_to_user_image_path, case_assigned_to_user_image_file, case_assigned_to_user_image_thumb_40, case_assigned_to_user_image_thumb_50, case_assigned_to_user_first_name, case_assigned_to_user_middle_name, case_assigned_to_user_last_name, case_created_datetime, case_created_date, case_created_time, case_created_date_saying, case_created_date_ddmmyy, case_created_date_ddmmyyyy, case_created_user_id, case_created_user_name, case_created_user_alias, case_created_user_email, case_created_user_image_path, case_created_user_image_file, case_created_user_image_thumb_40, case_created_user_image_thumb_50, case_created_user_first_name, case_created_user_middle_name, case_created_user_last_name, case_detective_user_id, case_detective_user_job_title, case_detective_user_department, case_detective_user_first_name, case_detective_user_middle_name, case_detective_user_last_name, case_detective_user_name, case_detective_user_alias, case_detective_user_email, case_detective_email_alerts, case_detective_user_image_path, case_detective_user_image_file, case_detective_user_image_thumb_40, case_detective_user_image_thumb_50, case_updated_datetime, case_updated_date, case_updated_time, case_updated_date_saying, case_updated_date_ddmmyy, case_updated_date_ddmmyyyy, case_updated_user_id, case_updated_user_name, case_updated_user_alias, case_updated_user_email, case_updated_user_image_path, case_updated_user_image_file, case_updated_user_image_thumb_40, case_updated_user_image_thumb_50, case_updated_user_first_name, case_updated_user_middle_name, case_updated_user_last_name, case_is_closed, case_closed_datetime, case_closed_date, case_closed_time, case_closed_date_saying, case_closed_date_ddmmyy, case_closed_date_ddmmyyyy, case_time_from_created_to_close FROM $t_edb_case_index WHERE case_id=$get_current_mirror_file_case_id";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_case_id, $get_current_case_number, $get_current_case_title, $get_current_case_title_clean, $get_current_case_suspect_in_custody, $get_current_case_code_id, $get_current_case_code_number, $get_current_case_code_title, $get_current_case_status_id, $get_current_case_status_title, $get_current_case_priority_id, $get_current_case_priority_title, $get_current_case_district_id, $get_current_case_district_title, $get_current_case_station_id, $get_current_case_station_title, $get_current_case_is_screened, $get_current_case_physical_location, $get_current_case_backup_disks, $get_current_case_confirmed_by_human, $get_current_case_human_rejected, $get_current_case_last_event_text, $get_current_case_path_windows, $get_current_case_path_linux, $get_current_case_path_folder_name, $get_current_case_assigned_to_datetime, $get_current_case_assigned_to_date, $get_current_case_assigned_to_time, $get_current_case_assigned_to_date_saying, $get_current_case_assigned_to_date_ddmmyy, $get_current_case_assigned_to_date_ddmmyyyy, $get_current_case_assigned_to_user_id, $get_current_case_assigned_to_user_name, $get_current_case_assigned_to_user_alias, $get_current_case_assigned_to_user_email, $get_current_case_assigned_to_user_image_path, $get_current_case_assigned_to_user_image_file, $get_current_case_assigned_to_user_image_thumb_40, $get_current_case_assigned_to_user_image_thumb_50, $get_current_case_assigned_to_user_first_name, $get_current_case_assigned_to_user_middle_name, $get_current_case_assigned_to_user_last_name, $get_current_case_created_datetime, $get_current_case_created_date, $get_current_case_created_time, $get_current_case_created_date_saying, $get_current_case_created_date_ddmmyy, $get_current_case_created_date_ddmmyyyy, $get_current_case_created_user_id, $get_current_case_created_user_name, $get_current_case_created_user_alias, $get_current_case_created_user_email, $get_current_case_created_user_image_path, $get_current_case_created_user_image_file, $get_current_case_created_user_image_thumb_40, $get_current_case_created_user_image_thumb_50, $get_current_case_created_user_first_name, $get_current_case_created_user_middle_name, $get_current_case_created_user_last_name, $get_current_case_detective_user_id, $get_current_case_detective_user_job_title, $get_current_case_detective_user_department, $get_current_case_detective_user_first_name, $get_current_case_detective_user_middle_name, $get_current_case_detective_user_last_name, $get_current_case_detective_user_name, $get_current_case_detective_user_alias, $get_current_case_detective_user_email, $get_current_case_detective_email_alerts, $get_current_case_detective_user_image_path, $get_current_case_detective_user_image_file, $get_current_case_detective_user_image_thumb_40, $get_current_case_detective_user_image_thumb_50, $get_current_case_updated_datetime, $get_current_case_updated_date, $get_current_case_updated_time, $get_current_case_updated_date_saying, $get_current_case_updated_date_ddmmyy, $get_current_case_updated_date_ddmmyyyy, $get_current_case_updated_user_id, $get_current_case_updated_user_name, $get_current_case_updated_user_alias, $get_current_case_updated_user_email, $get_current_case_updated_user_image_path, $get_current_case_updated_user_image_file, $get_current_case_updated_user_image_thumb_40, $get_current_case_updated_user_image_thumb_50, $get_current_case_updated_user_first_name, $get_current_case_updated_user_middle_name, $get_current_case_updated_user_last_name, $get_current_case_is_closed, $get_current_case_closed_datetime, $get_current_case_closed_date, $get_current_case_closed_time, $get_current_case_closed_date_saying, $get_current_case_closed_date_ddmmyy, $get_current_case_closed_date_ddmmyyyy, $get_current_case_time_from_created_to_close) = $row;
		


		echo"
		<!-- Focus -->
			<script>
			\$(document).ready(function(){
				\$('[name=\"inp_title\"]').focus();
			});
			</script>
		<!-- //Focus -->

		<!-- Select mirror file form -->
			<form method=\"get\" action=\"index.php?&amp;process=1\" enctype=\"multipart/form-data\">
			<p>
			<input type=\"hidden\" name=\"open\" value=\"$open\" />
			<input type=\"hidden\" name=\"page\" value=\"$page\" />
			<input type=\"hidden\" name=\"action\" value=\"$action\" />
			<input type=\"hidden\" name=\"id\" value=\"$id\" />
			<input type=\"hidden\" name=\"l\" value=\"$l\" />

			<b>Item ID:</b> <a href=\"../edb/open_case_evidence.php?case_id=$get_current_case_id\">$get_current_item_id</a><br />
			<b>Case ID:</b> <a href=\"../edb/open_case_overview.php?case_id=$get_current_case_id\">$get_current_case_id</a><br />
			<b>Mirror File ID:</b>	<input type=\"text\" name=\"mirror_file_id\" value=\"$get_current_mirror_file_id\" size=\"5\" /> <input type=\"submit\" value=\"Change Mirror File\" class=\"btn_default\" /><br />
			<b>Ping title:</b> $get_current_ping_on_title<br />
			<b>Ping when:</b> $get_current_ping_on_when<br />
			<b>Ping to:</b> $get_current_ping_on_to_ip</p>

			</form>
		<!-- //Select mirror file form -->
		";

		// Array to ping
		$rows_array = array();

		if($get_current_ping_on_when == "new_mirror_file" OR $get_current_ping_on_when == "mirror_file_ready_for_automated_machine"){

			$query = "SELECT case_id, case_number, case_title, case_title_clean, case_suspect_in_custody, case_code_id, case_code_number, case_code_title, case_status_id, case_status_title, case_priority_id, case_priority_title, case_district_id, case_district_title, case_station_id, case_station_title, case_is_screened, case_physical_location, case_backup_disks, case_confirmed_by_human, case_human_rejected, case_last_event_text, case_path_windows, case_path_linux, case_path_folder_name, case_assigned_to_datetime, case_assigned_to_date, case_assigned_to_time, case_assigned_to_date_saying, case_assigned_to_date_ddmmyy, case_assigned_to_date_ddmmyyyy, case_assigned_to_user_id, case_assigned_to_user_name, case_assigned_to_user_alias, case_assigned_to_user_email, case_assigned_to_user_image_path, case_assigned_to_user_image_file, case_assigned_to_user_image_thumb_40, case_assigned_to_user_image_thumb_50, case_assigned_to_user_first_name, case_assigned_to_user_middle_name, case_assigned_to_user_last_name, case_created_datetime, case_created_date, case_created_time, case_created_date_saying, case_created_date_ddmmyy, case_created_date_ddmmyyyy, case_created_user_id, case_created_user_name, case_created_user_alias, case_created_user_email, case_created_user_image_path, case_created_user_image_file, case_created_user_image_thumb_40, case_created_user_image_thumb_50, case_created_user_first_name, case_created_user_middle_name, case_created_user_last_name, case_detective_user_id, case_detective_user_job_title, case_detective_user_department, case_detective_user_first_name, case_detective_user_middle_name, case_detective_user_last_name, case_detective_user_name, case_detective_user_alias, case_detective_user_email, case_detective_email_alerts, case_detective_user_image_path, case_detective_user_image_file, case_detective_user_image_thumb_40, case_detective_user_image_thumb_50, case_updated_datetime, case_updated_date, case_updated_time, case_updated_date_saying, case_updated_date_ddmmyy, case_updated_date_ddmmyyyy, case_updated_user_id, case_updated_user_name, case_updated_user_alias, case_updated_user_email, case_updated_user_image_path, case_updated_user_image_file, case_updated_user_image_thumb_40, case_updated_user_image_thumb_50, case_updated_user_first_name, case_updated_user_middle_name, case_updated_user_last_name, case_is_closed, case_closed_datetime, case_closed_date, case_closed_time, case_closed_date_saying, case_closed_date_ddmmyy, case_closed_date_ddmmyyyy, case_time_from_created_to_close FROM $t_edb_case_index WHERE case_id=$get_current_case_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			$rows_array['case_index'] = $row;

			$query = "SELECT mirror_file_id, mirror_file_case_id, mirror_file_record_id, mirror_file_item_id, mirror_file_path_windows, mirror_file_path_linux, mirror_file_file, mirror_file_ext, mirror_file_type, mirror_file_confirmed_by_human, mirror_file_human_rejected, mirror_file_created_datetime, mirror_file_created_date, mirror_file_created_time, mirror_file_created_date_saying, mirror_file_created_date_ddmmyy, mirror_file_created_date_ddmmyyyy, mirror_file_modified_datetime, mirror_file_modified_date, mirror_file_modified_time, mirror_file_modified_date_saying, mirror_file_modified_date_ddmmyy, mirror_file_modified_date_ddmmyyyy, mirror_file_size_bytes, mirror_file_size_mb, mirror_file_size_human, mirror_file_backup_disk, mirror_file_exists, mirror_file_exists_agent_tries_counter, mirror_file_ready_for_automated_machine, mirror_file_ready_agent_tries_counter, mirror_file_comments FROM $t_edb_case_index_evidence_items_mirror_files WHERE mirror_file_id=$get_current_mirror_file_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			$rows_array['mirror_file'] = $row;

			$query = "SELECT * FROM $t_edb_case_index_evidence_items WHERE item_id=$get_current_mirror_file_item_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			$rows_array['evidence_item'] = $row;




		} // new mirrir file, mirror_file_ready_for_automated_machine
		elseif($get_current_ping_on_when == "new_password"){
		
			$query_case = "SELECT case_id, case_number, case_title, case_title_clean, case_suspect_in_custody, case_code_id, case_code_number, case_code_title, case_status_id, case_status_title, case_priority_id, case_priority_title, case_district_id, case_district_title, case_station_id, case_station_title, case_is_screened, case_physical_location, case_backup_disks, case_confirmed_by_human, case_human_rejected, case_last_event_text, case_path_windows, case_path_linux, case_path_folder_name, case_assigned_to_datetime, case_assigned_to_date, case_assigned_to_time, case_assigned_to_date_saying, case_assigned_to_date_ddmmyy, case_assigned_to_date_ddmmyyyy, case_assigned_to_user_id, case_assigned_to_user_name, case_assigned_to_user_alias, case_assigned_to_user_email, case_assigned_to_user_image_path, case_assigned_to_user_image_file, case_assigned_to_user_image_thumb_40, case_assigned_to_user_image_thumb_50, case_assigned_to_user_first_name, case_assigned_to_user_middle_name, case_assigned_to_user_last_name, case_created_datetime, case_created_date, case_created_time, case_created_date_saying, case_created_date_ddmmyy, case_created_date_ddmmyyyy, case_created_user_id, case_created_user_name, case_created_user_alias, case_created_user_email, case_created_user_image_path, case_created_user_image_file, case_created_user_image_thumb_40, case_created_user_image_thumb_50, case_created_user_first_name, case_created_user_middle_name, case_created_user_last_name, case_detective_user_id, case_detective_user_job_title, case_detective_user_department, case_detective_user_first_name, case_detective_user_middle_name, case_detective_user_last_name, case_detective_user_name, case_detective_user_alias, case_detective_user_email, case_detective_email_alerts, case_detective_user_image_path, case_detective_user_image_file, case_detective_user_image_thumb_40, case_detective_user_image_thumb_50, case_updated_datetime, case_updated_date, case_updated_time, case_updated_date_saying, case_updated_date_ddmmyy, case_updated_date_ddmmyyyy, case_updated_user_id, case_updated_user_name, case_updated_user_alias, case_updated_user_email, case_updated_user_image_path, case_updated_user_image_file, case_updated_user_image_thumb_40, case_updated_user_image_thumb_50, case_updated_user_first_name, case_updated_user_middle_name, case_updated_user_last_name, case_is_closed, case_closed_datetime, case_closed_date, case_closed_time, case_closed_date_saying, case_closed_date_ddmmyy, case_closed_date_ddmmyyyy, case_time_from_created_to_close FROM $t_edb_case_index WHERE case_id=$get_current_case_id";
			$result_case = mysqli_query($link, $query_case);
			$row_case = mysqli_fetch_array($result_case, MYSQLI_ASSOC);
			$rows_array['case_index'] = $row_case;
		
			$x = 0;
			$query = "SELECT password_id, password_case_id, password_item_id, password_available_id, password_available_title, password_item_type_id, password_set_number, password_value, password_tag_a, password_tag_b, password_tag_c, password_created_by_user_id, password_created_by_user_name, password_created_datetime, password_updated_by_user_id, password_updated_by_user_name, password_updated_datetime FROM $t_edb_case_index_evidence_items_passwords WHERE password_case_id=$get_current_case_id";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_password_id, $get_password_case_id, $get_password_item_id, $get_password_available_id, $get_password_available_title, $get_password_item_type_id, $get_password_set_number, $get_password_value, $get_password_tag_a, $get_password_tag_b, $get_password_tag_c, $get_password_created_by_user_id, $get_password_created_by_user_name, $get_password_created_datetime, $get_password_updated_by_user_id, $get_password_updated_by_user_name, $get_password_updated_datetime) = $row;


				$rows_array['evidence_items_passwords'][$x]['password_id'] = "$get_password_id";
				$rows_array['evidence_items_passwords'][$x]['password_case_id'] = "$get_password_case_id";
				$rows_array['evidence_items_passwords'][$x]['password_item_id'] = "$get_password_item_id";
				$rows_array['evidence_items_passwords'][$x]['password_available_id'] = "$get_password_available_id";
				$rows_array['evidence_items_passwords'][$x]['password_available_title'] = "$get_password_available_title";
				$rows_array['evidence_items_passwords'][$x]['password_item_type_id'] = "$get_password_item_type_id";
				$rows_array['evidence_items_passwords'][$x]['password_set_number'] = "$get_password_set_number";
				$rows_array['evidence_items_passwords'][$x]['password_value'] = "$get_password_value";
				$rows_array['evidence_items_passwords'][$x]['password_tag_a'] = "$get_password_tag_a";
				$rows_array['evidence_items_passwords'][$x]['password_tag_b'] = "$get_password_tag_b";
				$rows_array['evidence_items_passwords'][$x]['password_tag_c'] = "$get_password_tag_c";
				$rows_array['evidence_items_passwords'][$x]['password_created_by_user_id'] = "$get_password_created_by_user_id";
				$rows_array['evidence_items_passwords'][$x]['password_created_by_user_name'] = "$get_password_created_by_user_name";
				$rows_array['evidence_items_passwords'][$x]['password_created_datetime'] = "$get_password_created_datetime";
				$rows_array['evidence_items_passwords'][$x]['password_updated_by_user_id'] = "$get_password_updated_by_user_id";
				$rows_array['evidence_items_passwords'][$x]['password_updated_by_user_name'] = "$get_password_updated_by_user_name";
				$rows_array['evidence_items_passwords'][$x]['password_updated_datetime'] = "$get_password_updated_datetime";


				$x++;
			}



		}


		// Json everything
		$rows_json = json_encode(utf8ize($rows_array));

		// PING
		$curl = curl_init($get_current_ping_on_to_ip);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER,
		        array("Content-type: application/json"));
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $rows_json);
		
		$json_response = curl_exec($curl);

		$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

		if ($status == 200 OR $status == 201) {
			curl_close($curl);
			$response = json_decode($json_response, true);

			echo"
			<p><b>Result:</b> Ping new mirror file to $get_current_ping_on_to_ip. Response: $response.</p>";
		}
		else{
			echo"
			<p><b>Result:</b> <span style=\"color:red;\">Ping new mirror file to $get_current_ping_on_to_ip. Failed with status $status.</span>
			</p>";
		}

		echo"<p><b>Json sent:</b></p><pre>";

		$json = json_decode($rows_json);
		echo json_encode($json, JSON_PRETTY_PRINT);
		echo"</pre>";

	} // ping on id found
} // test
?>