<?php 
/**
*
* File: workout_plans/period_workout_plan_edit.php
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
include("$root/_admin/_translations/site/$l/workout_plans/ts_yearly_workout_plan_edit.php");

/*- Variables ------------------------------------------------------------------------- */
if(isset($_GET['period_id'])){
	$period_id = $_GET['period_id'];
	$period_id = output_html($period_id);
}
else{
	$period_id = "";
}

if(isset($_GET['duration_type'])){
	$duration_type = $_GET['duration_type'];
	$duration_type = strip_tags(stripslashes($duration_type));
}
else{
	$duration_type = "";
}

$tabindex = 0;
$l_mysql = quote_smart($link, $l);




/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_workout_plans - $l_edit_workout_plan";
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

	// Get workout plan period
	$period_id_mysql = quote_smart($link, $period_id);
	$query = "SELECT workout_period_id, workout_period_user_id, workout_period_yearly_id, workout_period_weight, workout_period_language, workout_period_title, workout_period_title_clean, workout_period_introduction, workout_period_goal, workout_period_text, workout_period_from, workout_period_to, workout_period_image_path, workout_period_image_file, workout_period_created, workout_period_updated, workout_period_unique_hits, workout_period_unique_hits_ip_block, workout_period_comments, workout_period_likes, workout_period_dislikes, workout_period_rating, workout_period_ip_block, workout_period_user_ip, workout_period_notes FROM $t_workout_plans_period WHERE workout_period_id=$period_id_mysql AND workout_period_user_id=$my_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_workout_period_id, $get_current_workout_period_user_id, $get_current_workout_period_yearly_id, $get_current_workout_period_weight, $get_current_workout_period_language, $get_current_workout_period_title, $get_current_workout_period_title_clean, $get_current_workout_period_introduction, $get_current_workout_period_goal, $get_current_workout_period_text, $get_current_workout_period_from, $get_current_workout_period_to, $get_current_workout_period_image_path, $get_current_workout_period_image_file, $get_current_workout_period_created, $get_current_workout_period_updated, $get_current_workout_period_unique_hits, $get_current_workout_period_unique_hits_ip_block, $get_current_workout_period_comments, $get_current_workout_period_likes, $get_current_workout_period_dislikes, $get_current_workout_period_rating, $get_current_workout_period_ip_block, $get_current_workout_period_user_ip, $get_current_workout_period_notes) = $row;
	

	if($get_workout_period_id == ""){
		echo"<p>Period not found.</p>";
	}
	else{


		if($process == "1"){

			$inp_title = $_POST['inp_title'];
			$inp_title = output_html($inp_title);
			$inp_title_mysql = quote_smart($link, $inp_title);
			if(empty($inp_title)){
				$url = "new_workout_plan.php?l=$l";
				$url = $url . "&ft=error&fm=missing_title";
				header("Location: $url");
				exit;
			}
		
			$inp_title_clean = clean($inp_title);
			$inp_title_clean_mysql = quote_smart($link, $inp_title_clean);

			// Year
			$inp_yearly_id = $_POST['inp_yearly_id'];
			$inp_yearly_id = output_html($inp_yearly_id);			
			$inp_yearly_id_mysql = quote_smart($link, $inp_yearly_id);


			// Introduction
			$inp_introduction = $_POST['inp_introduction'];
			$inp_introduction = output_html($inp_introduction);			
			$inp_introduction_mysql = quote_smart($link, $inp_introduction);

			
			// Update

			$result = mysqli_query($link, "UPDATE $t_workout_plans_period SET workout_period_title=$inp_title_mysql, 
				 workout_period_title_clean=$inp_title_clean_mysql, 
				 workout_period_yearly_id=$inp_yearly_id_mysql,
				 workout_period_introduction=$inp_introduction_mysql 
				 WHERE workout_period_id=$period_id_mysql");




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


			$sql = "UPDATE $t_workout_plans_period SET workout_period_goal=? WHERE workout_period_id=$period_id_mysql";
			$stmt = $link->prepare($sql);
			$stmt->bind_param("s", $inp_goal);
			$stmt->execute();
			if ($stmt->errno) {
				echo "FAILURE!!! " . $stmt->error; die;
			}


			// Header
			$url = "period_workout_plan_edit.php?period_id=$period_id&duration_type=$duration_type&l=$l&ft=success&fm=changes_saved";
			header("Location: $url");
			exit;

		} // process
	
		echo"
		<h1>$get_current_workout_period_title</h1>
	

		<!-- Where am I ? -->
			<p><b>$l_you_are_here:</b><br />
			<a href=\"my_workout_plans.php?duration_type=$duration_type&amp;l=$l\">$l_my_workout_plans</a>
			&gt;
			<a href=\"period_workout_plan_edit.php?period_id=$period_id&amp;duration_type=$duration_type&amp;l=$l\">$l_edit</a>
			</p>
		<!-- //Where am I ? -->

		<!-- Navigation -->
			<div class=\"tabs\" style=\"margin-top: 6px;\">
				<ul>
					<li><a href=\"period_workout_plan_view.php?period_id=$period_id&amp;l=$l\">$l_view</a></li>
					<li><a href=\"period_workout_plan_edit.php?period_id=$period_id&amp;duration_type=$duration_type&amp;l=$l\">$l_edit</a></li>
					<li><a href=\"period_workout_plan_edit_text.php?period_id=$period_id&amp;duration_type=$duration_type&amp;l=$l\">$l_text</a></li>
					<li><a href=\"period_workout_plan_edit_image.php?period_id=$period_id&amp;duration_type=$duration_type&amp;l=$l\">$l_image</a></li>
				</ul>
			</div>
			<div class=\"clear\" style=\"margin-bottom: 6px;\"></div>
		<!-- //Navigation -->

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
			
			<h2>$l_edit</h2>

			<!-- Focus -->
			<script>
				\$(document).ready(function(){
					\$('[name=\"inp_title\"]').focus();
				});
			</script>
			<!-- //Focus -->


			<form method=\"post\" action=\"period_workout_plan_edit.php?period_id=$period_id&amp;duration_type=$duration_type&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
	
			<p><b>$l_title*:</b><br />
			<input type=\"text\" name=\"inp_title\" size=\"40\" value=\"$get_current_workout_period_title\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
			</p>


			<p><b>$l_is_child_of_yearly_workout_plan:</b><br />
			<select name=\"inp_yearly_id\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\">
				<option value=\"0\""; if($get_current_workout_period_yearly_id == "0"){ echo" selected=\"selected\""; } echo">$l_none</option>\n";

				$query = "SELECT workout_yearly_id, workout_yearly_title FROM $t_workout_plans_yearly WHERE workout_yearly_user_id=$my_user_id_mysql AND workout_yearly_language=$l_mysql";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_workout_yearly_id, $get_workout_yearly_title) = $row;
			
					echo"				";
					echo"<option value=\"$get_workout_yearly_id\""; if($get_current_workout_period_yearly_id == $get_workout_yearly_id){ echo" selected=\"selected\""; } echo">$get_workout_yearly_title</option>\n";
				}

			echo"
			</select>
			</p>


			<p><b>$l_introduction:</b><br />
			<textarea name=\"inp_introduction\" rows=\"10\" cols=\"70\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\">";
			$get_current_workout_period_introduction = str_replace("<br />", "\n", $get_current_workout_period_introduction);
			echo"$get_current_workout_period_introduction</textarea>
			</p>

			<p><b>$l_goal:</b><br />
			<textarea name=\"inp_goal\" rows=\"10\" cols=\"70\" class=\"myTextEditor\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\">$get_current_workout_period_goal</textarea>
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