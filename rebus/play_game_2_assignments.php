<?php
/**
*
* File: rebus/play_game_2_assignments.php
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


/*- Functions ------------------------------------------------------------------------- */
function getGps($exifCoord, $hemi) {

    $degrees = count($exifCoord) > 0 ? gps2Num($exifCoord[0]) : 0;
    $minutes = count($exifCoord) > 1 ? gps2Num($exifCoord[1]) : 0;
    $seconds = count($exifCoord) > 2 ? gps2Num($exifCoord[2]) : 0;

    $flip = ($hemi == 'W' or $hemi == 'S') ? -1 : 1;

    return $flip * ($degrees + $minutes / 60 + $seconds / 3600);

}
function gps2Num($coordPart) {

    $parts = explode('/', $coordPart);

    if (count($parts) <= 0)
        return 0;

    if (count($parts) == 1)
        return $parts[0];

    return floatval($parts[0]) / floatval($parts[1]);
}
function seconds_to_time_array($seconds) {
	$dtF = new \DateTime('@0');
	$dtT = new \DateTime("@$seconds");
	return $dtF->diff($dtT)->format('%a|%h|%i|%s');
}



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
if(isset($_GET['play_as'])) {
	$play_as = $_GET['play_as'];
	$play_as = output_html($play_as);
	if($play_as != "user" && $play_as != "group" && $play_as != "team"){
		echo"play_as out of range";
		die;
	}
}
else{
	$play_as = "user";
}
if(isset($_GET['assignment_number'])) {
	$assignment_number = $_GET['assignment_number'];
	$assignment_number = output_html($assignment_number);
	if(!(is_numeric($assignment_number))){
		echo"assignment_number not numeric";
		die;
	}
}
else{
	$assignment_number = "1";
}
if(isset($_GET['solved_assignment'])) {
	$solved_assignment = $_GET['solved_assignment'];
	$solved_assignment = output_html($solved_assignment);
	if(!(is_numeric($solved_assignment))){
		echo"solved_assignment not numeric";
		die;
	}
}
else{
	$solved_assignment = "";
}

$tabindex = 0;

