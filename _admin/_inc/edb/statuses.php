<?php
/**
*
* File: _admin/_inc/edb/statuses.php
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
$t_edb_case_index		= $mysqlPrefixSav . "edb_case_index";
$t_edb_case_codes		= $mysqlPrefixSav . "edb_case_codes";
$t_edb_case_statuses		= $mysqlPrefixSav . "edb_case_statuses";
$t_edb_case_priorities		= $mysqlPrefixSav . "edb_case_priorities";


$t_edb_physical_locations_index		= $mysqlPrefixSav . "edb_physical_locations_index";
$t_edb_physical_locations_directories	= $mysqlPrefixSav . "edb_physical_locations_directories";

$t_edb_software_index	= $mysqlPrefixSav . "edb_software_index";

/*- Variables -------------------------------------------------------------------------- */
if(isset($_GET['status_id'])) {
	$status_id = $_GET['status_id'];
	$status_id = strip_tags(stripslashes($status_id));
}
else{
	$status_id = "";
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
	<h1>Statuses</h1>


	<!-- Where am I? -->
		<p><b>You are here:</b><br />
		<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
		&gt;
		<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Statuses</a>
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


	<!-- Case codes -->

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
			<span><b>Weight</b></span>
		   </th>
		   <th scope=\"col\">
			<span><b>On person view show without person</b></span>
		   </th>
		   <th scope=\"col\">
			<span><b>When case is given status, then close the case</b></span>
		   </th>
		   <th scope=\"col\">
			<span><b>Show on stats page</b></span>
		   </th>
		   <th scope=\"col\">
			<span><b>Points given for this status</b></span>
		   </th>
		  </tr>
		 </thead>
		 <tbody id=\"autosearch_search_results_hide\">

		";
		$human_counter = 1;
		$query = "SELECT status_id, status_title, status_title_clean, status_bg_color, status_border_color, status_text_color, status_link_color, status_weight, status_number_of_cases_now, status_number_of_cases_max, status_show_on_front_page, status_on_given_status_do_close_case, status_on_person_view_show_without_person, status_show_on_stats_page, status_gives_amount_of_points_to_user FROM $t_edb_case_statuses";
		$query = $query  . " ORDER BY status_weight ASC";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_status_id, $get_status_title, $get_status_title_clean, $get_status_bg_color, $get_status_border_color, $get_status_text_color, $get_status_link_color, $get_status_weight, $get_status_number_of_cases_now, $get_status_number_of_cases_max, $get_status_show_on_front_page, $get_status_on_given_status_do_close_case, $get_status_on_person_view_show_without_person, $get_status_show_on_stats_page, $get_status_gives_amount_of_points_to_user) = $row;
			
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
				<a id=\"#priority$get_status_id\"></a>
				<span>
				<a href=\"index.php?open=$open&amp;page=$page&amp;action=edit&amp;status_id=$get_status_id&amp;l=$l&amp;editor_language=$editor_language\">$get_status_id</a>
				</span>
			  </td>
			  <td class=\"$style\">
				<span>
				<a href=\"index.php?open=$open&amp;page=$page&amp;action=edit&amp;status_id=$get_status_id&amp;l=$l&amp;editor_language=$editor_language\">$get_status_title</a>
				</span>
			  </td>
			  <td class=\"$style\">
				<span>
				<a href=\"index.php?open=$open&amp;page=$page&amp;action=edit&amp;status_id=$get_status_id&amp;l=$l&amp;editor_language=$editor_language\">$get_status_weight</a>
				</span>
			  </td>
			  <td class=\"$style\">
				<span>
				";
				if($get_status_on_person_view_show_without_person == "1"){
					echo"Yes";
				}
				else{
					echo"No";
				}
				echo"
				</span>
			  </td>
			  <td class=\"$style\">
				<span>
				";
				if($get_status_on_given_status_do_close_case == "1"){
					echo"Yes";
				}
				else{
					echo"No";
				}
				echo"
				</span>
			  </td>
			  <td class=\"$style\">
				<span>
				";
				if($get_status_show_on_stats_page == "1"){
					echo"Yes";
				}
				else{
					echo"No";
				}
				echo"
				</span>
			  </td>
			  <td class=\"$style\">
				<span>
				$get_status_gives_amount_of_points_to_user
				</span>
			  </td>
			 </tr>";

			if($human_counter != "$get_status_weight"){
				$result_update = mysqli_query($link, "UPDATE $t_edb_case_statuses SET status_weight=$human_counter WHERE status_id=$get_status_id") or die(mysqli_error($link));
				echo"
				<img src=\"_design/gfx/loading_22.gif\" alt=\"loading_22.gif\" /> <h2>Updating weight</h2>

				<meta http-equiv=\"refresh\" content=\"1;URL='index.php?open=edb&page=$page&editor_language=$editor_language&l=$l'\" />    
				";
			}

			$human_counter++;
		} // while
		
		echo"
		 </tbody>
		</table>
		<table class=\"hor-zebra\" id=\"autosearch_search_results_show\">
		</table>
	<!-- //statuses -->
	";
} // action == ""
elseif($action == "edit"){
	// Find
	$status_id_mysql = quote_smart($link, $status_id);
	$query = "SELECT status_id, status_title, status_title_clean, status_bg_color, status_border_color, status_text_color, status_link_color, status_weight, status_number_of_cases_now, status_number_of_cases_max, status_show_on_front_page, status_on_given_status_do_close_case, status_on_person_view_show_without_person, status_show_on_stats_page, status_gives_amount_of_points_to_user FROM $t_edb_case_statuses WHERE status_id=$status_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_status_id, $get_current_status_title, $get_current_status_title_clean, $get_current_status_bg_color, $get_current_status_border_color, $get_current_status_text_color, $get_current_status_link_color, $get_current_status_weight, $get_current_status_number_of_cases_now, $get_current_status_number_of_cases_max, $get_current_status_show_on_front_page, $get_current_status_on_given_status_do_close_case, $get_current_status_on_person_view_show_without_person, $get_current_status_show_on_stats_page, $get_current_status_gives_amount_of_points_to_user) = $row;
	
	if($get_current_status_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{

	

		if($process == "1"){


			$inp_title = $_POST['inp_title'];
			$inp_title = output_html($inp_title);
			$inp_title_mysql = quote_smart($link, $inp_title);

			$inp_title_clean = clean($inp_title);
			$inp_title_clean_mysql = quote_smart($link, $inp_title_clean);

			$inp_bg_color = $_POST['inp_bg_color'];
			$inp_bg_color = output_html($inp_bg_color);
			$inp_bg_color_mysql = quote_smart($link, $inp_bg_color);

			$inp_border_color = $_POST['inp_border_color'];
			$inp_border_color = output_html($inp_border_color);
			$inp_border_color_mysql = quote_smart($link, $inp_border_color);

			$inp_text_color = $_POST['inp_text_color'];
			$inp_text_color = output_html($inp_text_color);
			$inp_text_color_mysql = quote_smart($link, $inp_text_color);

			$inp_link_color = $_POST['inp_link_color'];
			$inp_link_color = output_html($inp_link_color);
			$inp_link_color_mysql = quote_smart($link, $inp_link_color);

			$inp_weight = $_POST['inp_weight'];
			$inp_weight = output_html($inp_weight);
			$inp_weight_mysql = quote_smart($link, $inp_weight);

			$inp_number_of_cases_max = $_POST['inp_number_of_cases_max'];
			$inp_number_of_cases_max = output_html($inp_number_of_cases_max);
			$inp_number_of_cases_max_mysql = quote_smart($link, $inp_number_of_cases_max);

			$inp_show_on_front_page = $_POST['inp_show_on_front_page'];
			$inp_show_on_front_page = output_html($inp_show_on_front_page);
			$inp_show_on_front_page_mysql = quote_smart($link, $inp_show_on_front_page);

			$inp_on_given_status_do_close_case = $_POST['inp_on_given_status_do_close_case'];
			$inp_on_given_status_do_close_case = output_html($inp_on_given_status_do_close_case);
			$inp_on_given_status_do_close_case_mysql = quote_smart($link, $inp_on_given_status_do_close_case);

			$inp_on_person_view_show_without_person = $_POST['inp_on_person_view_show_without_person'];
			$inp_on_person_view_show_without_person = output_html($inp_on_person_view_show_without_person);
			$inp_on_person_view_show_without_person_mysql = quote_smart($link, $inp_on_person_view_show_without_person);

			$inp_show_on_stats_page = $_POST['inp_show_on_stats_page'];
			$inp_show_on_stats_page = output_html($inp_show_on_stats_page);
			$inp_show_on_stats_page_mysql = quote_smart($link, $inp_show_on_stats_page);

			$inp_gives_amount_of_points_to_user = $_POST['inp_gives_amount_of_points_to_user'];
			$inp_gives_amount_of_points_to_user = output_html($inp_gives_amount_of_points_to_user);
			$inp_gives_amount_of_points_to_user_mysql = quote_smart($link, $inp_gives_amount_of_points_to_user);

			$result = mysqli_query($link, "UPDATE $t_edb_case_statuses SET 
					status_title=$inp_title_mysql, 
					status_title_clean=$inp_title_clean_mysql,
					status_bg_color=$inp_bg_color_mysql, 
					status_border_color=$inp_border_color_mysql,
					status_text_color=$inp_text_color_mysql,
					status_link_color=$inp_link_color_mysql,
					status_weight=$inp_weight_mysql,
					status_number_of_cases_max=$inp_number_of_cases_max_mysql,
					status_show_on_front_page=$inp_show_on_front_page_mysql,
					status_on_given_status_do_close_case=$inp_on_given_status_do_close_case_mysql,
					status_on_person_view_show_without_person=$inp_on_person_view_show_without_person_mysql, 
					status_show_on_stats_page=$inp_show_on_stats_page_mysql, 
					status_gives_amount_of_points_to_user=$inp_gives_amount_of_points_to_user_mysql 
					 WHERE status_id=$get_current_status_id") or die(mysqli_error($link));


			$url = "index.php?open=edb&page=$page&action=$action&status_id=$get_current_status_id&order_by=$order_by&order_method=$order_method&editor_language=$editor_language&l=$l&ft=success&fm=changes_saved";
			header("Location: $url");
			exit;
		}
		echo"
		<h1>$get_current_status_title</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=statuses&amp;editor_language=$editor_language&amp;l=$l\">Statuses</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;status_id=$get_current_status_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_status_title</a>
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
			<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;status_id=$get_current_status_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

			<p>Title:<br />
			<input type=\"text\" name=\"inp_title\" value=\"$get_current_status_title\" size=\"25\" />
			</p>

			<p>Weight:<br />
			<input type=\"text\" name=\"inp_weight\" value=\"$get_current_status_weight\" size=\"10\" />
			</p>

			<p>Bg color: <span style=\"color: $get_current_status_bg_color;background: $get_current_status_bg_color;\">$get_current_status_bg_color</span><br />
			<input type=\"text\" name=\"inp_bg_color\" value=\"$get_current_status_bg_color\" size=\"10\" />
			</p>

			<p>Border color: <span style=\"color: $get_current_status_border_color;background: $get_current_status_border_color;\">$get_current_status_border_color</span><br />
			<input type=\"text\" name=\"inp_border_color\" value=\"$get_current_status_border_color\" size=\"10\" />
			</p>

			<p>Text color: <span style=\"color: $get_current_status_text_color;background: $get_current_status_text_color;\">$get_current_status_text_color</span><br />
			<input type=\"text\" name=\"inp_text_color\" value=\"$get_current_status_text_color\" size=\"10\" />
			</p>

			<p>Link color: <span style=\"color: $get_current_status_link_color;background: $get_current_status_link_color;\">$get_current_status_link_color</span><br />
			<input type=\"text\" name=\"inp_link_color\" value=\"$get_current_status_link_color\" size=\"10\" />
			</p>

			<p>Number of cases that should have this status at max<br />
			<input type=\"text\" name=\"inp_number_of_cases_max\" value=\"$get_current_status_number_of_cases_max\" size=\"10\" />
			</p>

			<p>Show on front page:<br />
			<select name=\"inp_show_on_front_page\">
				<option value=\"1\""; if($get_current_status_show_on_front_page == "1"){ echo" selected=\"selected\""; } echo">Yes</option>
				<option value=\"0\""; if($get_current_status_show_on_front_page == "0"){ echo" selected=\"selected\""; } echo">No</option>
			</select>
			</p>

			<p>When case is given status, then close the case:<br />
			<select name=\"inp_on_given_status_do_close_case\">
				<option value=\"1\""; if($get_current_status_on_given_status_do_close_case == "1"){ echo" selected=\"selected\""; } echo">Yes</option>
				<option value=\"0\""; if($get_current_status_on_given_status_do_close_case == "0"){ echo" selected=\"selected\""; } echo">No</option>
			</select>
			</p>

			<p>On person view show without person:<br />
			<select name=\"inp_on_person_view_show_without_person\">
				<option value=\"1\""; if($get_current_status_on_person_view_show_without_person == "1"){ echo" selected=\"selected\""; } echo">Yes</option>
				<option value=\"0\""; if($get_current_status_on_person_view_show_without_person == "0"){ echo" selected=\"selected\""; } echo">No</option>
			</select>
			</p>


			<p>Show on stats page:<br />
			<select name=\"inp_show_on_stats_page\">
				<option value=\"1\""; if($get_current_status_show_on_stats_page == "1"){ echo" selected=\"selected\""; } echo">Yes</option>
				<option value=\"0\""; if($get_current_status_show_on_stats_page == "0"){ echo" selected=\"selected\""; } echo">No</option>
			</select>
			</p>

			<p>Gives amount of points to user:<br />
			<input type=\"text\" name=\"inp_gives_amount_of_points_to_user\" value=\"$get_current_status_gives_amount_of_points_to_user\" size=\"10\" />
			</p>



			<p><input type=\"submit\" value=\"Save changes\" class=\"btn_default\" />
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=delete&amp;status_id=$get_current_status_id&amp;l=$l\" class=\"btn_warning\">Delete</a></p>
	
			</form>
		<!-- //Edit form -->

		";
	} // found
} // edit
elseif($action == "delete"){
	// Find
	$status_id_mysql = quote_smart($link, $status_id);
	$query = "SELECT status_id, status_title, status_title_clean, status_bg_color, status_border_color, status_text_color, status_link_color, status_weight, status_number_of_cases_now, status_number_of_cases_max, status_show_on_front_page, status_on_given_status_do_close_case FROM $t_edb_case_statuses WHERE status_id=$status_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_status_id, $get_current_status_title, $get_current_status_title_clean, $get_current_status_bg_color, $get_current_status_border_color, $get_current_status_text_color, $get_current_status_link_color, $get_current_status_weight, $get_current_status_number_of_cases_now, $get_current_status_number_of_cases_max, $get_current_status_show_on_front_page, $get_current_status_on_given_status_do_close_case) = $row;
	
	if($get_current_status_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{
		if($process == "1"){



			$result = mysqli_query($link, "DELETE FROM $t_edb_case_statuses WHERE status_id=$get_current_status_id") or die(mysqli_error($link));


			$url = "index.php?open=edb&page=$page&order_by=$order_by&order_method=$order_method&editor_language=$editor_language&l=$l&ft=success&fm=deleted";
			header("Location: $url");
			exit;
		}
		echo"
		<h1>$get_current_status_title</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=priorities&amp;editor_language=$editor_language&amp;l=$l\">Priorities</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;status_id=$get_current_status_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_status_title</a>
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

		<!-- Delete -->
			<p>
			Are you sure you want to delete?
			</p>

			<p>
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;status_id=$get_current_status_id&amp;l=$l&amp;process=1\" class=\"btn_danger\">Delete</a></p>
	
			</form>
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

		$inp_bg_color = $_POST['inp_bg_color'];
		$inp_bg_color = output_html($inp_bg_color);
		$inp_bg_color_mysql = quote_smart($link, $inp_bg_color);

		$inp_border_color = $_POST['inp_border_color'];
		$inp_border_color = output_html($inp_border_color);
		$inp_border_color_mysql = quote_smart($link, $inp_border_color);

		$inp_text_color = $_POST['inp_text_color'];
		$inp_text_color = output_html($inp_text_color);
		$inp_text_color_mysql = quote_smart($link, $inp_text_color);

		$inp_link_color = $_POST['inp_link_color'];
		$inp_link_color = output_html($inp_link_color);
		$inp_link_color_mysql = quote_smart($link, $inp_link_color);

		$inp_weight = $_POST['inp_weight'];
		$inp_weight = output_html($inp_weight);
		$inp_weight_mysql = quote_smart($link, $inp_weight);

		$inp_number_of_cases_max = $_POST['inp_number_of_cases_max'];
		$inp_number_of_cases_max = output_html($inp_number_of_cases_max);
		$inp_number_of_cases_max_mysql = quote_smart($link, $inp_number_of_cases_max);

		$inp_show_on_front_page = $_POST['inp_show_on_front_page'];
		$inp_show_on_front_page = output_html($inp_show_on_front_page);
		$inp_show_on_front_page_mysql = quote_smart($link, $inp_show_on_front_page);

		$inp_on_given_status_do_close_case = $_POST['inp_on_given_status_do_close_case'];
		$inp_on_given_status_do_close_case = output_html($inp_on_given_status_do_close_case);
		$inp_on_given_status_do_close_case_mysql = quote_smart($link, $inp_on_given_status_do_close_case);

		$inp_on_person_view_show_without_person = $_POST['inp_on_person_view_show_without_person'];
		$inp_on_person_view_show_without_person = output_html($inp_on_person_view_show_without_person);
		$inp_on_person_view_show_without_person_mysql = quote_smart($link, $inp_on_person_view_show_without_person);


		mysqli_query($link, "INSERT INTO $t_edb_case_statuses
		(status_id, status_title, status_title_clean, status_bg_color, status_border_color, status_text_color, status_link_color, status_weight, status_number_of_cases_now, status_number_of_cases_max, status_show_on_front_page, status_on_given_status_do_close_case, status_on_person_view_show_without_person) 
		VALUES 
		(NULL, $inp_title_mysql, $inp_title_clean_mysql, $inp_bg_color_mysql, $inp_border_color_mysql, $inp_text_color_mysql, $inp_link_color_mysql, $inp_weight_mysql, 0, $inp_number_of_cases_max_mysql, $inp_show_on_front_page_mysql, $inp_on_given_status_do_close_case_mysql, $inp_on_person_view_show_without_person_mysql)")
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
		<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Statuses</a>
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

		<p>Weight:<br />
		<input type=\"text\" name=\"inp_weight\" value=\"\" size=\"10\" />
		</p>

		<p>Bg color:<br />
		<input type=\"text\" name=\"inp_bg_color\" value=\"\" size=\"10\" />
		</p>

		<p>Border color:<br />
		<input type=\"text\" name=\"inp_border_color\" value=\"\" size=\"10\" />
		</p>

		<p>Text color:<br />
		<input type=\"text\" name=\"inp_text_color\" value=\"\" size=\"10\" />
		</p>

		<p>Link color:<br />
		<input type=\"text\" name=\"inp_link_color\" value=\"\" size=\"10\" />
		</p>

		<p>Number of cases that should have this status at max<br />
		<input type=\"text\" name=\"inp_number_of_cases_max\" value=\"\" size=\"10\" />
		</p>

		<p>Show on front page:<br />
		<select name=\"inp_show_on_front_page\">
			<option value=\"1\">Yes</option>
			<option value=\"0\">No</option>
		</select>
		</p>

		<p>When case is given status, then close the case:<br />
		<select name=\"inp_on_given_status_do_close_case\">
			<option value=\"1\">Yes</option>
			<option value=\"0\">No</option>
		</select>
		</p>

		<p>On person view show without person:<br />
		<select name=\"inp_on_person_view_show_without_person\">
			<option value=\"1\">Yes</option>
			<option value=\"0\">No</option>
		</select>
		</p>


		<p><input type=\"submit\" value=\"Create\" class=\"btn_default\" />
		</p>
	
		</form>
	<!-- //New form -->

	";
} // new
?>