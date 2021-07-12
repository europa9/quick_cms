<?php
/**
*
* File: rebus/play_game.php
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


	// Dates
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


	/*- Headers ---------------------------------------------------------------------------------- */
	$website_title = "$get_current_game_title";
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
			<a href=\"play_game.php?game_id=$get_current_game_id&amp;l=$l\">$get_current_game_title</a>
			</p>
		<!-- //Where am I ? -->

		<!-- Feedback -->
		";
		if($ft != "" && $fm != ""){
			$fm = ucfirst($fm);
			$fm = str_replace("_", " ", $fm);
			echo"<div class=\"$ft\"><p>$fm</p>";

			echo"</div>";
		}
		echo"
		<!-- //Feedback -->

		<!-- Start -->
			";
			if($get_current_game_playable_after_time > $time){


				echo"
				<div class=\"countdown\">
					<p>
					<span class=\"get_ready\">$l_get_ready</span><br />
					<span class=\"game_starts_in\">$l_game_starts_in</span>
					</p>
					<!-- Countdown script -->
					<script>
					function makeTimer() {

						var endTime = new Date(\"$get_current_game_playable_after_datetime_saying GMT+00:00\");			
						endTime = (Date.parse(endTime) / 1000);

						var now = new Date();
						now = (Date.parse(now) / 1000);

						var timeLeft = endTime - now;

						var days = Math.floor(timeLeft / 86400); 
						var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
						var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600 )) / 60);
						var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));
  
						if (hours < \"10\") { hours = \"0\" + hours; }
						if (minutes < \"10\") { minutes = \"0\" + minutes; }
						if (seconds < \"10\") { seconds = \"0\" + seconds; }

						\$(\"#days\").html(days + \"<span>Days</span>\");
						\$(\"#hours\").html(hours + \"<span>Hours</span>\");
						\$(\"#minutes\").html(minutes + \"<span>Minutes</span>\");
						\$(\"#seconds\").html(seconds + \"<span>Seconds</span>\");

						// Show next button
						if(days == 0 && hours == 0 && minutes == 0 && seconds == 0){
							var x = document.getElementById(\"start_game\");
							x.style.display = \"block\";
						}	
					}

					setInterval(function() { makeTimer(); }, 1000);
					</script>
					<!-- //Countdown script -->

					<ul class=\"timer\">
						<li id=\"days\"></li>
						<li id=\"hours\"></li>
						<li id=\"minutes\"></li>
						<li id=\"seconds\"></li>
					</ul>

					<div id=\"start_game\">
						<p>
						<a href=\"play_game_2_assignments.php?game_id=$get_current_game_id&amp;l=$l\" class=\"btn_start\">$l_start_game</a>
						</p>
					</div>
				</div>
				
				";
			}
			else{
				echo"
				<div class=\"center\">
					<p>
						<a href=\"play_game_2_assignments.php?game_id=$get_current_game_id&amp;play_as=user&amp;l=$l\" class=\"btn_start\">$l_start_game</a>
						</p>
				</div>	
				";
			}
			
			echo"
		<!-- //Start -->

		<!-- Game overview -->";
			if(file_exists("$root/$get_current_game_image_path/$get_current_game_image_file") && $get_current_game_image_file != ""){
				echo"
				<p>
				<img src=\"$root/$get_current_game_image_path/$get_current_game_image_file\" alt=\"$get_current_game_image_file\" /><br />
				</p>
				";
			}
			if($get_current_game_introduction != ""){
				echo"<p>$get_current_game_introduction</p>\n";
			}
			if($get_current_game_description != ""){
				echo"<p>$get_current_game_description</p>\n";
			}
		echo"
		<!-- //Game overview -->

		";

	} // action == ""
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