// Logged in?
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	
	$my_user_id = $_SESSION['user_id'];
	$my_user_id = output_html($my_user_id);
	$my_user_id_mysql = quote_smart($link, $my_user_id);


	// Dates
	$datetime = date("Y-m-d H:i:s");
	$time = time();

	/*- Find game ------------------------------------------------------------------------- */
	$game_id_mysql = quote_smart($link, $game_id);
	$query = "SELECT game_id, game_title, game_language, game_introduction, game_description, game_privacy, game_published, game_playable_after_datetime, game_playable_after_datetime_saying, game_playable_after_time, game_group_id, game_group_name, game_times_played, game_image_path, game_image_file, game_created_by_user_id, game_created_by_user_name, game_created_by_user_email, game_created_by_ip, game_created_by_hostname, game_created_by_user_agent, game_created_datetime, game_created_date_saying, game_updated_by_user_id, game_updated_by_user_name, game_updated_by_user_email, game_updated_by_ip, game_updated_by_hostname, game_updated_by_user_agent, game_updated_datetime, game_updated_date_saying FROM $t_rebus_games_index WHERE game_id=$game_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_game_id, $get_current_game_title, $get_current_game_language, $get_current_game_introduction, $get_current_game_description, $get_current_game_privacy, $get_current_game_published, $get_current_game_playable_after_datetime, $get_current_game_playable_after_datetime_saying, $get_current_game_playable_after_time, $get_current_game_group_id, $get_current_game_group_name, $get_current_game_times_played, $get_current_game_image_path, $get_current_game_image_file, $get_current_game_created_by_user_id, $get_current_game_created_by_user_name, $get_current_game_created_by_user_email, $get_current_game_created_by_ip, $get_current_game_created_by_hostname, $get_current_game_created_by_user_agent, $get_current_game_created_datetime, $get_current_game_created_date_saying, $get_current_game_updated_by_user_id, $get_current_game_updated_by_user_name, $get_current_game_updated_by_user_email, $get_current_game_updated_by_ip, $get_current_game_updated_by_hostname, $get_current_game_updated_by_user_agent, $get_current_game_updated_datetime, $get_current_game_updated_date_saying) = $row;
	if($get_current_game_id == ""){
		$url = "index.php?ft=error&fm=game_not_found&l=$l";
		header("Location: $url");
		exit;
	}


	// Is public?
	if($get_current_game_privacy == "private"){
		echo"Private!!";
	}


	/*- Find my game session ---------------------------------------------------------------- */
	$play_as_mysql = quote_smart($link, $play_as);
	$group_id_mysql = quote_smart($link, 0);
	$team_id_mysql = quote_smart($link, 0);
	$query = "SELECT session_id, session_game_id, session_play_as_user_group_team, session_user_id, session_group_id, session_team_id, session_start_datetime, session_start_time, session_is_on_assignment_number, session_is_finished, session_finished_datetime, session_finished_time, session_seconds_used, session_time_used_saying FROM $t_rebus_games_sessions_index WHERE session_game_id=$get_current_game_id AND session_play_as_user_group_team=$play_as_mysql AND session_user_id=$my_user_id_mysql AND session_group_id=$group_id_mysql AND session_team_id=$team_id_mysql AND session_is_finished=0";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_session_id, $get_current_session_game_id, $get_current_session_play_as_user_group_team, $get_current_session_user_id, $get_current_session_group_id, $get_current_session_team_id, $get_current_session_start_datetime, $get_current_session_start_time, $get_current_session_is_on_assignment_number, $get_current_session_is_finished, $get_current_session_finished_datetime, $get_current_session_finished_time, $get_current_session_seconds_used, $get_current_session_time_used_saying) = $row;



	if($get_current_session_id == ""){
		/*echo"
		<div class=\"info\"><p>Creating new session!!</p></div>
		";*/
		mysqli_query($link, "INSERT INTO $t_rebus_games_sessions_index
		(session_id, session_game_id, session_play_as_user_group_team, session_user_id, session_group_id, 
		session_team_id, session_start_datetime, session_start_time, session_is_on_assignment_number, session_is_finished) 
		VALUES 
		(NULL, $get_current_game_id, $play_as_mysql, $my_user_id_mysql, $group_id_mysql,
		$team_id_mysql, '$datetime', '$time', 1, 0)")
		or die(mysqli_error($link));

		// Get ID 
		$query = "SELECT session_id, session_game_id, session_play_as_user_group_team, session_user_id, session_group_id, session_team_id, session_start_datetime, session_start_time, session_is_on_assignment_number, session_is_finished, session_finished_datetime, session_finished_time, session_seconds_used, session_time_used_saying FROM $t_rebus_games_sessions_index WHERE session_game_id=$get_current_game_id AND session_play_as_user_group_team=$play_as_mysql AND session_user_id=$my_user_id_mysql AND session_group_id=$group_id_mysql AND session_team_id=$team_id_mysql AND session_is_finished=0";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_session_id, $get_current_session_game_id, $get_current_session_play_as_user_group_team, $get_current_session_user_id, $get_current_session_group_id, $get_current_session_team_id, $get_current_session_start_datetime, $get_current_session_start_time, $get_current_session_is_on_assignment_number, $get_current_session_is_finished, $get_current_session_finished_datetime, $get_current_session_finished_time, $get_current_session_seconds_used, $get_current_session_time_used_saying) = $row;
	
	}
		
	// Assignment number
	$assignment_number_mysql = quote_smart($link, $assignment_number);
	if($get_current_session_is_on_assignment_number != "$assignment_number"){
		// Update what assignment I am on (in case I close the browser)
		mysqli_query($link, "UPDATE $t_rebus_games_sessions_index SET 
					session_is_on_assignment_number=$assignment_number_mysql 
					WHERE session_id=$get_current_session_id") or die(mysqli_error($link));
	}

	/* Find next assignment */
	$query = "SELECT assignment_id, assignment_game_id, assignment_number, assignment_type, assignment_value, assignment_address, assignment_video_embedded, assignment_answer_a, assignment_answer_a_clean, assignment_answer_b, assignment_answer_b_clean, assignment_hint, assignment_points, assignment_text_when_correct_answer, assignment_time_to_solve_seconds, assignment_time_to_solve_saying, assignment_created_by_user_id, assignment_created_by_ip, assignment_created_datetime, assignment_updated_by_user_id, assignment_updated_by_ip, assignment_updated_datetime FROM $t_rebus_games_assignments WHERE assignment_game_id=$get_current_game_id AND assignment_number=$assignment_number_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_assignment_id, $get_current_assignment_game_id, $get_current_assignment_number, $get_current_assignment_type, $get_current_assignment_value, $get_current_assignment_address, $get_current_assignment_video_embedded, $get_current_assignment_answer_a, $get_current_assignment_answer_a_clean, $get_current_assignment_answer_b, $get_current_assignment_answer_b_clean, $get_current_assignment_hint, $get_current_assignment_points, $get_current_assignment_text_when_correct_answer, $get_current_assignment_time_to_solve_seconds, $get_current_assignment_time_to_solve_saying, $get_current_assignment_created_by_user_id, $get_current_assignment_created_by_ip, $get_current_assignment_created_datetime, $get_current_assignment_updated_by_user_id, $get_current_assignment_updated_by_ip, $get_current_assignment_updated_datetime) = $row;

	if($get_current_assignment_id == ""){
		// Finished

		// Make sure that I have done all assignments!!
		$query = "SELECT assignment_id, assignment_game_id, assignment_number, assignment_type, assignment_value, assignment_address, assignment_answer_a, assignment_answer_a_clean, assignment_answer_b, assignment_answer_b_clean, assignment_hint, assignment_points, assignment_time_to_solve_seconds, assignment_time_to_solve_saying, assignment_created_by_user_id, assignment_created_by_ip, assignment_created_datetime, assignment_updated_by_user_id, assignment_updated_by_ip, assignment_updated_datetime FROM $t_rebus_games_assignments WHERE assignment_game_id=$get_current_game_id ORDER BY assignment_number ASC";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_assignment_id, $get_assignment_game_id, $get_assignment_number, $get_assignment_type, $get_assignment_value, $get_assignment_address, $get_assignment_answer_a, $get_assignment_answer_a_clean, $get_assignment_answer_b, $get_assignment_answer_b_clean, $get_assignment_hint, $get_assignment_points, $get_assignment_time_to_solve_seconds, $get_assignment_time_to_solve_saying, $get_assignment_created_by_user_id, $get_assignment_created_by_ip, $get_assignment_created_datetime, $get_assignment_updated_by_user_id, $get_assignment_updated_by_ip, $get_assignment_updated_datetime) = $row;

			// Check my answer
			$query_answer = "SELECT answer_id, answer_session_id, answer_assignment_id, answer_assignment_number, answer_by_user_group_team, answer_by_user_id, answer_by_group_id, answer_by_team_id, answer_datetime, answer_path, answer_file, answer_text, answer_i_have_flagged_it, answer_is_checked, answer_is_correct, answer_score FROM $t_rebus_games_sessions_answers WHERE answer_session_id=$get_current_session_id AND answer_assignment_id=$get_assignment_id";
			$result_answer = mysqli_query($link, $query_answer);
			$row_answer = mysqli_fetch_row($result_answer);
			list($get_answer_id, $get_answer_session_id, $get_answer_assignment_id, $get_answer_assignment_number, $get_answer_by_user_group_team, $get_answer_by_user_id, $get_answer_by_group_id, $get_answer_by_team_id, $get_answer_datetime, $get_answer_path, $get_answer_file, $get_answer_text, $get_answer_i_have_flagged_it, $get_answer_is_checked, $get_answer_is_correct, $get_answer_score) = $row;
			if($get_answer_id == ""){
				// I have not answered this question
				$url = "play_game_2_assignments.php?game_id=$get_current_game_id&play_as=$play_as&assignment_number=$next_assignment_number&l=$l&ft=success&fm=can_you_solve_assignment_number_$get_answer_assignment_number";
				header("Location: $url");
				exit;
			}
			else{
				if($get_answer_is_correct != "1"){
					// I have not answered this question
					$url = "play_game_2_assignments.php?game_id=$get_current_game_id&play_as=$play_as&assignment_number=$next_assignment_number&l=$l&ft=success&fm=please_try_to_solve_assignment_number_$get_answer_assignment_number";
					header("Location: $url");
					exit;
				}
			}
		} // look for assignments I have not done
		

		// Calculate time used, set as finished
		$seconds_used = $time-$get_current_session_start_time;
		$time_used = seconds_to_time_array($seconds_used);
		$time_used_array = explode("|", $time_used);
		$time_used_days = $time_used_array[0];
		$time_used_hours = $time_used_array[1];
		$time_used_minutes = $time_used_array[2];
		$time_used_seconds = $time_used_array[3];

		$inp_time_used_saying = "";
		if($time_used_days != "0"){
			$inp_time_used_saying = $inp_time_used_saying . "$time_used_days $l_days_lowercase";
		}
		if($time_used_hours != "0"){
			if($inp_time_used_saying  == ""){
				$inp_time_used_saying = "$time_used_hours $l_hours_lowercase";
			}
			else{
				$inp_time_used_saying = $inp_time_used_saying . ", $time_used_hours $l_hours_lowercase";
			}
		}
		if($time_used_minutes != "0"){
			if($inp_time_used_saying  == ""){
				$inp_time_used_saying = "$time_used_minutes $l_minutes_lowercase";
			}
			else{
				$inp_time_used_saying = $inp_time_used_saying . ", $time_used_minutes $l_minutes_lowercase";
			}
		}
		if($time_used_seconds != "0"){
			if($inp_time_used_saying  == ""){
				$inp_time_used_saying = "$time_used_seconds $l_seconds_lowercase";
			}
			else{
				$inp_time_used_saying = $inp_time_used_saying . " $l_and_lowercase $time_used_seconds $l_seconds_lowercase";
			}
		}
		$inp_time_used_saying = output_html($inp_time_used_saying);
		$inp_time_used_saying_mysql = quote_smart($link, $inp_time_used_saying);
		
		mysqli_query($link, "UPDATE $t_rebus_games_sessions_index  SET 
					session_is_finished=1, 
					session_finished_datetime='$datetime', 
					session_finished_time='$time', 
					session_seconds_used='$seconds_used', 
					session_time_used_saying=$inp_time_used_saying_mysql 
					WHERE session_id=$get_current_session_id") or die(mysqli_error($link));



		// Header
		$url = "play_game_3_finished.php?game_id=$get_current_game_id&play_as=$play_as&session_id=$get_current_session_id&l=$l";
		header("Location: $url");
		exit;
	}
	
	
	/*- Headers ---------------------------------------------------------------------------------- */
	$website_title = "$get_current_game_title";
	if(file_exists("./favicon.ico")){ $root = "."; }
	elseif(file_exists("../favicon.ico")){ $root = ".."; }
	elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
	elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
	include("$root/_webdesign/header.php");
	
	if($action == ""){
		echo"
		<div class=\"in_game\">
			<!-- Headline -->
				<h1>$get_current_assignment_value</h1>
			<!-- //Headline -->


			<!-- Feedback -->
			";
			if($ft != "" && $fm != ""){
				$fm = ucfirst($fm);
				$fm = str_replace("_", " ", $fm);
				echo"<div class=\"$ft\"><p>";


				if($solved_assignment != ""){
					// Make sure I have solved assignment before giving text from it
					$solved_assignment_mysql = quote_smart($link, $solved_assignment);
					$query = "SELECT answer_id FROM $t_rebus_games_sessions_answers WHERE answer_session_id=$get_current_session_id AND answer_assignment_number=$solved_assignment_mysql AND answer_is_correct=1";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_solved_answer_id) = $row;
					if($get_solved_answer_id != ""){
						// Give solved text from assignment
						$query = "SELECT assignment_id, assignment_text_when_correct_answer FROM $t_rebus_games_assignments WHERE assignment_game_id=$get_current_game_id AND assignment_number=$solved_assignment_mysql";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_assignment_id, $get_assignment_text_when_correct_answer) = $row;
						echo"$get_assignment_text_when_correct_answer";
					}
				}
				else{
					echo"$fm";
				}

				echo"</p>";

				echo"</div>";
			}
			echo"
			<!-- //Feedback -->

			<!-- Answer assignment form -->
				";
				if($get_current_assignment_type == "answer_a_question"){
					
					echo"

					<!-- Focus -->
						<script>
						\$(document).ready(function(){
							\$('[name=\"inp_answer\"]').focus();
						});
						</script>
					<!-- //Focus -->
					<form method=\"post\" action=\"play_game_2_assignments.php?action=answer_a_question&amp;game_id=$get_current_game_id&amp;play_as=$play_as&amp;assignment_number=$assignment_number&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
				
					<p><b>$l_your_answer:</b><br />
					<input type=\"text\" name=\"inp_answer\" value=\"\" size=\"25\" style=\"width: 99%;\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" />
					</p>
					<p><input type=\"submit\" value=\"$l_submit_answer\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" /></p>
					</form>
					";

				}
				elseif($get_current_assignment_type == "take_a_picture_with_coordinates"){

					echo"
					<form method=\"post\" action=\"play_game_2_assignments.php?action=answer_take_a_picture_with_coordinates&amp;game_id=$get_current_game_id&amp;play_as=$play_as&amp;assignment_number=$assignment_number&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
				


					<p><b>$l_take_a_picture_of_your_answer:</b><br />
					<input type=\"file\" id=\"inp_answer\" name=\"inp_answer\" accept=\"image/*;capture=camera\"/>
					</p>

					<!-- Capture image script -->
						<script>
						var myInput = document.getElementById('inp_answer');

						function sendPic() {
							var file = myInput.files[0];

							// Send file here either by adding it to a `FormData` object 
							// and sending that via XHR, or by simply passing the file into 
							// the `send` method of an XHR instance.
						}

						myInput.addEventListener('change', sendPic, false);
						</script>
					<!-- //Capture image script -->



					<p><input type=\"submit\" value=\"$l_submit_answer\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" /></p>
					</form>
					";

					// Wrong image feedback
					if($fm == "sorry_the_coordinates_are_not_correct" OR $fm == "Sorry the coordinates are not correct"){
						if(isset($_GET['latitude']) && isset($_GET['longitude'])) {
							$latitude = $_GET['latitude'];
							$latitude = output_html($latitude);
							if(!(is_numeric($latitude))){
								echo"latitude not numeric";
								die;
							}

							$longitude = $_GET['longitude'];
							$longitude = output_html($longitude);
							if(!(is_numeric($longitude))){
								echo"longitude not numeric";
								die;
							}

							echo"
							<!-- Map -->
	
								<script src=\"$root/_admin/_javascripts/leaflet/leaflet.js\" crossorigin=\"\"></script>

								<div id=\"map\" style=\"width: 100%; height: 400px;\"></div>
								<script>
								var map = L.map('map').setView([$latitude, $longitude], 13);
				
								L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
									maxZoom: 18,
									attribution: 'Map data &copy; <a href=\"https://www.openstreetmap.org/copyright\">OpenStreetMap</a> contributors, ' +
									'Imagery © <a href=\"https://www.mapbox.com/\">Mapbox</a>',
									id: 'mapbox/streets-v11',
									tileSize: 512,
									zoomOffset: -1
								}).addTo(map);



								L.marker([$latitude, $longitude]).addTo(map).bindPopup(\"$latitude, $longitude\").openPopup();



								var popup = L.popup();
								function onMapClick(e) {
									popup
									.setLatLng(e.latlng)
									.setContent(\"You clicked the map at \" + e.latlng.toString())
									.openOn(map);

								}
								map.on('click', onMapClick);


								</script>
							<!-- //Map -->
							";
						}
					}
				}
				echo"
			<!-- //Answer assignment form -->

		</div> <!-- //in_game -->
		";

	} // action == ""
	elseif($action == "answer_a_question"){
		$inp_answer = $_POST['inp_answer'];
		$inp_answer = output_html($inp_answer);
		$inp_answer_mysql = quote_smart($link, $inp_answer);
		if($inp_answer == ""){
			$url = "play_game_2_assignments.php?game_id=$get_current_game_id&play_as=$play_as&l=$l&ft=info&fm=no_answer_given";
			header("Location: $url");
			exit;
		}

		$inp_answer_clean = clean($inp_answer);
		$inp_answer_clean_mysql = quote_smart($link, $inp_answer_clean);


		// Check if I have answered something before
		$query = "SELECT answer_id, answer_session_id, answer_assignment_id, answer_assignment_number, answer_by_user_group_team, answer_by_user_id, answer_by_group_id, answer_by_team_id, answer_datetime, answer_path, answer_file, answer_text, answer_i_have_flagged_it, answer_is_checked, answer_is_correct, answer_score FROM $t_rebus_games_sessions_answers WHERE answer_session_id=$get_current_session_id AND answer_assignment_id=$get_current_assignment_id";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_answer_id, $get_current_answer_session_id, $get_current_answer_assignment_id, $get_current_answer_assignment_number, $get_current_answer_by_user_group_team, $get_current_answer_by_user_id, $get_current_answer_by_group_id, $get_current_answer_by_team_id, $get_current_answer_datetime, $get_current_answer_path, $get_current_answer_file, $get_current_answer_text, $get_current_answer_i_have_flagged_it, $get_current_answer_is_checked, $get_current_answer_is_correct, $get_current_answer_score) = $row;
			


		// Check if correct
		if($inp_answer_clean == "$get_current_assignment_answer_a_clean" OR $inp_answer_clean == "$get_current_assignment_answer_b_clean"){
			// Correct!
			if($get_current_answer_id == ""){
				mysqli_query($link, "INSERT INTO $t_rebus_games_sessions_answers 
				(answer_id, answer_session_id, answer_assignment_id, answer_assignment_number, answer_by_user_group_team, 
				answer_by_user_id, answer_by_group_id, answer_by_team_id, answer_datetime, answer_text, 
				answer_i_have_flagged_it, answer_is_checked, answer_is_correct, answer_score) 
				VALUES 
				(NULL, $get_current_session_id, $get_current_assignment_id, $get_current_assignment_number, $play_as_mysql,
				$my_user_id_mysql, $group_id_mysql, $team_id_mysql, '$datetime', $inp_answer_mysql, 
				0, 1, 1, $get_current_assignment_points)")
				or die(mysqli_error($link));
			}
			else{

				mysqli_query($link, "UPDATE $t_rebus_games_sessions_answers SET 
						answer_datetime='$datetime', 
						answer_text=$inp_answer_mysql, 
						answer_i_have_flagged_it=0, 
						answer_is_checked=1, 
						answer_is_correct=1, 
						answer_score=$get_current_assignment_points
						WHERE answer_id=$get_current_answer_id") or die(mysqli_error($link));
			}
			
			// Next assignment
			$next_assignment_number = $get_current_assignment_number+1;
			mysqli_query($link, "UPDATE $t_rebus_games_sessions_index SET 
						session_is_on_assignment_number=$next_assignment_number
						WHERE session_id=$get_current_session_id") or die(mysqli_error($link));

			// Header
			$url = "play_game_2_assignments.php?game_id=$get_current_game_id&play_as=$play_as&assignment_number=$next_assignment_number&l=$l&ft=success&fm=correct_answer&solved_assignment=$get_current_assignment_number";
			header("Location: $url");
			exit;

		}
		else{
			// Incorrect!
			$url = "play_game_2_assignments.php?game_id=$get_current_game_id&play_as=$play_as&l=$l&ft=error&fm=wrong_answer_given";
			header("Location: $url");
			exit;
		}
	} // action == "answer_a_question"
	elseif($action == "answer_take_a_picture_with_coordinates"){

		// Check if I have answered something before
		$query = "SELECT answer_id, answer_session_id, answer_assignment_id, answer_assignment_number, answer_by_user_group_team, answer_by_user_id, answer_by_group_id, answer_by_team_id, answer_datetime, answer_path, answer_file, answer_text, answer_i_have_flagged_it, answer_is_checked, answer_is_correct, answer_score FROM $t_rebus_games_sessions_answers WHERE answer_session_id=$get_current_session_id AND answer_assignment_id=$get_current_assignment_id";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_answer_id, $get_current_answer_session_id, $get_current_answer_assignment_id, $get_current_answer_assignment_number, $get_current_answer_by_user_group_team, $get_current_answer_by_user_id, $get_current_answer_by_group_id, $get_current_answer_by_team_id, $get_current_answer_datetime, $get_current_answer_path, $get_current_answer_file, $get_current_answer_text, $get_current_answer_i_have_flagged_it, $get_current_answer_is_checked, $get_current_answer_is_correct, $get_current_answer_score) = $row;
		

		// Delete old image
		if($get_current_answer_id != ""){
			if(file_exists("../$get_current_answer_path/$get_current_answer_file") && $get_current_answer_file != ""){
				unlink("../$get_current_answer_path/$get_current_answer_file");
			}
		}

		// Me
		$query = "SELECT user_id, user_email, user_name, user_language, user_rank FROM $t_users WHERE user_id=$my_user_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_my_user_id, $get_my_user_email, $get_my_user_name, $get_my_user_language, $get_my_user_rank) = $row;
			
		$inp_my_user_name_mysql = quote_smart($link, $get_my_user_name);
		$inp_my_user_email_mysql = quote_smart($link, $get_my_user_email);

		// Ip 
		$my_ip = $_SERVER['REMOTE_ADDR'];
		$my_ip = output_html($my_ip);
		$my_ip_mysql = quote_smart($link, $my_ip);

		// Directory for storing
		if(!(is_dir("../_uploads"))){
			mkdir("../_uploads");
		}
		if(!(is_dir("../_uploads/rebus"))){
			mkdir("../_uploads/rebus");
		}
		if(!(is_dir("../_uploads/rebus/game_sessions"))){
			mkdir("../_uploads/rebus/game_sessions");
		}
		if(!(is_dir("../_uploads/rebus/game_sessions/$get_current_session_id"))){
			mkdir("../_uploads/rebus/game_sessions/$get_current_session_id");
		}
	
		/*- Image upload ------------------------------------------------------------------------------------------ */
		$name = stripslashes($_FILES['inp_answer']['name']);
		$extension = get_extension($name);
		$extension = strtolower($extension);

		$ft_image = "";
		$fm_image = "";
		if($name){
			if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
				$ft_image = "warning";
				$fm_image = "unknown_image_file_extension";

				$url = "play_game_2_assignments.php?game_id=$get_current_game_id&play_as=$play_as&l=$l&ft=$ft_image&fm=$fm_image";
				header("Location: $url");
				exit;
			}
			else{
				$new_path = "../_uploads/rebus/game_sessions/$get_current_session_id/";
				$new_name = date("ymdhis");
				$uploaded_file = $new_path . $new_name . "." . $extension;

				// Upload file
				if (move_uploaded_file($_FILES['inp_answer']['tmp_name'], $uploaded_file)) {
					// Get image size
					$file_size = filesize($uploaded_file);
						
					// Check with and height
					list($width,$height) = getimagesize($uploaded_file);
	
					if($width == "" OR $height == ""){
						$ft_image = "warning";
						$fm_image = "getimagesize_failed";
						unlink($uploaded_file);

						$url = "play_game_2_assignments.php?game_id=$get_current_game_id&play_as=$play_as&assignment_number=$assignment_number&l=$l&ft=$ft_image&fm=$fm_image";
						header("Location: $url");
						exit;
					}
					else{
						// Read exif
						$exif = @exif_read_data($uploaded_file); 
						if($exif == ""){
							unlink($uploaded_file);
							$url = "play_game_2_assignments.php?game_id=$get_current_game_id&play_as=$play_as&assignment_number=$assignment_number&l=$l&ft=warning&fm=cannot_read_exif_gps_coordinates_from_the_picture";
							header("Location: $url");
							exit;
						}

						$gps_longitude = getGps($exif["GPSLongitude"], $exif['GPSLongitudeRef']);
						$gps_longitude_exact = substr($gps_longitude, 0, 8);
						$gps_longitude_approximate = substr($gps_longitude, 0, 6);

						$gps_latitude = getGps($exif["GPSLatitude"], $exif['GPSLatitudeRef']);
						$gps_latitude_exact = substr($gps_latitude, 0, 8);
						$gps_latitude_approximate = substr($gps_latitude, 0, 6);

						$get_current_answer_longitude_approximate = substr($get_current_assignment_answer_a, 0, 6);
						$get_current_answer_latitude_approximate = substr($get_current_assignment_answer_b, 0, 6);
						if(($get_current_answer_longitude_approximate  == "$gps_longitude_approximate" && $get_current_answer_latitude_approximate == "$gps_latitude_approximate") OR 
							($get_current_answer_longitude_approximate  == "$gps_latitude_approximate" && $get_current_answer_latitude_approximate == "$gps_longitude_approximate")){
						
							// Resize to 1280x720
							$uploaded_file_new = $uploaded_file;
							if($width > "1281" OR $height > "720"){
								resize_crop_image(1280, 720, $uploaded_file, $uploaded_file_new, $quality = 80);
							}

							// MySQL
							$inp_path = "_uploads/rebus/game_sessions/$get_current_session_id";
							$inp_path = output_html($inp_path);
							$inp_path_mysql = quote_smart($link, $inp_path);

							$inp_file_mysql = quote_smart($link, $new_name . "." . $extension);

							$inp_text = stripslashes($_FILES['inp_answer']['name']);
							$inp_text = output_html($inp_text);
							$inp_text_mysql = quote_smart($link, $inp_text);

							if($get_current_answer_id == ""){
								mysqli_query($link, "INSERT INTO $t_rebus_games_sessions_answers 
								(answer_id, answer_session_id, answer_assignment_id, answer_assignment_number, answer_by_user_group_team, 
								answer_by_user_id, answer_by_group_id, answer_by_team_id, answer_by_ip, answer_datetime, 
								answer_path, answer_file, answer_text, answer_i_have_flagged_it, answer_is_checked, 
								answer_is_correct, answer_score) 
								VALUES 
								(NULL, $get_current_session_id, $get_current_assignment_id, $get_current_assignment_number, $play_as_mysql,
								$my_user_id_mysql, $group_id_mysql, $team_id_mysql, $my_ip_mysql, '$datetime', 
								$inp_path_mysql, $inp_file_mysql, $inp_text_mysql, 0, 1, 
								1, $get_current_assignment_points)")
								or die(mysqli_error($link));
							}
							else{
								mysqli_query($link, "UPDATE $t_rebus_games_sessions_answers SET 
									answer_by_user_id=$my_user_id_mysql, 
									answer_by_ip=$my_ip_mysql,  
									answer_datetime='$datetime', 
									answer_path=$inp_path_mysql, 
									answer_file=$inp_file_mysql, 
									answer_text=$inp_text_mysql, 
									answer_i_have_flagged_it=0, 
									answer_is_checked=1, 
									answer_is_correct=1, 
									answer_score=$get_current_assignment_points
									WHERE answer_id=$get_current_answer_id") or die(mysqli_error($link));
							}

							// Next assignment
							$next_assignment_number = $get_current_assignment_number+1;
							mysqli_query($link, "UPDATE $t_rebus_games_sessions_index SET 
										session_is_on_assignment_number=$next_assignment_number
										WHERE session_id=$get_current_session_id") or die(mysqli_error($link));

							// Header
							$url = "play_game_2_assignments.php?game_id=$get_current_game_id&play_as=$play_as&assignment_number=$next_assignment_number&l=$l&ft=success&fm=correct_answer&solved_assignment=$get_current_assignment_number";
							header("Location: $url");
							exit;


						
						} // answer accepted
						else{
							echo"Wrong answer.
							<table><tr><td>$gps_latitude_approximate </td><td>!=</td><td>$get_current_answer_latitude_approximate </td><tr>
							<tr><td>$gps_longitude_approximate </td><td>!=</td><td>$get_current_answer_longitude_approximate </td><tr></table>";

							$url = "play_game_2_assignments.php?game_id=$get_current_game_id&play_as=$play_as&assignment_number=$assignment_number&l=$l&ft=error&fm=sorry_the_coordinates_are_not_correct&latitude=$gps_latitude&longitude=$gps_longitude";
							header("Location: $url");
							exit;
						}
					}
				} // move_uploaded_file
				else{
					$ft_image = "error";
					switch ($_FILES['inp_image']['error']) {
						case UPLOAD_ERR_OK:
							$ft_image = "info";
           						$fm_image = "There is no error, the file uploaded with success.";
							break;
						case UPLOAD_ERR_NO_FILE:
           						$fm_image = "no_file_uploaded";
							break;
						case UPLOAD_ERR_INI_SIZE:
           						$fm_image = "to_big_size_in_configuration";
							break;
						case UPLOAD_ERR_FORM_SIZE:
           						$fm_image = "to_big_size_in_form";
							break;
						default:
           						$fm_image = "unknown_error";
							break;
					}
						
					$url = "play_game_2_assignments.php?game_id=$get_current_game_id&play_as=$play_as&assignment_number=$assignment_number&l=$l&ft=$ft_image&fm=$fm_image";
					header("Location: $url");
					exit;
				}
			}
		} // name
		else{
			$url = "play_game_2_assignments.php?game_id=$get_current_game_id&play_as=$play_as&assignment_number=$assignment_number&l=$l&ft=error&fm=no_file_selected";
			header("Location: $url");
			exit;

		}
		echo"Hmm..";

	} // action == "answer_take_a_picture_with_coordinates"
}
else{
	echo"
	<h1>
	<img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" />
	Loading...</h1>
	<meta http-equiv=\"refresh\" content=\"1;url=$root/users/login.php?l=$l&amp;referer=$root/rebus/my_games.php\">

	<p>Please log in...</p>
	";
}

/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>