<?php
/**
*
* File: _admin/_inc/edb/glossaries.php
* Version 19:25 22.08.2019
* Copyright (c) 2019 Sindre Andre Ditlefsen
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
$t_edb_case_index_glossaries			= $mysqlPrefixSav . "edb_case_index_glossaries";
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

$t_edb_glossaries		= $mysqlPrefixSav . "edb_glossaries";

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
if(isset($_GET['glossary_id'])) {
	$glossary_id = $_GET['glossary_id'];
	$glossary_id = strip_tags(stripslashes($glossary_id));
}
else{
	$glossary_id = "";
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
	<h1>Glossaries</h1>


	<!-- Where am I? -->
		<p><b>You are here:</b><br />
		<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
		&gt;
		<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Glossaries</a>
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

	<!-- Navigation + Search -->
		<table>
		 <tr>
		  <td>
			<!-- Navigation -->
				<p>
				<a href=\"index.php?open=edb&amp;page=$page&amp;action=new&amp;order_by=$;order_by&amp;order_method=$order_method&amp;editor_language=$editor_language&amp;l=$l\" class=\"btn_default\">New</a>
				</p>
			<!-- //Navigation -->
		  </td>
		  <td style=\"padding-left: 6px;\">
			
		  </td>
		 </tr>
		</table>
	<!-- //Navigation + Search -->


	<!-- Case codes -->

		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\">";

			if($order_by == ""){
				$order_by = "glossary_id";
			}
			if($order_by == "glossary_id" && $order_method == "asc"){
				$order_method_link = "desc";
			}
			else{
				$order_method_link = "asc";
			}

			echo"
			<span><a href=\"index.php?open=edb&amp;page=$page&amp;order_by=glossary_id&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>ID</b></a>";
			if($order_by == "glossary_id" && $order_method == "asc"){
				echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
			}
			if($order_by == "glossary_id" && $order_method == "desc"){
				echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
			}
	
			echo"</span>
		   </th>
		   <th scope=\"col\">";
			if($order_by == "glossary_title" && $order_method == "asc"){
				$order_method_link = "desc";
			}
			else{
				$order_method_link = "asc";
			}

			echo"
			<span><a href=\"index.php?open=edb&amp;page=$page&amp;order_by=glossary_title&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>Title</b></a>";
			if($order_by == "glossary_title" && $order_method == "asc"){
				echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
			}
			if($order_by == "glossary_title" && $order_method == "desc"){
				echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
			}
	
			echo"</span>
		   </th>
		  </tr>
		 </thead>
		 <tbody id=\"autosearch_search_results_hide\">

		";
		$query = "SELECT glossary_id, glossary_title, glossary_description FROM $t_edb_glossaries";
		if($order_by == "glossary_id" OR $order_by == "glossary_title"){
			if($order_method  == "asc" OR $order_method == "desc"){
				$query = $query  . " ORDER BY $order_by $order_method";
			}
		}



		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_glossary_id, $get_glossary_title, $get_glossary_description) = $row;
			
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
				<a href=\"index.php?open=$open&amp;page=$page&amp;action=open&amp;glossary_id=$get_glossary_id&amp;l=$l&amp;editor_language=$editor_language\">$get_glossary_id</a>
				</span>
			  </td>
			  <td class=\"$style\">
				<span>
				<a href=\"index.php?open=$open&amp;page=$page&amp;action=open&amp;glossary_id=$get_glossary_id&amp;l=$l&amp;editor_language=$editor_language\">$get_glossary_title</a>
				</span>
			  </td>
			 </tr>";
		} // while
		
		echo"
		 </tbody>
		</table>
	<!-- //Case codes -->
	";
} // action == ""
elseif($action == "new"){
	if($process == "1"){

		$inp_title = $_POST['inp_title'];
		$inp_title = output_html($inp_title);
		$inp_title_mysql = quote_smart($link, $inp_title);

		$inp_description = $_POST['inp_description'];
		$inp_description = output_html($inp_description);
		$inp_description_mysql = quote_smart($link, $inp_description);

		$inp_words = $_POST['inp_words'];
		$inp_words = output_html($inp_words);
		$inp_words = str_replace("<br />", "\n", $inp_words);
		$inp_words_mysql = quote_smart($link, $inp_words);


		mysqli_query($link, "INSERT INTO $t_edb_glossaries
		(glossary_id, glossary_title, glossary_description, glossary_words) 
		VALUES 
		(NULL, $inp_title_mysql, $inp_description_mysql, $inp_words_mysql)
		") or die(mysqli_error($link));

		$url = "index.php?open=edb&page=$page&action=new&order_by=$order_by&order_method=$order_method&editor_language=$editor_language&l=$l&ft=success&fm=created_$inp_title";
		header("Location: $url");
		exit;
	}
	echo"
	<h1>New</h1>


	<!-- Where am I? -->
		<p><b>You are here:</b><br />
		<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
		&gt;
		<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Glossaries</a>
		&gt;
		<a href=\"index.php?open=edb&amp;page=$page&amp;action=new&amp;editor_language=$editor_language&amp;l=$l\">New</a>
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

	<!-- New form -->";
		
		echo"
		<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

		<p>Title:<br />
		<input type=\"text\" name=\"inp_title\" value=\"\" size=\"25\" />
		</p>

		<p>Description:<br />
		<textarea name=\"inp_description\" rows=\"3\" cols=\"40\"></textarea>
		</p>

		<p>Words::<br />
		<textarea name=\"inp_words\" rows=\"15\" cols=\"120\"></textarea>
		</p>

		<p><input type=\"submit\" value=\"Create\" class=\"btn_default\" /></p>

		</form>
	<!-- //New form -->

	";

} // new
elseif($action == "open"){
	// Find item type
	$glossary_id_mysql = quote_smart($link, $glossary_id);
	$query = "SELECT glossary_id, glossary_title, glossary_description, glossary_words, glossary_last_used_datetime FROM $t_edb_glossaries WHERE glossary_id=$glossary_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_glossary_id, $get_current_glossary_title, $get_current_glossary_description, $get_current_glossary_words, $get_current_glossary_last_used_datetime ) = $row;
	
	if($get_current_glossary_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{

	

		if($process == "1"){
	
			$inp_title = $_POST['inp_title'];
			$inp_title = output_html($inp_title);
			$inp_title_mysql = quote_smart($link, $inp_title);

			$inp_description = $_POST['inp_description'];
			$inp_description = output_html($inp_description);
			$inp_description_mysql = quote_smart($link, $inp_description);

			$inp_words = $_POST['inp_words'];
			$inp_words = output_html($inp_words);
			$inp_words = str_replace("<br />", "\n", $inp_words);
			$inp_words_mysql = quote_smart($link, $inp_words);


			$result = mysqli_query($link, "UPDATE $t_edb_glossaries SET 
						glossary_title=$inp_title_mysql,
					 	glossary_description=$inp_description_mysql,
						glossary_words=$inp_words_mysql 
					 WHERE glossary_id=$get_current_glossary_id") or die(mysqli_error($link));



			$url = "index.php?open=edb&page=$page&action=$action&glossary_id=$get_current_glossary_id&order_by=$order_by&order_method=$order_method&editor_language=$editor_language&l=$l&ft=success&fm=changes_saved";
			header("Location: $url");
			exit;
		}
		echo"
		<h1>$get_current_glossary_title</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Glossaries</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;glossary_id=$get_current_glossary_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_glossary_title</a>
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
			<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;glossary_id=$get_current_glossary_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
		
			<p>Title:<br />
			<input type=\"text\" name=\"inp_title\" value=\"$get_current_glossary_title\" size=\"25\" />
			</p>

			<p>Description:<br />
			<textarea name=\"inp_description\" rows=\"3\" cols=\"40\">";
			$get_current_glossary_description = str_replace("<br />", "\n", $get_current_glossary_description);
			echo"$get_current_glossary_description</textarea>
			</p>

			<p>Words::<br />
			<textarea name=\"inp_words\" rows=\"15\" cols=\"120\">";
			$get_current_glossary_words = str_replace("<br />", "\n", $get_current_glossary_words);
			echo"$get_current_glossary_words</textarea>
			</p>

			<p><input type=\"submit\" value=\"Save changes\" class=\"btn_default\" />
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=delete&amp;glossary_id=$get_current_glossary_id&amp;l=$l\" class=\"btn_warning\">Delete</a></p>
	
			</form>
		<!-- //New form -->

		";
	} // glossary found
} // open_district
elseif($action == "delete"){
	// Find item type
	$glossary_id_mysql = quote_smart($link, $glossary_id);
	$query = "SELECT glossary_id, glossary_title, glossary_description, glossary_words, glossary_last_used_datetime FROM $t_edb_glossaries WHERE glossary_id=$glossary_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_glossary_id, $get_current_glossary_title, $get_current_glossary_description, $get_current_glossary_words, $get_current_glossary_last_used_datetime ) = $row;
	
	if($get_current_glossary_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{

	

		if($process == "1"){



			$result = mysqli_query($link, "DELETE FROM $t_edb_glossaries WHERE glossary_id=$get_current_glossary_id") or die(mysqli_error($link));



			$url = "index.php?open=edb&page=$page&order_by=$order_by&order_method=$order_method&editor_language=$editor_language&l=$l&ft=success&fm=deleted";
			header("Location: $url");
			exit;
		}
		echo"
		<h1>$get_current_glossary_title</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Glossaries</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;glossary_id=$get_current_glossary_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_glossary_title</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;glossary_id=$get_current_glossary_id&amp;editor_language=$editor_language&amp;l=$l\">Delete</a>
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
			<p>
			Are you sure you want to delete? The action cannot be undone.
			</p>

			<p>
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;glossary_id=$get_current_glossary_id&amp;l=$l&amp;process=1\" class=\"btn_danger\">Confirm</a>
			</p>
		<!-- //Delete form -->

		";
	} // glossary found
} // delete
?>