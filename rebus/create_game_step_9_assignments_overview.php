<?php
/**
*
* File: rebus/create_game_step_9_assignments_overview.php
* Version 1.0.0.
* Date 09:50 01.07.2021
* Copyright (c) 2021 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Configuration --------------------------------------------------------------------- */
$pageIdSav            = "2";
$pageNoColumnSav      = "2";
$pageAllowCommentsSav = "0";

/*- Root dir -------------------------------------------------------------------------- */
// This determine where we are
if(file_exists("favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
elseif(file_exists("../../../../favicon.ico")){ $root = "../../../.."; }
else{ $root = "../../.."; }

/*- Website config -------------------------------------------------------------------- */
include("$root/_admin/website_config.php");

/*- Tables ---------------------------------------------------------------------------- */
include("_tables_rebus.php");


/*- Variables ------------------------------------------------------------------------- */
$l_mysql = quote_smart($link, $l);

if(isset($_GET['game_id'])) {
	$game_id = $_GET['game_id'];
	$game_id = output_html($game_id);
	if(!(is_numeric($game_id))){
		echo"Game id not numeric";
		die;
	}
}
else{
	echo"Missing game id";
	die;
}

$tabindex = 0;

// Logged in?
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	
	$my_user_id = $_SESSION['user_id'];
	$my_user_id = output_html($my_user_id);
	$my_user_id_mysql = quote_smart($link, $my_user_id);



	/*- Find game ------------------------------------------------------------------------- */
	$game_id_mysql = quote_smart($link, $game_id);
	$query = "SELECT game_id, game_title, game_language, game_introduction, game_description, game_privacy, game_published, game_playable_after_datetime, game_playable_after_datetime_saying, game_playable_after_time, game_group_id, game_group_name, game_times_played, game_image_path, game_image_file, game_image_thumb_570x321, game_image_thumb_278x156, game_country_id, game_country_name, game_county_id, game_county_name, game_municipality_id, game_municipality_name, game_city_id, game_city_name, game_place_id, game_place_name, game_number_of_assignments, game_created_by_user_id, game_created_by_user_name, game_created_by_user_email, game_created_by_ip, game_created_by_hostname, game_created_by_user_agent, game_created_datetime, game_created_date_saying, game_updated_by_user_id, game_updated_by_user_name, game_updated_by_user_email, game_updated_by_ip, game_updated_by_hostname, game_updated_by_user_agent, game_updated_datetime, game_updated_date_saying FROM $t_rebus_games_index WHERE game_id=$game_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_game_id, $get_current_game_title, $get_current_game_language, $get_current_game_introduction, $get_current_game_description, $get_current_game_privacy, $get_current_game_published, $get_current_game_playable_after_datetime, $get_current_game_playable_after_datetime_saying, $get_current_game_playable_after_time, $get_current_game_group_id, $get_current_game_group_name, $get_current_game_times_played, $get_current_game_image_path, $get_current_game_image_file, $get_current_game_image_thumb_570x321, $get_current_game_image_thumb_278x156, $get_current_game_country_id, $get_current_game_country_name, $get_current_game_county_id, $get_current_game_county_name, $get_current_game_municipality_id, $get_current_game_municipality_name, $get_current_game_city_id, $get_current_game_city_name, $get_current_game_place_id, $get_current_game_place_name, $get_current_game_number_of_assignments, $get_current_game_created_by_user_id, $get_current_game_created_by_user_name, $get_current_game_created_by_user_email, $get_current_game_created_by_ip, $get_current_game_created_by_hostname, $get_current_game_created_by_user_agent, $get_current_game_created_datetime, $get_current_game_created_date_saying, $get_current_game_updated_by_user_id, $get_current_game_updated_by_user_name, $get_current_game_updated_by_user_email, $get_current_game_updated_by_ip, $get_current_game_updated_by_hostname, $get_current_game_updated_by_user_agent, $get_current_game_updated_datetime, $get_current_game_updated_date_saying) = $row;
	if($get_current_game_id == ""){
		$url = "index.php?ft=error&fm=game_not_found&l=$l";
		header("Location: $url");
		exit;
	}

	/*- Check that I am a owner of this game --------------------------------------------- */
	$query = "SELECT owner_id, owner_game_id, owner_user_id, owner_user_name, owner_user_email FROM $t_rebus_games_owners WHERE owner_game_id=$get_current_game_id AND owner_user_id=$my_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_my_owner_id, $get_my_owner_game_id, $get_my_owner_user_id, $get_my_owner_user_name, $get_my_owner_user_email) = $row;
	if($get_my_owner_id == ""){
		$url = "index.php?ft=error&fm=your_not_a_owner_of_that_game&l=$l";
		header("Location: $url");
		exit;
	}


	/*- Headers ---------------------------------------------------------------------------------- */
	$website_title = "$l_assignments_overview - $get_current_game_title - $l_create_game";
	if(file_exists("./favicon.ico")){ $root = "."; }
	elseif(file_exists("../favicon.ico")){ $root = ".."; }
	elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
	elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
	include("$root/_webdesign/header.php");
	
	if($action == ""){
		echo"
		<!-- Headline -->
			<h1>$get_current_game_title</h1>
		<!-- //Headline -->

		<!-- Where am I ? -->
			<p><b>$l_you_are_here:</b><br />
			<a href=\"index.php?l=$l\">$l_rebus</a>
			&gt;
			<a href=\"my_games.php?l=$l\">$l_my_games</a>
			&gt;
			<a href=\"edit_game.php?game_id=$get_current_game_id&amp;l=$l\">$get_current_game_title</a>
			&gt;
			<a href=\"my_games_edit_assignments_overview.php?game_id=$get_current_game_id&amp;l=$l\">$l_assignments_overview</a>
			</p>
		<!-- //Where am I ? -->

		<!-- Feedback -->
			";
			if($ft != "" && $fm != ""){
				$fm = ucfirst($fm);
				$fm = str_replace("_", " ", $fm);
				echo"<div class=\"$ft\"><p>$fm</p></div>";
			}
			echo"
		<!-- //Feedback -->

		<!-- Actions -->
			<p>
			<a href=\"create_game_step_8_add_assignment.php?game_id=$get_current_game_id&amp;l=$l\" class=\"btn_default\">$l_add_assignment</a>
			<a href=\"create_game_step_10_publish.php?game_id=$get_current_game_id&amp;l=$l\" class=\"btn_default\">$l_next &gt;</a>
			</p>
		<!-- //Actions -->

		<!-- Assignments -->
			
			<table class=\"hor-zebra\">
			 <thead>
			  <tr>
			   <th>
				<span>$l_question</span>
			   </th>
			   <th>
				<span>$l_type</span>
			   </th>
			  </tr>
			 </thead>
			 <tbody>";
			$x = 1;
			$count_number_of_assignments = 0;
			$query = "SELECT assignment_id, assignment_game_id, assignment_number, assignment_type, assignment_value, assignment_address, assignment_answer_a, assignment_answer_a_clean, assignment_answer_b, assignment_answer_b_clean, assignment_hint, assignment_points, assignment_time_to_solve_seconds, assignment_time_to_solve_saying, assignment_created_by_user_id, assignment_created_by_ip, assignment_created_datetime, assignment_updated_by_user_id, assignment_updated_by_ip, assignment_updated_datetime FROM $t_rebus_games_assignments WHERE assignment_game_id=$get_current_game_id ORDER BY assignment_number ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_assignment_id, $get_assignment_game_id, $get_assignment_number, $get_assignment_type, $get_assignment_value, $get_assignment_address, $get_assignment_answer_a, $get_assignment_answer_a_clean, $get_assignment_answer_b, $get_assignment_answer_b_clean, $get_assignment_hint, $get_assignment_points, $get_assignment_time_to_solve_seconds, $get_assignment_time_to_solve_saying, $get_assignment_created_by_user_id, $get_assignment_created_by_ip, $get_assignment_created_datetime, $get_assignment_updated_by_user_id, $get_assignment_updated_by_ip, $get_assignment_updated_datetime) = $row;

				echo"
				 <tr>
				  <td>
					<span><a href=\"create_game_step_9_assignments_overview.php?action=edit_assignment&amp;game_id=$get_current_game_id&amp;assignment_id=$get_assignment_id&amp;l=$l\">$get_assignment_value</a></span>
					
				  </td>
				  <td>
					<span>";
					if($get_assignment_type == "answer_a_question"){
						echo"$l_answer_a_question";
					}
					elseif($get_assignment_type == "take_a_picture_with_coordinates"){
						echo"$l_take_a_picture_with_coordinates";
					}
					else{
						echo"?";
					}
					echo"</span>
				  </td>
				 </tr>
				";


				if($x != "$get_assignment_number"){
					mysqli_query($link, "UPDATE $t_rebus_games_assignments SET assignment_number=$x WHERE assignment_id=$get_assignment_id") or die(mysqli_error($link));
				}
				$x++;
				$count_number_of_assignments++;
			}
			if($count_number_of_assignments != "$get_current_game_number_of_assignments"){
				mysqli_query($link, "UPDATE $t_rebus_games_index SET game_number_of_assignments=$count_number_of_assignments WHERE game_id=$get_current_game_id") or die(mysqli_error($link));
			}
			echo"
			 </tbody>
			</table>
		<!-- //Assignments -->
		<!-- Next -->
			<p style=\"float: right;\">
			<a href=\"create_game_step_10_publish.php?game_id=$get_current_game_id&amp;l=$l\" class=\"btn_default\">$l_next &gt;</a>
			</p>
			<div class=\"clear\"></div>
		<!-- //Next -->

		";
	} // action == ""
	elseif($action == "edit_assignment"){
		if(isset($_GET['assignment_id'])) {
			$assignment_id = $_GET['assignment_id'];
			$assignment_id = output_html($assignment_id);
			if(!(is_numeric($assignment_id))){
				echo"assignment id not numeric";
				die;
			}
		}
		else{
			echo"Missing assignment id";
			die;
		}

		// Get assignment
		$assignment_id_mysql = quote_smart($link, $assignment_id);
		$query = "SELECT assignment_id, assignment_game_id, assignment_number, assignment_type, assignment_value, assignment_address, assignment_video_embedded, assignment_answer_a, assignment_answer_a_clean, assignment_answer_b, assignment_answer_b_clean, assignment_hint, assignment_points, assignment_text_when_correct_answer, assignment_time_to_solve_seconds, assignment_time_to_solve_saying, assignment_created_by_user_id, assignment_created_by_ip, assignment_created_datetime, assignment_updated_by_user_id, assignment_updated_by_ip, assignment_updated_datetime FROM $t_rebus_games_assignments WHERE assignment_id=$assignment_id_mysql AND assignment_game_id=$get_current_game_id";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_assignment_id, $get_current_assignment_game_id, $get_current_assignment_number, $get_current_assignment_type, $get_current_assignment_value, $get_current_assignment_address, $get_current_assignment_video_embedded, $get_current_assignment_answer_a, $get_current_assignment_answer_a_clean, $get_current_assignment_answer_b, $get_current_assignment_answer_b_clean, $get_current_assignment_hint, $get_current_assignment_points, $get_current_assignment_text_when_correct_answer, $get_current_assignment_time_to_solve_seconds, $get_current_assignment_time_to_solve_saying, $get_current_assignment_created_by_user_id, $get_current_assignment_created_by_ip, $get_current_assignment_created_datetime, $get_current_assignment_updated_by_user_id, $get_current_assignment_updated_by_ip, $get_current_assignment_updated_datetime) = $row;
		if($get_current_assignment_id == ""){
			echo"Assignment not found";
			exit;
		}

		// Edit assignment type
		$assignment_type = "$get_current_assignment_type";
		if(isset($_GET['assignment_type'])) {
			$assignment_type = $_GET['assignment_type'];
			$assignment_type = output_html($assignment_type);
			if($assignment_type != "$get_current_assignment_type"){
				// Update assignment type in MySQL
				$assignment_type_mysql = quote_smart($link, $assignment_type);
				
				mysqli_query($link, "UPDATE $t_rebus_games_assignments SET
							assignment_type=$assignment_type_mysql
							WHERE assignment_id=$get_current_assignment_id") or die(mysqli_error($link));
			}
		}
		
		if($process == "1"){
			// Dates
			$datetime = date("Y-m-d H:i:s");

			$assignment_type_mysql = quote_smart($link, $assignment_type);

			$inp_assignment_value = $_POST['inp_assignment_value'];
			$inp_assignment_value = output_html($inp_assignment_value);
			$inp_assignment_value_mysql = quote_smart($link, $inp_assignment_value);

			$inp_video_embedded = $_POST['inp_video_embedded'];
			$inp_video_embedded = output_html($inp_video_embedded);
			$inp_video_embedded = str_replace("https://www.youtube.com/watch?v=", "https://www.youtube.com/embed/", $inp_video_embedded);
			$inp_video_embedded_mysql = quote_smart($link, $inp_video_embedded);

			if(isset($_POST['inp_address'])){
				$inp_address = $_POST['inp_address'];
			}
			else{
				$inp_address = "";
			}
			$inp_address = output_html($inp_address);
			$inp_address_mysql = quote_smart($link, $inp_address);

			$inp_answer_a = $_POST['inp_answer_a'];
			$inp_answer_a = output_html($inp_answer_a);
			$inp_answer_a_mysql = quote_smart($link, $inp_answer_a);

			$inp_answer_a_clean = clean($inp_answer_a);
			$inp_answer_a_clean_mysql = quote_smart($link, $inp_answer_a_clean);
	
			if(isset($_POST['inp_answer_b'])){
				$inp_answer_b = $_POST['inp_answer_b'];
			}
			else{
				$inp_answer_b = "";
			}
			$inp_answer_b = output_html($inp_answer_b);
			$inp_answer_b_mysql = quote_smart($link, $inp_answer_b);

			$inp_answer_b_clean = clean($inp_answer_b);
			$inp_answer_b_clean_mysql = quote_smart($link, $inp_answer_b_clean);

			if(isset($_POST['inp_hint'])){
				$inp_hint = $_POST['inp_hint'];
			}
			else{
				$inp_hint = "";
			}
			$inp_hint = output_html($inp_hint);
			$inp_hint_mysql = quote_smart($link, $inp_hint);

			$inp_points = $_POST['inp_points'];
			$inp_points = output_html($inp_points);
			if(!(is_numeric($inp_points))){
				$inp_points = 1;
			}
			$inp_points = round($inp_points, 0);
			$inp_points_mysql = quote_smart($link, $inp_points);

			$inp_text_when_correct_answer = $_POST['inp_text_when_correct_answer'];
			$inp_text_when_correct_answer = output_html($inp_text_when_correct_answer);
			$inp_text_when_correct_answer_mysql = quote_smart($link, $inp_text_when_correct_answer);

			// Time to solve
			$inp_time_to_solve_seconds_mysql = quote_smart($link, 0);
			$inp_time_to_solve_saying_mysql = quote_smart($link, "");

			// Me
			$query = "SELECT user_id, user_email, user_name, user_language, user_rank FROM $t_users WHERE user_id=$my_user_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_my_user_id, $get_my_user_email, $get_my_user_name, $get_my_user_language, $get_my_user_rank) = $row;
			
			// Ip 
			$my_ip = $_SERVER['REMOTE_ADDR'];
			$my_ip = output_html($my_ip);
			$my_ip_mysql = quote_smart($link, $my_ip);

			mysqli_query($link, "UPDATE $t_rebus_games_assignments SET 
						assignment_value=$inp_assignment_value_mysql, 
						assignment_address=$inp_address_mysql, 
						assignment_video_embedded=$inp_video_embedded_mysql, 
						assignment_answer_a=$inp_answer_a_mysql, 
						assignment_answer_a_clean=$inp_answer_a_clean_mysql, 
						assignment_answer_b=$inp_answer_b_mysql, 
						assignment_answer_b_clean=$inp_answer_b_clean_mysql, 
						assignment_hint=$inp_hint_mysql, 
						assignment_points=$inp_points_mysql, 
						assignment_text_when_correct_answer=$inp_text_when_correct_answer_mysql, 
						assignment_time_to_solve_seconds=$inp_time_to_solve_seconds_mysql,  
						assignment_time_to_solve_saying=$inp_time_to_solve_saying_mysql, 
						assignment_updated_by_user_id=$get_my_user_id, 
						assignment_updated_by_ip=$my_ip_mysql, 
						assignment_updated_datetime='$datetime'
						WHERE assignment_id=$get_current_assignment_id") or die(mysqli_error($link));

			// Header
			$url = "create_game_step_9_assignments_overview.php?action=edit_assignment&game_id=$get_current_game_id&assignment_id=$get_current_assignment_id&assignment_type=$assignment_type&amp;l=$l&ft=success&fm=changes_saved";
			header("Location: $url");
			exit;

		} // process == 1

		echo"
		<!-- Headline -->
			<h1>$get_current_game_title</h1>
		<!-- //Headline -->

		<!-- Where am I ? -->
			<p><b>$l_you_are_here:</b><br />
			<a href=\"index.php?l=$l\">$l_rebus</a>
			&gt;
			<a href=\"my_games.php?l=$l\">$l_my_games</a>
			&gt;
			<a href=\"edit_game.php?game_id=$get_current_game_id&amp;l=$l\">$get_current_game_title</a>
			&gt;
			<a href=\"create_game_step_9_assignments_overview.php?game_id=$get_current_game_id&amp;l=$l\">$l_assignments_overview</a>
			&gt;
			<a href=\"create_game_step_9_assignments_overview.php?action=edit_assignment&amp;game_id=$get_current_game_id&amp;assignment_id=$get_current_assignment_id&amp;l=$l\">$get_current_assignment_value</a>
			</p>
		<!-- //Where am I ? -->

		<!-- Feedback -->
			";
			if($ft != "" && $fm != ""){
				$fm = ucfirst($fm);
				$fm = str_replace("_", " ", $fm);
				echo"<div class=\"$ft\"><p>$fm</p></div>";
			}
			echo"
		<!-- //Feedback -->

		<!-- Focus -->
			<script>
			\$(document).ready(function(){
				\$('[name=\"inp_assignment_value\"]').focus();
			});
			</script>
		<!-- //Focus -->

		<!-- Edit assignment form -->
			<form method=\"post\" action=\"create_game_step_9_assignments_overview.php?action=edit_assignment&amp;game_id=$get_current_game_id&amp;assignment_id=$get_current_assignment_id&amp;assignment_type=$assignment_type&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

			<p><b>$l_assignment_type:</b><br />
			<select name=\"assignment_type\" class=\"on_select_go_to_url\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" />
				<option value=\"create_game_step_4_add_assignment.php?action=edit_assignment&amp;game_id=$get_current_game_id&amp;assignment_id=$get_current_assignment_id&amp;l=$l&amp;assignment_type=answer_a_question\""; if($assignment_type == "answer_a_question"){ echo" selected=\"selected\""; } echo">$l_answer_a_question</option>
				<option value=\"create_game_step_4_add_assignment.php?action=edit_assignment&amp;game_id=$get_current_game_id&amp;assignment_id=$get_current_assignment_id&amp;l=$l&amp;assignment_type=take_a_picture_with_coordinates\""; if($assignment_type == "take_a_picture_with_coordinates"){ echo" selected=\"selected\""; } echo">$l_take_a_picture_with_coordinates</option>
			</select>
			</p>
			<!-- On select go to URL -->
				<script>
				\$(function(){
					// bind change event to select
					\$('.on_select_go_to_url').on('change', function () {
						var url = $(this).val(); // get selected value
						if (url) { // require a URL
							window.location = url; // redirect
						}
						return false;
					});
				});
				</script>
			<!-- //On select go to URL -->


			";
			if($assignment_type == "answer_a_question"){
				echo"
				<p><b>$l_question:</b><br />
				<textarea name=\"inp_assignment_value\" value=\"\" rows=\"5\" cols=\"20\" style=\"width: 99%;\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" />";
				$get_current_assignment_value= str_replace("<br />", "\n", $get_current_assignment_value);
				echo"$get_current_assignment_value</textarea>
				</p>

				<p><b>$l_video_link ($l_example_youtube_video_lowercase):</b><br />
				<input type=\"text\" name=\"inp_video_embedded\" value=\"$get_current_assignment_video_embedded\" size=\"25\" style=\"width: 99%;\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" />
				</p>


				<p><b>$l_answer_alt_1:</b><br />
				<input type=\"text\" name=\"inp_answer_a\" value=\"$get_current_assignment_answer_a\" size=\"25\" style=\"width: 99%;\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" />
				</p>

				<p><b>$l_answer_alt_2:</b><br />
				<input type=\"text\" name=\"inp_answer_b\" value=\"$get_current_assignment_answer_b\" size=\"25\" style=\"width: 99%;\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" />
				</p>
				";

			} // assignment_type
			elseif($assignment_type == "take_a_picture_with_coordinates"){
				echo"
				<p><b>$l_take_a_picture_of:</b><br />
				<textarea name=\"inp_assignment_value\" value=\"\" rows=\"5\" cols=\"20\" style=\"width: 99%;\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" />";
				$get_current_assignment_value = str_replace("<br />", "\n", $get_current_assignment_value);
				echo"$get_current_assignment_value</textarea>
				</p>

				<p><b>$l_video_link ($l_example_youtube_video_lowercase):</b><br />
				<input type=\"text\" name=\"inp_video_embedded\" value=\"$get_current_assignment_video_embedded\" size=\"25\" style=\"width: 99%;\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" />
				</p>


				<p><b>$l_address:</b><br />
				<input type=\"text\" name=\"inp_address\" value=\"$get_current_assignment_address\" size=\"25\" style=\"width: 99%;\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" />
				</p>
				<!-- leaflet -->
					";
					// Get my last used coordinate, if it doesnt exist, then get the last used in my country
					$query = "SELECT assignment_id, assignment_answer_a, assignment_answer_b FROM $t_rebus_games_assignments WHERE assignment_type='take_a_picture_with_coordinates' AND assignment_created_by_user_id=$my_user_id_mysql ORDER BY assignment_id DESC LIMIT 0,1";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_last_assignment_id, $get_last_assignment_answer_a, $get_last_assignment_answer_b) = $row;
					if($get_last_assignment_id == ""){
						$get_last_assignment_answer_a = "51.505";
						$get_last_assignment_answer_b = "-0.09";
					}

					echo"
					<script src=\"$root/_admin/_javascripts/leaflet/leaflet.js\" crossorigin=\"\"></script>

					<div id=\"map\" style=\"width: 100%; height: 400px;\"></div>


					<!-- Edit game assignment - Map script -->
					<script>
						var map = L.map('map').setView([$get_last_assignment_answer_a, $get_last_assignment_answer_b], 13);
				
						L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
							maxZoom: 18,
							attribution: 'Map data &copy; <a href=\"https://www.openstreetmap.org/copyright\">OpenStreetMap</a> contributors, ' +
							'Imagery © <a href=\"https://www.mapbox.com/\">Mapbox</a>',
							id: 'mapbox/streets-v11',
							tileSize: 512,
							zoomOffset: -1
						}).addTo(map);



						L.marker([$get_last_assignment_answer_a, $get_last_assignment_answer_b]).addTo(map).bindPopup(\"$get_current_assignment_address\").openPopup();



						var popup = L.popup();
						function onMapClick(e) {
							popup
							.setLatLng(e.latlng)
							.setContent(\"You clicked the map at \" + e.latlng.toString())
							.openOn(map);

							// Fetch coordinates
							var coordinates = e.latlng.toString();
							coordinates = coordinates.replace(\"LatLng(\", \"\"); 
							coordinates = coordinates.replace(\")\", \"\"); 
							coordinates = coordinates.replace(\" \", \"\"); 

							// Split coordinates to lat and lng
							var coordinates_split = coordinates.split(\",\");

							document.getElementById(\"inp_answer_a\").value=coordinates_split[0];
							document.getElementById(\"inp_answer_b\").value=coordinates_split[1];
						}
						map.on('click', onMapClick);


						</script>
					<!-- //Edit game assignment - Map script -->
				<!-- //leaflet -->
				
				<p style=\"padding-bottom:0;margin-bottom:0;\"><b>$l_coordinates:</b></p>
				<table>
				 <tr>
				  <td>
					<span>$l_latitude<br />
					<input type=\"text\" name=\"inp_answer_a\" id=\"inp_answer_a\" value=\"$get_current_assignment_answer_a\" size=\"10\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" /><br />
					</span>
				  </td>
				  <td>
					<span>
					$l_longitude<br />
					<input type=\"text\" name=\"inp_answer_b\" id=\"inp_answer_b\" value=\"$get_current_assignment_answer_b\" size=\"10\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" />
					</span>
				  </td>
				 </tr>
				</table>

				";
			} // take_a_picture_with_coordinates
			echo"

			<p><b>$l_hint:</b><br />
			<input type=\"text\" name=\"inp_hint\" value=\"$get_current_assignment_hint\" size=\"25\" style=\"width: 99%;\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" />
			</p>

			<p><b>$l_points:</b><br />
			<input type=\"text\" name=\"inp_points\" value=\"$get_current_assignment_points\" size=\"2\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" />
			</p>

			<p><b>$l_text_when_correct_answer:</b><br />
			<textarea name=\"inp_text_when_correct_answer\" rows=\"5\" cols=\"20\" style=\"width: 99%;\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\">";
			$get_current_assignment_text_when_correct_answer = str_replace("<br />", "\n", $get_current_assignment_text_when_correct_answer);
			echo"$get_current_assignment_text_when_correct_answer</textarea>
			</p>

			<div style=\"float: left;\">
				<p><input type=\"submit\" value=\"$l_save_changes\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" />
				<a href=\"create_game_step_9_assignments_overview.php?action=delete_assignment&amp;game_id=$get_current_game_id&amp;assignment_id=$get_current_assignment_id&amp;assignment_type=$assignment_type&amp;l=$l\" class=\"btn_danger\">$l_delete</a>
				</p>
			</div>
			<div style=\"float: right;\">
				<p><a href=\"create_game_step_9_assignments_overview.php?game_id=$get_current_game_id&amp;l=$l\" class=\"btn_default\">$l_assignments_overview &gt;</a></p>
			</div>
			<div class=\"clear\"></div>
	
			</form>

		<!-- //Edit assignment form -->
		";
	} // action == "edit assignment
	elseif($action == "delete_assignment"){
		if(isset($_GET['assignment_id'])) {
			$assignment_id = $_GET['assignment_id'];
			$assignment_id = output_html($assignment_id);
			if(!(is_numeric($assignment_id))){
				echo"assignment id not numeric";
				die;
			}
		}
		else{
			echo"Missing assignment id";
			die;
		}

		// Get assignment
		$assignment_id_mysql = quote_smart($link, $assignment_id);
		$query = "SELECT assignment_id, assignment_game_id, assignment_number, assignment_type, assignment_value, assignment_address, assignment_video_embedded, assignment_answer_a, assignment_answer_a_clean, assignment_answer_b, assignment_answer_b_clean, assignment_hint, assignment_points, assignment_text_when_correct_answer, assignment_time_to_solve_seconds, assignment_time_to_solve_saying, assignment_created_by_user_id, assignment_created_by_ip, assignment_created_datetime, assignment_updated_by_user_id, assignment_updated_by_ip, assignment_updated_datetime FROM $t_rebus_games_assignments WHERE assignment_id=$assignment_id_mysql AND assignment_game_id=$get_current_game_id";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_assignment_id, $get_current_assignment_game_id, $get_current_assignment_number, $get_current_assignment_type, $get_current_assignment_value, $get_current_assignment_address, $get_current_assignment_video_embedded, $get_current_assignment_answer_a, $get_current_assignment_answer_a_clean, $get_current_assignment_answer_b, $get_current_assignment_answer_b_clean, $get_current_assignment_hint, $get_current_assignment_points, $get_current_assignment_text_when_correct_answer, $get_current_assignment_time_to_solve_seconds, $get_current_assignment_time_to_solve_saying, $get_current_assignment_created_by_user_id, $get_current_assignment_created_by_ip, $get_current_assignment_created_datetime, $get_current_assignment_updated_by_user_id, $get_current_assignment_updated_by_ip, $get_current_assignment_updated_datetime) = $row;
		if($get_current_assignment_id == ""){
			echo"Assignment not found";
			exit;
		}
		if($process == "1"){
			

			mysqli_query($link, "DELETE FROM $t_rebus_games_assignments WHERE assignment_id=$get_current_assignment_id") or die(mysqli_error($link));

			// Sort all assignments
			$x = 1;
			$query = "SELECT assignment_id, assignment_number FROM $t_rebus_games_assignments WHERE assignment_game_id=$get_current_game_id ORDER BY assignment_number ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_assignment_id, $get_assignment_number) = $row;

				if($x != "$get_assignment_number"){
					mysqli_query($link, "UPDATE $t_rebus_games_assignments SET assignment_number=$x WHERE assignment_id=$get_assignment_id") or die(mysqli_error($link));
				}
				$x++;
			}

			// Header
			$url = "create_game_step_9_assignments_overview.php?game_id=$get_current_game_id&l=$l&ft=success&fm=assignment_deleted";
			header("Location: $url");
			exit;

		} // process == 1

		echo"
		<!-- Headline -->
			<h1>$get_current_game_title</h1>
		<!-- //Headline -->

		<!-- Where am I ? -->
			<p><b>$l_you_are_here:</b><br />
			<a href=\"index.php?l=$l\">$l_rebus</a>
			&gt;
			<a href=\"my_games.php?l=$l\">$l_my_games</a>
			&gt;
			<a href=\"edit_game.php?game_id=$get_current_game_id&amp;l=$l\">$get_current_game_title</a>
			&gt;
			<a href=\"my_games_edit_assignments_overview.php?game_id=$get_current_game_id&amp;l=$l\">$l_assignments_overview</a>
			&gt;
			<a href=\"my_games_edit_assignments_overview.php?action=delete_assignment&amp;game_id=$get_current_game_id&amp;assignment_id=$get_current_assignment_id&amp;l=$l\">$get_current_assignment_value</a>
			</p>
		<!-- //Where am I ? -->

		<!-- Feedback -->
			";
			if($ft != "" && $fm != ""){
				$fm = ucfirst($fm);
				$fm = str_replace("_", " ", $fm);
				echo"<div class=\"$ft\"><p>$fm</p></div>";
			}
			echo"
		<!-- //Feedback -->

		<!-- Delete assignment form -->
			<p>
			$l_are_you_sure_you_want_to_delete_the_assignment
			</p>

			<p>
			<a href=\"create_game_step_9_assignments_overview.php?action=delete_assignment&amp;game_id=$get_current_game_id&amp;assignment_id=$get_current_assignment_id&amp;l=$l&amp;process=1\" class=\"btn_danger\">$l_confirm</a>
			<a href=\"create_game_step_9_assignments_overview.php?action=edit_assignment&amp;game_id=$get_current_game_id&amp;assignment_id=$get_current_assignment_id&amp;l=$l\" class=\"btn_default\">$l_cancel</a>
			</p>
			

		<!-- //Delete assignment form -->
		";
	} // action == "Delete assignment
}
else{
	echo"
	<h1>
	<img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" />
	Loading...</h1>
	<meta http-equiv=\"refresh\" content=\"1;url=$root/users/login.php?l=$l&amp;referer=$root/rebus/team_new.php\">

	<p>Please log in...</p>
	";
}

/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>