<?php
/**
*
* File: users/index.php
* Version 17.46 18.02.2017
* Copyright (c) 2009-2017 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/*- Configuration ---------------------------------------------------------------------------- */
$pageIdSav            = "0";
$pageNoColumnSav      = "2";
$pageAllowCommentsSav = "0";

/*- Root dir --------------------------------------------------------------------------------- */
// This determine where we are
if(file_exists("favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
elseif(file_exists("../../../../favicon.ico")){ $root = "../../../.."; }
else{ $root = "../../.."; }

/*- Website config --------------------------------------------------------------------------- */
include("$root/_admin/website_config.php");

/*- Translation ------------------------------------------------------------------------------ */
include("$root/_admin/_translations/site/$l/users/ts_users.php");

/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_users - $l_create_free_account";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");



/*- Content --------------------------------------------------------------------------- */

$inp_ip = $_SERVER['REMOTE_ADDR'];
$inp_ip = output_html($inp_ip);

$ip_date = date("Y-m-d");

$inp_my_ip_block = $inp_ip . "|" . $ip_date . "|" . "1";

// IP Check
if(!(is_dir("$root/_cache"))){
	mkdir("$root/_cache");
}
if(!(file_exists("$root/_cache/create_free_account_ipblock.dat"))){
	$fh = fopen("$root/_cache/create_free_account_ipblock.dat", "w+") or die("can not open file");
	fwrite($fh, $inp_my_ip_block);
	fclose($fh);
}
else{
	$fh = fopen("$root/_cache/create_free_account_ipblock.dat", "r");
	$filesize = filesize("$root/_cache/create_free_account_ipblock.dat");
	if($filesize == 0){
		$data = "";
	}
	else{
		$data = fread($fh, $filesize);
	}
	fclose($fh);

	$array = explode("\n", $data);
	$array_size = sizeof($array);

	if($array_size > 50){
		$array_size = 1;
	}

	$inp_ip_block = "";
	$found_my_ip = 0;

	for($x=0;$x<$array_size;$x++){
		$temp = explode("|", $array[$x]);

		if(isset($temp[1]) && $temp[1] == "$ip_date"){
			if($temp[0] == "$inp_ip"){
				$temp[2] = $temp[2]+1;
				$found_my_ip = 1;
				$my_hits_counter = $temp[2];
			}

			if($inp_ip_block == ""){
				$inp_ip_block = $temp[0] . "|" . $temp[1] . "|" . $temp[2];
			}
			else{
				$inp_ip_block = $inp_ip_block . "\n" . $temp[0] . "|" . $temp[1] . "|" . $temp[2];
			}
		}

	}

	if($found_my_ip == 0){
		$inp_ip_block = $inp_my_ip_block . "\n" . $inp_ip_block;
	}

	$fh = fopen("$root/_cache/create_free_account_ipblock.dat", "w+") or die("can not open file");
	fwrite($fh, $inp_ip_block);
	fclose($fh);


}

if(isset($my_hits_counter) && $my_hits_counter > 20){
	echo"
	<h1>$l_ip_block</h1>

	<p>$l_your_ip_has_been_blocked</p>
	<p>$l_this_is_to_prevent_spam</p>
	";
}
else{

	if(!(isset($_SESSION['user_id']))){


		if($process == "1"){

			// Anti spam
			$question_id = $_GET['question_id'];
			$question_id = strip_tags(stripslashes($question_id));
			$question_id_mysql = quote_smart($link, $question_id);
			
			
			$inp_antispam_answer = $_POST['inp_antispam_answer'];
			$inp_antispam_answer = output_html($inp_antispam_answer);
			$inp_antispam_answer = strtolower($inp_antispam_answer);
			$inp_antispam_answer = trim($inp_antispam_answer);

			// -> check answers
			$antispam_correct = "false"; // make a guess
			$query = "SELECT antispam_answer_id, antispam_answer FROM $t_users_antispam_answers WHERE antispam_answer_question_id=$question_id_mysql";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_antispam_answer_id, $get_antispam_answer) = $row;
				$get_antispam_answer = trim($get_antispam_answer);



				if($inp_antispam_answer == "$get_antispam_answer"){
					// Set antispam OK
					$_SESSION['antispam_ok'] = "1";
					$antispam_correct = "true";

					// Move user
					header("Location: create_free_account_step_2_user.php?l=$l");

				}
			}


			if($antispam_correct  == "false"){
				$ft = "error";
				$fm = "users_you_answered_wrong_on_antispam_question";

				// Move user
				header("Location: create_free_account.php?l=$l&ft=$ft&fm=$fm&your_answer=$inp_antispam_answer&question_id=$question_id");
				
			}
		}
		if($action == ""){

			// Anti spam
			$l_mysql = quote_smart($link, $l);
			$query = "SELECT antispam_question_id, antispam_question_language, antispam_question FROM $t_users_antispam_questions WHERE antispam_question_language=$l_mysql";
			$result = mysqli_query($link, $query);
			$row_cnt = mysqli_num_rows($result);
			$random = rand(1, $row_cnt);

			$x = 1;
			while($row = mysqli_fetch_row($result)) {
				if($x == $random){
					list($get_antispam_question_id, $get_antispam_question_language, $get_antispam_question) = $row;
					break;
				}
				$x++;

			}
			if($get_antispam_question_id == ""){
				echo"Error: Could not get anti spam question";
			}


			echo"
			<h1>$l_menu_create_free_account</h1>


			
			<form method=\"POST\" action=\"create_free_account.php?action=check_antispam&amp;l=$l&amp;question_id=$get_antispam_question_id&amp;process=1\" enctype=\"multipart/form-data\">

			<!-- Feedback -->
			";
			if($ft != "" && $fm != ""){
				if($fm == "users_you_answered_wrong_on_antispam_question"){
					$fm = "$l_users_you_answered_wrong_on_antispam_question";
				}
				else{
					$fm = ucfirst($fm);
				}
				echo"<div class=\"$ft\"><p>$fm</p></div>";
			}
			echo"
			<!-- //Feedback -->


			<!-- Focus -->
			<script>
			\$(document).ready(function(){
				\$('[name=\"inp_antispam_answer\"]').focus();
			});
			</script>
			<!-- //Focus -->


			<p>
			$l_users_about_registration
			</p>

			<h2>$l_anti_spam</h2>

			<p>$get_antispam_question<br />
			<input type=\"text\" name=\"inp_antispam_answer\" size=\"15\" /><br />
			</p>

			<p>
			<input type=\"submit\" value=\"$l_continue\" class=\"btn\" />
			</p>

			</form>

			";

		}
	}
	else{
		echo"
		<table>
		 <tr> 
		  <td style=\"padding-right: 6px;\">
			<p>
			<img src=\"$root/_webdesign/images/loading_22.gif\" alt=\"loading_22.gif\" />
			</p>
		  </td>
		  <td>
			<h1>Loading</h1>
		  </td>
		 </tr>
		</table>
		<p>You are registered!</p>
		<p>
		<a href=\"$root/index.php\" class=\"btn\">Home</a></p>
		<meta http-equiv=\"refresh\" content=\"1;url=$root/index.php\">
		";
	}
}
/*- Footer ---------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");

?>