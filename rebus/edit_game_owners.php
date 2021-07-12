<?php
/**
*
* File: rebus/edit_game_owners.php
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
	$query = "SELECT game_id, game_title, game_language, game_introduction, game_description, game_privacy, game_published, game_playable_after_datetime, game_playable_after_time, game_group_id, game_group_name, game_times_played, game_image_path, game_image_file, game_created_by_user_id, game_created_by_user_name, game_created_by_user_email, game_created_by_ip, game_created_by_hostname, game_created_by_user_agent, game_created_datetime, game_created_date_saying, game_updated_by_user_id, game_updated_by_user_name, game_updated_by_user_email, game_updated_by_ip, game_updated_by_hostname, game_updated_by_user_agent, game_updated_datetime, game_updated_date_saying FROM $t_rebus_games_index WHERE game_id=$game_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_game_id, $get_current_game_title, $get_current_game_language, $get_current_game_introduction, $get_current_game_description, $get_current_game_privacy, $get_current_game_published, $get_current_game_playable_after_datetime, $get_current_game_playable_after_time, $get_current_game_group_id, $get_current_game_group_name, $get_current_game_times_played, $get_current_game_image_path, $get_current_game_image_file, $get_current_game_created_by_user_id, $get_current_game_created_by_user_name, $get_current_game_created_by_user_email, $get_current_game_created_by_ip, $get_current_game_created_by_hostname, $get_current_game_created_by_user_agent, $get_current_game_created_datetime, $get_current_game_created_date_saying, $get_current_game_updated_by_user_id, $get_current_game_updated_by_user_name, $get_current_game_updated_by_user_email, $get_current_game_updated_by_ip, $get_current_game_updated_by_hostname, $get_current_game_updated_by_user_agent, $get_current_game_updated_datetime, $get_current_game_updated_date_saying) = $row;
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
	$website_title = "$l_owners - $get_current_game_title - $l_my_games";
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
			<a href=\"edit_game_owners.php?game_id=$get_current_game_id&amp;l=$l\">$l_owners</a>
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

		<!-- Actions -->
			<p>
			<a href=\"edit_game_add_owner.php?game_id=$get_current_game_id&amp;l=$l\" class=\"btn_default\">$l_add_owner</a>
			</p>
		<!-- //Actions -->

		<!-- Assignments -->
			
			<table class=\"hor-zebra\">
			 <thead>
			  <tr>
			   <th>
				<span>$l_username</span>
			   </th>
			   <th>
				<span>$l_actions</span>
			   </th>
			  </tr>
			 </thead>
			 <tbody>";
			$query = "SELECT owner_id, owner_game_id, owner_user_id, owner_user_name, owner_user_email FROM $t_rebus_games_owners WHERE owner_game_id=$get_current_game_id ORDER BY owner_user_name ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_owner_id, $get_owner_game_id, $get_owner_user_id, $get_owner_user_name, $get_owner_user_email) = $row;

				echo"
				 <tr>
				  <td>
					<span>$get_owner_user_name</span>
				  </td>
				  <td>
					<span><a href=\"edit_game_owners.php?action=remove_owner&amp;game_id=$get_current_game_id&amp;owner_id=$get_owner_id&amp;l=$l\">$l_remove</a></span>
				  </td>
				 </tr>

				";
			}	
			echo"
			 </tbody>
			</table>
		<!-- //Assignments -->
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
		$query = "SELECT assignment_id, assignment_game_id, assignment_type, assignment_value, assignment_answer_alt_1, assignment_answer_alt_1_clean, assignment_answer_alt_2, assignment_answer_alt_2_clean, assignment_weight, assignment_created_by_user_id, assignment_created_by_ip, assignment_created_datetime, assignment_updated_by_user_id, assignment_updated_by_ip, assignment_updated_datetime FROM $t_rebus_games_assignments WHERE assignment_id=$assignment_id_mysql AND assignment_game_id=$get_current_game_id";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_assignment_id, $get_current_assignment_game_id, $get_current_assignment_type, $get_current_assignment_value, $get_current_assignment_answer_alt_1, $get_current_assignment_answer_alt_1_clean, $get_current_assignment_answer_alt_2, $get_current_assignment_answer_alt_2_clean, $get_current_assignment_weight, $get_current_assignment_created_by_user_id, $get_current_assignment_created_by_ip, $get_current_assignment_created_datetime, $get_current_assignment_updated_by_user_id, $get_current_assignment_updated_by_ip, $get_current_assignment_updated_datetime) = $row;
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

			$inp_answer_alt_1 = $_POST['inp_answer_alt_1'];
			$inp_answer_alt_1 = output_html($inp_answer_alt_1);
			$inp_answer_alt_1_mysql = quote_smart($link, $inp_answer_alt_1);

			$inp_answer_alt_1_clean = clean($inp_answer_alt_1);
			$inp_answer_alt_1_clean_mysql = quote_smart($link, $inp_answer_alt_1_clean);
	
			if(isset($_POST['inp_answer_alt_2'])){
				$inp_answer_alt_2 = $_POST['inp_answer_alt_2'];
			}
			else{
				$inp_answer_alt_2 = "";
			}
			$inp_answer_alt_2 = output_html($inp_answer_alt_2);
			$inp_answer_alt_2_mysql = quote_smart($link, $inp_answer_alt_2);

			$inp_answer_alt_2_clean = clean($inp_answer_alt_2);
			$inp_answer_alt_2_clean_mysql = quote_smart($link, $inp_answer_alt_2_clean);

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
			$inp_weight = $get_count_assignment_id+1;

			mysqli_query($link, "UPDATE $t_rebus_games_assignments SET 
						assignment_value=$inp_assignment_value_mysql, 
						assignment_answer_alt_1=$inp_answer_alt_1_mysql, 
						assignment_answer_alt_1_clean=$inp_answer_alt_1_clean_mysql, 
						assignment_answer_alt_2=$inp_answer_alt_2_mysql, 
						assignment_answer_alt_2_clean=$inp_answer_alt_2_clean_mysql, 
						assignment_updated_by_user_id=$get_my_user_id, 
						assignment_updated_by_ip=$my_ip_mysql, 
						assignment_updated_datetime='$datetime'
						WHERE assignment_id=$get_current_assignment_id") or die(mysqli_error($link));

			// Header
			$url = "edit_game_assignments.php?action=edit_assignment&game_id=$get_current_game_id&assignment_id=$get_current_assignment_id&assignment_type=$assignment_type&amp;l=$l&ft=success&fm=changes_saved";
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
			<a href=\"edit_game_assignments.php?game_id=$get_current_game_id&amp;l=$l\">$l_assignments</a>
			&gt;
			<a href=\"edit_game_assignments.php?action=edit_assignment&amp;game_id=$get_current_game_id&amp;assignment_id=$get_current_assignment_id&amp;l=$l\">$get_current_assignment_value</a>
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
			<form method=\"post\" action=\"edit_game_assignments.php?action=edit_assignment&amp;game_id=$get_current_game_id&amp;assignment_id=$get_current_assignment_id&amp;assignment_type=$assignment_type&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

			<p><b>$l_assignment_type:</b><br />
			<select name=\"assignment_type\" class=\"on_select_go_to_url\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" />
				<option value=\"edit_game_assignments.php?action=edit_assignment&amp;game_id=$get_current_game_id&amp;assignment_id=$get_current_assignment_id&amp;l=$l&amp;assignment_type=answer_a_question\""; if($assignment_type == "answer_a_question"){ echo" selected=\"selected\""; } echo">$l_answer_a_question</option>
				<option value=\"edit_game_assignments.php?action=edit_assignment&amp;game_id=$get_current_game_id&amp;assignment_id=$get_current_assignment_id&amp;l=$l&amp;assignment_type=take_a_picture_with_coordinates\""; if($assignment_type == "take_a_picture_with_coordinates"){ echo" selected=\"selected\""; } echo">$l_take_a_picture_with_coordinates</option>
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
				<input type=\"text\" name=\"inp_assignment_value\" value=\"$get_current_assignment_value\" size=\"25\" style=\"width: 99%;\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" />
				</p>

				<p><b>$l_answer_alt_1:</b><br />
				<input type=\"text\" name=\"inp_answer_alt_1\" value=\"$get_current_assignment_answer_alt_1\" size=\"25\" style=\"width: 99%;\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" />
				</p>

				<p><b>$l_answer_alt_2:</b><br />
				<input type=\"text\" name=\"inp_answer_alt_2\" value=\"$get_current_assignment_answer_alt_2\" size=\"25\" style=\"width: 99%;\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" />
				</p>
				";

			} // assignment_type
			elseif($assignment_type == "take_a_picture_with_coordinates"){
				echo"
				<p><b>$l_take_a_picture_of:</b><br />
				<input type=\"text\" name=\"inp_assignment_value\" value=\"$get_current_assignment_value\" size=\"25\" style=\"width: 99%;\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" />
				</p>

				<p><b>$l_coordinates:</b><br />
				<input type=\"text\" name=\"inp_answer_alt_1\" value=\"$get_current_assignment_answer_alt_1\" size=\"25\" style=\"width: 99%;\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" />
				</p>

				";
			} // take_a_picture_with_coordinates
			echo"

			<div style=\"float: left;\">
				<p><input type=\"submit\" value=\"$l_save_changes\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" />
				<a href=\"edit_game_assignments.php?action=delete_assignment&amp;game_id=$get_current_game_id&amp;assignment_id=$get_current_assignment_id&amp;assignment_type=$assignment_type&amp;l=$l\" class=\"btn_danger\">$l_delete</a>
				</p>
			</div>
			<div style=\"float: right;\">
				<p><a href=\"edit_game_assignments.php?game_id=$get_current_game_id&amp;l=$l\" class=\"btn_default\">$l_assignments_overview &gt;</a></p>
			</div>
			<div class=\"clear\"></div>
	
			</form>

		<!-- //Edit assignment form -->
		";
	} // action == "edit assignment
	elseif($action == "remove_owner"){
		if(isset($_GET['owner_id'])) {
			$owner_id = $_GET['owner_id'];
			$owner_id = output_html($owner_id);
			if(!(is_numeric($owner_id))){
				echo"owner id not numeric";
				die;
			}
		}
		else{
			echo"Missing owner id";
			die;
		}

		// Get owner
		$owner_id_mysql = quote_smart($link, $owner_id);
		$query = "SELECT owner_id, owner_game_id, owner_user_id, owner_user_name, owner_user_email FROM $t_rebus_games_owners WHERE owner_id=$owner_id_mysql AND owner_game_id=$get_current_game_id";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_owner_id, $get_current_owner_game_id, $get_current_owner_user_id, $get_current_owner_user_name, $get_current_owner_user_email) = $row;
		if($get_current_owner_id == ""){
			echo"Owner not found";
			exit;
		}

		// Count number of owners (has to be over 1)
		$query = "SELECT count(owner_id) FROM $t_rebus_games_owners WHERE owner_game_id=$get_current_game_id";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_count_owner_id) = $row;
		if($get_count_owner_id == "1"){
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
				<a href=\"edit_game_owners.php?game_id=$get_current_game_id&amp;l=$l\">$l_owners</a>
				&gt;
				<a href=\"edit_game_owners.php?action=remove_owner&amp;game_id=$get_current_game_id&amp;owner_id=$get_current_owner_id&amp;l=$l\">$l_remove $get_current_owner_user_name</a>
				</p>
			<!-- //Where am I ? -->

			<p>$l_cannot_remove_owner_because_there_has_to_be_at_least_one_game_owner</p>";
		}
		else{

			if($process == "1"){
			

				mysqli_query($link, "DELETE FROM $t_rebus_games_owners WHERE owner_id=$get_current_owner_id") or die(mysqli_error($link));

				// Header
				$url = "edit_game_owners.php?game_id=$get_current_game_id&l=$l&ft=success&fm=owner_deleted";
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
				<a href=\"edit_game_owners.php?game_id=$get_current_game_id&amp;l=$l\">$l_owners</a>
				&gt;
				<a href=\"edit_game_owners.php?action=remove_owner&amp;game_id=$get_current_game_id&amp;owner_id=$get_current_owner_id&amp;l=$l\">$l_remove $get_current_owner_user_name</a>
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
			$l_are_you_sure_you_want_to_remove_the_owner
			</p>

			<p>
			<a href=\"edit_game_owners.php?action=remove_owner&amp;game_id=$get_current_game_id&amp;owner_id=$get_current_owner_id&amp;l=$l&amp;process=1\" class=\"btn_danger\">$l_confirm</a>
			<a href=\"edit_game_owners.php?game_id=$get_current_game_id&amp;l=$l\" class=\"btn_default\">$l_cancel</a>
			</p>
			

			<!-- //Delete assignment form -->
			";
		} // more than one owner
	} // action == "Delete assignment
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