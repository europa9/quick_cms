<?php 
/**
*
* File: food/new_workout_plan_weekly.php
* Version 1.0.0
* Date 12:05 10.02.2018
* Copyright (c) 2011-2018 S. A. Ditlefsen
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

/*- Translation ------------------------------------------------------------------------ */
include("$root/_admin/_translations/site/$l/workout_plans/ts_new_workout_plan.php");

/*- Variables ------------------------------------------------------------------------- */
if(isset($_GET['weekly_id'])){
	$weekly_id = $_GET['weekly_id'];
	$weekly_id = output_html($weekly_id);
}
else{
	$weekly_id = "";
}

$tabindex = 0;
$l_mysql = quote_smart($link, $l);




/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_workout_plans - $l_new_workout_plan";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");

/*- Content ---------------------------------------------------------------------------------- */
// Logged in?
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	
	// Get my user
	$my_user_id = $_SESSION['user_id'];
	$my_user_id = output_html($my_user_id);
	$my_user_id_mysql = quote_smart($link, $my_user_id);
	$query = "SELECT user_id, user_email, user_name, user_alias, user_rank FROM $t_users WHERE user_id=$my_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_user_id, $get_user_email, $get_user_name, $get_user_alias, $get_user_rank) = $row;

	// Get workout plan weekly
	$weekly_id_mysql = quote_smart($link, $weekly_id);
	$query = "SELECT workout_weekly_id, workout_weekly_user_id, workout_weekly_period_id, workout_weekly_weight, workout_weekly_language, workout_weekly_title, workout_weekly_title_clean, workout_weekly_introduction, workout_weekly_goal, workout_weekly_image_path, workout_weekly_image_file, workout_weekly_created, workout_weekly_updated, workout_weekly_unique_hits, workout_weekly_unique_hits_ip_block, workout_weekly_comments, workout_weekly_likes, workout_weekly_dislikes, workout_weekly_rating, workout_weekly_ip_block, workout_weekly_user_ip, workout_weekly_notes FROM $t_workout_plans_weekly WHERE workout_weekly_id=$weekly_id_mysql AND workout_weekly_user_id=$my_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_workout_weekly_id, $get_current_workout_weekly_user_id, $get_current_workout_weekly_period_id, $get_current_workout_weekly_weight, $get_current_workout_weekly_language, $get_current_workout_weekly_title, $get_current_workout_weekly_title_clean, $get_current_workout_weekly_introduction, $get_current_workout_weekly_goal, $get_current_workout_weekly_image_path, $get_current_workout_weekly_image_file, $get_current_workout_weekly_created, $get_current_workout_weekly_updated, $get_current_workout_weekly_unique_hits, $get_current_workout_weekly_unique_hits_ip_block, $get_current_workout_weekly_comments, $get_current_workout_weekly_likes, $get_current_workout_weekly_dislikes, $get_current_workout_weekly_rating, $get_current_workout_weekly_ip_block, $get_current_workout_weekly_user_ip, $get_current_workout_weekly_notes) = $row;
	
	

	if($get_current_workout_weekly_id == ""){
		echo"<p>Weekly not found.</p>";
	}
	else{

		if($process == "1"){

			// Period
			$inp_period_id = $_POST['inp_period_id'];
			$inp_period_id = output_html($inp_period_id);		
			$inp_period_id_mysql = quote_smart($link, $inp_period_id);


			// Introduction
			$inp_introduction = $_POST['inp_introduction'];
			$inp_introduction = output_html($inp_introduction);			
			$inp_introduction_mysql = quote_smart($link, $inp_introduction);

			
			// Update
			$result = mysqli_query($link, "UPDATE $t_workout_plans_weekly SET workout_weekly_period_id=$inp_period_id_mysql,
				workout_weekly_introduction=$inp_introduction_mysql
				 WHERE workout_weekly_id=$weekly_id_mysql");



			// Purifier
			require_once "$root/_admin/_functions/htmlpurifier/HTMLPurifier.auto.php";
			$config = HTMLPurifier_Config::createDefault();
			$purifier = new HTMLPurifier($config);

			if($get_user_rank == "admin" OR $get_user_rank == "moderator" OR $get_user_rank == "editor"){
			}
			elseif($get_user_rank == "trusted"){
			}
			else{
				// p, ul, li, b
				$config->set('HTML.Allowed', 'p,b,a[href],i,ul,li');
			}

			// Goal
			$inp_goal = $_POST['inp_goal'];
			$inp_goal = $purifier->purify($inp_goal);


			$sql = "UPDATE $t_workout_plans_weekly SET workout_weekly_goal=? WHERE workout_weekly_id=$weekly_id_mysql";
			$stmt = $link->prepare($sql);
			$stmt->bind_param("s", $inp_goal);
			$stmt->execute();
			if ($stmt->errno) {
				echo "FAILURE!!! " . $stmt->error; die;
			}


			// Header
			$url = "new_workout_plan_weekly_step_3_sessions.php?weekly_id=$weekly_id&action=new_session&l=$l";
			header("Location: $url");
			exit;

		} // process
	
		echo"
		<h1>$l_new_weekly_workout_plan</h1>
	

		<!-- Feedback -->
		";
		if($ft != ""){
			if($fm == "changes_saved"){
				$fm = "$l_changes_saved";
			}
			else{
				$fm = ucfirst($fm);
			}
			echo"<div class=\"$ft\"><span>$fm</span></div>";
		}
		echo"	
		<!-- //Feedback -->

		<!-- TinyMCE -->
			<script type=\"text/javascript\" src=\"$root/_admin/_javascripts/tinymce/tinymce_4.7.1/tinymce.min.js\"></script>
			<script>
			tinymce.init({
				mode : \"specific_textareas\",
        			editor_selector : \"myTextEditor\",
				plugins: \"image\",
				menubar: \"insert\",
				toolbar: \"image\",
				height: 200,
				menubar: false,";
			if($get_user_rank == "admin" OR $get_user_rank == "moderator" OR $get_user_rank == "editor"){
				echo"
				plugins: [
				    'advlist autolink lists link image charmap print preview anchor textcolor',
				    'searchreplace visualblocks code fullscreen',
				    'insertdatetime media table contextmenu paste code help'
				  ],
				  toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
				  content_css: [
				    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
				    '//www.tinymce.com/css/codepen.min.css']
				";
			}
			elseif($get_user_rank == "trusted"){
				echo"
				plugins: [
				    'advlist autolink lists link image charmap print preview anchor textcolor',
				    'searchreplace visualblocks code fullscreen',
				    'insertdatetime media table contextmenu paste code help'
				  ],
				  toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
				  content_css: [
				    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
				    '//www.tinymce.com/css/codepen.min.css']
				";
			}
			else{
				echo"
				plugins: [
				    'advlist autolink lists link image charmap print preview anchor textcolor',
				    'searchreplace visualblocks code fullscreen',
				    'insertdatetime media table contextmenu paste code help'
				  ],
				  toolbar: 'bold | bullist',
				  content_css: [
				    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
				    '//www.tinymce.com/css/codepen.min.css']
				";
			}
			echo"
			});
			</script>
		<!-- //TinyMCE -->

		<!-- Form -->

			<!-- Focus -->
			<script>
				\$(document).ready(function(){
					\$('[name=\"inp_yearly_id\"]').focus();
				});
			</script>
			<!-- //Focus -->


			<form method=\"post\" action=\"new_workout_plan_weekly.php?weekly_id=$weekly_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
	


			<p><b>$l_is_child_of_period_workout_plan:</b><br />
			<select name=\"inp_period_id\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\">
				<option value=\"0\""; if($get_current_workout_weekly_period_id == "0"){ echo" selected=\"selected\""; } echo">$l_none</option>\n";

				$query = "SELECT workout_period_id, workout_period_title FROM $t_workout_plans_period WHERE workout_period_user_id=$my_user_id_mysql AND workout_period_language=$l_mysql";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_workout_period_id, $get_workout_period_title) = $row;
			
					echo"				";
					echo"<option value=\"$get_workout_period_id\""; if($get_current_workout_weekly_period_id == $get_workout_period_id){ echo" selected=\"selected\""; } echo">$get_workout_period_title</option>\n";
				}

			echo"
			</select>
			</p>

			<p><b>$l_introduction:</b><br />
			<textarea name=\"inp_introduction\" rows=\"10\" cols=\"30\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\">";
			$get_current_workout_weekly_introduction = str_replace("<br />", "\n", $get_current_workout_weekly_introduction);
			echo"$get_current_workout_weekly_introduction</textarea>
			</p>

			<p><b>$l_goal:</b><br />
			<textarea name=\"inp_goal\" rows=\"10\" cols=\"30\" class=\"myTextEditor\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\">$get_current_workout_weekly_goal</textarea>
			</p>


			<p>
			<input type=\"submit\" value=\"$l_save\" class=\"btn\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
			</p>

			</form>
		<!-- //Form -->
		";
	} // found
}
else{
	echo"
	<h1>
	<img src=\"$root/_webdesign/images/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" />
	Loading...</h1>
	<meta http-equiv=\"refresh\" content=\"1;url=$root/users/index.php?page=login&amp;l=$l&amp;refer=$root/exercises/new_exercise.php\">
	";
}



/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>