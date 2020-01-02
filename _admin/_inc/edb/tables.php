<?php
/**
*
* File: _admin/_inc/edb/tables.php
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

$t_edb_case_index_item_info_groups	= $mysqlPrefixSav . "edb_case_index_item_info_groups";
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



/*- Other tables ------------------------------------------------------------------------------------------------------ */
$t_users_professional	= $mysqlPrefixSav . "users_professional";

if($action == ""){
	echo"
	<h1>Tables</h1>


	<!-- Where am I? -->
	<p><b>You are here:</b><br />
	<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence</a>
	&gt;
	<a href=\"index.php?open=edb&amp;page=tables&amp;editor_language=$editor_language&amp;l=$l\">Tables</a>
	</p>
	<!-- //Where am I? -->



	<!-- edb_liquidbase-->
	";
	$query = "SELECT * FROM $t_edb_liquidbase LIMIT 1";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_edb_liquidbase: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_edb_liquidbase(
		  liquidbase_id INT NOT NULL AUTO_INCREMENT,
		  PRIMARY KEY(liquidbase_id), 
		   liquidbase_dir VARCHAR(200), 
		   liquidbase_file VARCHAR(200), 
		   liquidbase_run_datetime DATETIME, 
		   liquidbase_run_saying VARCHAR(200))")
	  	 or die(mysqli_error());	
	}
	echo"
	<!-- edb_liquidbase-->


	<!-- Feedback -->
		";
		if($ft != "" && $fm != ""){
			if($fm == "changes_saved"){
				$fm = "$l_changes_saved";
			}
			else{
				$fm = ucfirst($fm);
			}
			echo"<div class=\"$ft\"><p>$fm</p></div>";
		}
		echo"
	<!-- //Feedback -->

	<!-- Run -->
		";
		$path = "_inc/edb/_liquidbase_db_scripts";
		if(!(is_dir("$path"))){
			echo"$path doesnt exists";
			die;
		}
		if ($handle = opendir($path)) {
			$modules = array();   
			while (false !== ($module = readdir($handle))) {
				if ($module === '.') continue;
				if ($module === '..') continue;
				array_push($modules, $module);
			}
	


			sort($modules);
			foreach ($modules as $module){
				$liquidbase_names = array();   

				// Open that year folder
				$path_module = "_inc/edb/_liquidbase_db_scripts/$module";
				if ($handle_year = opendir($path_module)) {
					while (false !== ($liquidbase_name = readdir($handle_year))) {
						if ($liquidbase_name === '.') continue;
						if ($liquidbase_name === '..') continue;
						array_push($liquidbase_names, $liquidbase_name);
					}
					sort($liquidbase_names);
					foreach ($liquidbase_names as $liquidbase_name){
				
						if(!(is_dir("_inc/edb/_liquidbase_db_scripts/$module/$liquidbase_name"))){

							// Has it been executed?
							$inp_liquidbase_module_mysql = quote_smart($link, $module);
							$inp_liquidbase_name_mysql = quote_smart($link, $liquidbase_name);
					
							$query = "SELECT liquidbase_id FROM $t_edb_liquidbase WHERE liquidbase_dir=$inp_liquidbase_module_mysql AND liquidbase_file=$inp_liquidbase_name_mysql";
							$result = mysqli_query($link, $query);
							$row = mysqli_fetch_row($result);
							list($get_liquidbase_id) = $row;
							if($get_liquidbase_id == ""){
								// Date
								$datetime = date("Y-m-d H:i:s");
								$run_saying = date("j M Y H:i");


								// Insert
								mysqli_query($link, "INSERT INTO $t_edb_liquidbase 
								(liquidbase_id, liquidbase_dir, liquidbase_file, liquidbase_run_datetime, liquidbase_run_saying) 
								VALUES 
								(NULL, $inp_liquidbase_module_mysql, $inp_liquidbase_name_mysql, '$datetime', '$run_saying')")
								or die(mysqli_error($link));

								// Run code
								include("_inc/edb/_liquidbase_db_scripts/$module/$liquidbase_name");
							} // not runned before
						} // is dir
					} // whule open files
				} // handle modules
			} // while open modules
		} // handle opendir path
		echo"
	<!-- //Run -->

	<!-- liquidbase scripts -->
		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\">
			<span>Directory</span>
		   </th>
		   <th scope=\"col\">
			<span>File</span>
		   </th>
		   <th scope=\"col\">
			<span>Run date</span>
		   </th>
		   <th scope=\"col\">
			<span>Actions</span>
		   </th>
		  </tr>
		</thead>
		<tbody>
	";

	$query = "SELECT liquidbase_id, liquidbase_dir, liquidbase_file, liquidbase_run_datetime, liquidbase_run_saying FROM $t_edb_liquidbase ORDER BY liquidbase_id DESC";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_liquidbase_id, $get_liquidbase_dir, $get_liquidbase_file, $get_liquidbase_run_datetime, $get_liquidbase_run_saying) = $row;

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
			<span>$get_liquidbase_dir</span>
		  </td>
		  <td class=\"$style\">
			<span>$get_liquidbase_file</span>
		  </td>
		  <td class=\"$style\">
			<span>$get_liquidbase_run_saying</span>
		  </td>
		  <td class=\"$style\">
			<span>
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=delete&amp;liquidbase_id=$get_liquidbase_id&amp;editor_language=$editor_language\">$l_delete</a></span>
		  </td>
		 </tr>
		";

	}
	echo"
		 </tbody>
		</table>

	<!-- //liquidbase scripts -->
	";
}
elseif($action == "delete"){
	if(isset($_GET['liquidbase_id'])) {
		$liquidbase_id = $_GET['liquidbase_id'];
		$liquidbase_id  = strip_tags(stripslashes($liquidbase_id));
	}
	else{
		$liquidbase_id = "";
	}
	$liquidbase_id_mysql = quote_smart($link, $liquidbase_id);
	$query = "SELECT liquidbase_id, liquidbase_file, liquidbase_run_datetime FROM $t_edb_liquidbase WHERE liquidbase_id=$liquidbase_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_liquidbase_id, $get_liquidbase_file, $get_liquidbase_run_datetime) = $row;

	if($get_liquidbase_id != ""){
		if($process == "1"){

			mysqli_query($link, "DELETE FROM $t_edb_liquidbase WHERE liquidbase_id=$get_liquidbase_id") or die(mysqli_error($link));

			$url = "index.php?open=$open&page=$page&ft=success&fm=deleted";
			header("Location: $url");
			exit;
		}

		echo"
		<h1>Delete_liquidbase $get_liquidbase_file</h1>


		<p>
		Are you sure you want to dlete the liquidbase script run? 
		This will cause the script to run again after deletion. 
		</p>

		<p>
		<a href=\"index.php?open=$open&amp;page=$page&amp;action=delete&amp;liquidbase_id=$get_liquidbase_id&amp;editor_language=$editor_language&amp;process=1\" class=\"btn_warning\">Confirm delete</a>
		</p>
		";
	}
}



?>