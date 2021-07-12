<?php
/**
*
* File: rebus/new_game_step_8_add_assignment.php
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
	$query = "SELECT game_id, game_title, game_language, game_description, game_privacy, game_published, game_group_id, game_group_name, game_times_played, game_image_path, game_image_file, game_created_by_user_id, game_created_by_user_name, game_created_by_user_email, game_created_by_ip, game_created_by_hostname, game_created_by_user_agent, game_created_datetime, game_created_date_saying, game_updated_by_user_id, game_updated_by_user_name, game_updated_by_user_email, game_updated_by_ip, game_updated_by_hostname, game_updated_by_user_agent, game_updated_datetime, game_updated_date_saying FROM $t_rebus_games_index WHERE game_id=$game_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_game_id, $get_current_game_title, $get_current_game_language, $get_current_game_description, $get_current_game_privacy, $get_current_game_published, $get_current_game_group_id, $get_current_game_group_name, $get_current_game_times_played, $get_current_game_image_path, $get_current_game_image_file, $get_current_game_created_by_user_id, $get_current_game_created_by_user_name, $get_current_game_created_by_user_email, $get_current_game_created_by_ip, $get_current_game_created_by_hostname, $get_current_game_created_by_user_agent, $get_current_game_created_datetime, $get_current_game_created_date_saying, $get_current_game_updated_by_user_id, $get_current_game_updated_by_user_name, $get_current_game_updated_by_user_email, $get_current_game_updated_by_ip, $get_current_game_updated_by_hostname, $get_current_game_updated_by_user_agent, $get_current_game_updated_datetime, $get_current_game_updated_date_saying) = $row;
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
	$website_title = "$get_current_game_title - $l_new_game";
	if(file_exists("./favicon.ico")){ $root = "."; }
	elseif(file_exists("../favicon.ico")){ $root = ".."; }
	elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
	elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
	include("$root/_webdesign/header.php");
	
	if($action == ""){
		// Variables
		$assignment_type = "answer_a_question";
		if(isset($_GET['assignment_type'])) {
			$assignment_type = $_GET['assignment_type'];
			$assignment_type = output_html($assignment_type);
		}

		if($process == "1"){

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

			// Get weight
			$query = "SELECT count(assignment_id) FROM $t_rebus_games_assignments WHERE assignment_game_id=$get_current_game_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_count_assignment_id) = $row;
			$inp_number = $get_count_assignment_id+1;

			mysqli_query($link, "INSERT INTO $t_rebus_games_assignments
			(assignment_id, assignment_game_id, assignment_number, assignment_type, assignment_value, 
			assignment_address, assignment_video_embedded, assignment_answer_a, assignment_answer_a_clean, assignment_answer_b, 
			assignment_answer_b_clean, 
			assignment_hint, assignment_points, assignment_text_when_correct_answer, assignment_time_to_solve_seconds, assignment_time_to_solve_saying, assignment_created_by_user_id, 
			assignment_created_by_ip, assignment_created_datetime) 
			VALUES 
			(NULL, $get_current_game_id, $inp_number, $assignment_type_mysql, $inp_assignment_value_mysql, 
			$inp_address_mysql, $inp_video_embedded_mysql, $inp_answer_a_mysql, $inp_answer_a_clean_mysql, $inp_answer_b_mysql, 
			$inp_answer_b_clean_mysql, 
			$inp_hint_mysql, $inp_points_mysql, $inp_text_when_correct_answer_mysql, $inp_time_to_solve_seconds_mysql, $inp_time_to_solve_saying_mysql, $get_my_user_id, 
			$my_ip_mysql, '$datetime')") or die(mysqli_error($link));

			// Update game_number_of_assignments
			mysqli_query($link, "INSERT INTO $t_rebus_games_index
						game_number_of_assignments=$inp_number 
						WHERE game_id=$get_current_game_id") or die(mysqli_error($link));

			

			// Header
			$url = "new_game_step_8_add_assignment.php?game_id=$get_current_game_id&assignment_type=$assignment_type&l=$l&ft=success&fm=assignment_added";
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
			<a href=\"my_games_view_game.php?game_id=$get_current_game_id&amp;l=$l\">$get_current_game_title</a>
			&gt;
			<a href=\"edit_game_assignments.php?game_id=$get_current_game_id&amp;l=$l\">$l_assignments</a>
			&gt;
			<a href=\"edit_game_add_assignment.php?game_id=$get_current_game_id&amp;l=$l\">$l_add_assignment</a>
			</p>
		<!-- //Where am I ? -->

		<!-- Feedback -->
			";
			if($ft != "" && $fm != ""){
				$fm = ucfirst($fm);
				$fm = str_replace("_", " ", $fm);
				echo"<div class=\"$ft\"><p>$fm</p>";

				if($ft == "success" && $fm == "Assignment added"){
					echo"
					<p><a href=\"new_game_step_9_assignments_overview.php?game_id=$get_current_game_id&amp;l=$l\" class=\"btn_default\">$l_next &gt;</a></p>
					";
				}

				echo"</div>";
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

		<!-- Add question form -->
			<form method=\"post\" action=\"new_game_step_8_add_assignment.php?game_id=$get_current_game_id&amp;assignment_type=$assignment_type&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

			<p><b>$l_assignment_type:</b><br />
			<select name=\"assignment_type\" class=\"on_select_go_to_url\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" />
				<option value=\"new_game_step_8_add_assignment.php?game_id=$get_current_game_id&amp;l=$l&amp;assignment_type=answer_a_question\""; if($assignment_type == "answer_a_question"){ echo" selected=\"selected\""; } echo">$l_answer_a_question</option>
				<option value=\"new_game_step_8_add_assignment.php?game_id=$get_current_game_id&amp;l=$l&amp;assignment_type=take_a_picture_with_coordinates\""; if($assignment_type == "take_a_picture_with_coordinates"){ echo" selected=\"selected\""; } echo">$l_take_a_picture_with_coordinates</option>
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
				<p><b>$l_question*:</b><br />
				<textarea name=\"inp_assignment_value\" value=\"\" rows=\"5\" cols=\"20\" style=\"width: 99%;\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" /></textarea>
				</p>

				<p><b>$l_video_link ($l_example_youtube_video_lowercase):</b><br />
				<input type=\"text\" name=\"inp_video_embedded\" value=\"\" size=\"25\" style=\"width: 99%;\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" />
				</p>

				<p><b>$l_answer_alt_1*:</b><br />
				<input type=\"text\" name=\"inp_answer_a\" value=\"\" size=\"25\" style=\"width: 99%;\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" />
				</p>

				<p><b>$l_answer_alt_2:</b><br />
				<input type=\"text\" name=\"inp_answer_b\" value=\"\" size=\"25\" style=\"width: 99%;\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" />
				</p>
				";

			} // assignment_type
			elseif($assignment_type == "take_a_picture_with_coordinates"){
				echo"
				<p><b>$l_take_a_picture_of*:</b><br />
				<textarea name=\"inp_assignment_value\" value=\"\" rows=\"5\" cols=\"20\" style=\"width: 99%;\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" /></textarea>
				</p>


				<p><b>$l_video_link ($l_example_youtube_video_lowercase):</b><br />
				<input type=\"text\" name=\"inp_video_embedded\" value=\"\" size=\"25\" style=\"width: 99%;\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" />
				</p>

				<p><b>$l_address:</b><br />
				<input type=\"text\" name=\"inp_address\" value=\"\" size=\"25\" style=\"width: 99%;\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" />
				</p>
				<!-- leaflet -->
				";
				// Get my last used coordinate, if it doesnt exist, then get the last used in my country
				$query = "SELECT assignment_id, assignment_answer_a, assignment_answer_b FROM $t_rebus_games_assignments WHERE assignment_type='take_a_picture_with_coordinates' AND assignment_created_by_user_id=$my_user_id_mysql ORDER BY assignment_id DESC LIMIT 0,1";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_last_assignment_id, $get_last_assignment_answer_a, $get_last_assignment_answer_b) = $row;
				if($get_last_assignment_id == "" OR $get_last_assignment_answer_a == ""){
					$get_last_assignment_answer_a = "51.505";
					$get_last_assignment_answer_b = "-0.09";
				}

				echo"
				<script src=\"$root/_admin/_javascripts/leaflet/leaflet.js\" crossorigin=\"\"></script>

				<div id=\"map\" style=\"width: 100%; height: 400px;\"></div>

				<!-- Add game assignment - Map script -->
				<script>";
					if($get_last_assignment_id == ""){
						echo"
						var map = L.map('map').fitWorld();

						L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
							maxZoom: 18,
							attribution: 'Map data &copy; <a href=\"https://www.openstreetmap.org/copyright\">OpenStreetMap</a> contributors, ' +
							'Imagery © <a href=\"https://www.mapbox.com/\">Mapbox</a>',
							id: 'mapbox/streets-v11',
							tileSize: 512,
							zoomOffset: -1
							}).addTo(map);

							function onLocationFound(e) {
							var radius = e.accuracy / 2;

							L.marker(e.latlng).addTo(map)
							.bindPopup(\"Your location\").openPopup();

							L.circle(e.latlng, radius).addTo(map);
							}

							function onLocationError(e) {
							alert(e.message);
							}

							map.on('locationfound', onLocationFound);
							map.on('locationerror', onLocationError);

							map.locate({setView: true, maxZoom: 16});

						";
					}
					else{
							echo"
							var map = L.map('map').setView([$get_last_assignment_answer_a, $get_last_assignment_answer_b], 13);
				
							L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
								maxZoom: 18,
								attribution: 'Map data &copy; <a href=\"https://www.openstreetmap.org/copyright\">OpenStreetMap</a> contributors, ' +
								'Imagery © <a href=\"https://www.mapbox.com/\">Mapbox</a>',
								id: 'mapbox/streets-v11',
								tileSize: 512,
								zoomOffset: -1
							}).addTo(map);


						";
					}
					echo"


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
				<!-- //Add game assignment - Map script -->
				<!-- //leaflet -->

				<p style=\"padding-bottom:0;margin-bottom:0;\"><b>$l_coordinates*:</b></p>
				<table>
				 <tr>
				  <td>
					<span>$l_latitude<br />
					<input type=\"text\" name=\"inp_answer_a\" id=\"inp_answer_a\" value=\"\" size=\"10\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" /><br />
					</span>
				  </td>
				  <td>
					<span>
					$l_longitude<br />
					<input type=\"text\" name=\"inp_answer_b\" id=\"inp_answer_b\" value=\"\" size=\"10\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" />
					</span>
				  </td>
				 </tr>
				</table>

				";
			} // take_a_picture_with_coordinates
			echo"

			<p><b>$l_hint:</b><br />
			<input type=\"text\" name=\"inp_hint\" value=\"\" size=\"25\" style=\"width: 99%;\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" />
			</p>

			<p><b>$l_points*:</b><br />
			<input type=\"text\" name=\"inp_points\" value=\"1\" size=\"2\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" />
			</p>

			<p><b>$l_text_when_correct_answer:</b><br />
			<textarea name=\"inp_text_when_correct_answer\" rows=\"5\" cols=\"20\" style=\"width: 99%;\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\"></textarea>
			</p>

			<div style=\"float: left;\">
				<p><input type=\"submit\" value=\"$l_save\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" /></p>
			</div>
			<div style=\"float: right;\">
				<p><a href=\"new_game_step_9_assignments_overview.php?game_id=$get_current_game_id&amp;l=$l\" class=\"btn_default\">$l_next &gt;</a></p>
			</div>
			<div class=\"clear\"></div>
	
			</form>
			
		<!-- //Add question form -->		

		";
	} // action == ""
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