<?php
/**
*
* File: users/edit_professional.php
* Version 19:21 06.08.2019
* Copyright (c) 2019 Sindre Andre Ditlefsen
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
$website_title = "$l_users - $l_edit_professional";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");



/*- Content --------------------------------------------------------------------------- */

if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	// Get user
	$user_id = $_SESSION['user_id'];
	$user_id_mysql = quote_smart($link, $user_id);
	$security = $_SESSION['security'];
	$security_mysql = quote_smart($link, $security);

	$query = "SELECT user_id, user_name, user_language, user_rank FROM $t_users WHERE user_id=$user_id_mysql AND user_security=$security_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_my_user_id, $get_my_user_name, $get_my_user_language, $get_my_user_rank) = $row;
	if($get_my_user_id == ""){
		echo"<h1>Error</h1><p>Error with user id.</p>"; 
		$_SESSION = array();
		session_destroy();
		die;
	}

	$query = "SELECT professional_id, professional_user_id, professional_company, professional_company_location, professional_department, professional_work_email, professional_position, professional_position_abbr, professional_district FROM $t_users_professional WHERE professional_user_id=$user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_my_professional_id, $get_my_professional_user_id, $get_my_professional_company, $get_my_professional_company_location, $get_my_professional_department, $get_my_professional_work_email, $get_my_professional_position, $get_my_professional_position_abbr, $get_my_professional_district) = $row;
	if($get_my_professional_id == ""){

		// Create professional profile
		mysqli_query($link, "INSERT INTO $t_users_professional 
		(professional_id, professional_user_id) 
		VALUES 
		(NULL, $get_my_user_id)")
		or die(mysqli_error($link));
	}


	if($action == "save"){

		$inp_company = $_POST['inp_company'];
		$inp_company = output_html($inp_company);
		$inp_company_mysql = quote_smart($link, $inp_company);

		$inp_company_location = $_POST['inp_company_location'];
		$inp_company_location = output_html($inp_company_location);
		$inp_company_location_mysql = quote_smart($link, $inp_company_location);

		$inp_department = $_POST['inp_department'];
		$inp_department = output_html($inp_department);
		$inp_department_mysql = quote_smart($link, $inp_department);

		$inp_work_email = $_POST['inp_work_email'];
		$inp_work_email = output_html($inp_work_email);
		$inp_work_email_mysql = quote_smart($link, $inp_work_email);

		$inp_position = $_POST['inp_position'];
		$inp_position = output_html($inp_position);
		$inp_position_mysql = quote_smart($link, $inp_position);


		$inp_position_abbr = $_POST['inp_position_abbr'];
		$inp_position_abbr = output_html($inp_position_abbr);
		$inp_position_abbr_mysql = quote_smart($link, $inp_position_abbr);


		$inp_district = $_POST['inp_district'];
		$inp_district = output_html($inp_district);
		$inp_district_mysql = quote_smart($link, $inp_district);



		$result = mysqli_query($link, "UPDATE $t_users_professional SET 
					professional_company=$inp_company_mysql, 
					professional_company_location=$inp_company_location_mysql, 
					professional_department=$inp_department_mysql, 
					professional_work_email=$inp_work_email_mysql, 
					professional_position=$inp_position_mysql,
					professional_position_abbr=$inp_position_abbr_mysql,
 					professional_district=$inp_district_mysql 
					WHERE professional_user_id=$user_id_mysql");
			
		$url = "edit_professional.php?l=$l&ft=success&fm=changes_saved"; 
		if($process == "1"){
			header("Location: $url");
		}
		else{
			echo"<meta http-equiv=\"refresh\" content=\"1;url=$url\">";
		}
		exit;
	}
	if($action == ""){
		echo"
		<h1>$l_professional</h1>

		<!-- You are here -->
			<div class=\"you_are_here\">
				<p>
				<b>$l_you_are_here:</b><br />
				<a href=\"my_profile.php?l=$l\">$l_my_profile</a>
				&gt; 
				<a href=\"edit_professional.php?l=$l\">$l_edit_professional</a>
				</p>
			</div>
		<!-- //You are here -->

		<form method=\"POST\" action=\"edit_professional.php?action=save&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\" name=\"nameform\">

		<!-- Feedback -->
			";
			if($ft != "" && $fm != ""){
				if($fm == "changes_saved"){
					$fm = "$l_changes_saved";
				}
				else{
					$fm = "$ft";
				}
				echo"<div class=\"$ft\"><p>$fm</p></div>";
			}
			echo"
		<!-- //Feedback -->


		<!-- Focus -->
		<script>
		\$(document).ready(function(){
			\$('[name=\"inp_company\"]').focus();
		});
		</script>
		<!-- //Focus -->



		<p>
		$l_company:<br />
		<input type=\"text\" name=\"inp_company\" size=\"25\" value=\"$get_my_professional_company\" /><br />
		</p>

		<p>
		$l_company_location:<br />
		<input type=\"text\" name=\"inp_company_location\" size=\"25\" value=\"$get_my_professional_company_location\" /><br />
		</p>

		<p>
		$l_department<br />
		<input type=\"text\" name=\"inp_department\" size=\"25\" value=\"$get_my_professional_department\" /><br />
		</p>

		<p>
		$l_work_email:<br />
		<input type=\"text\" name=\"inp_work_email\" size=\"25\" value=\"$get_my_professional_work_email\" /><br />
		</p>

		<p>
		$l_position:<br />
		<input type=\"text\" name=\"inp_position\" size=\"25\" value=\"$get_my_professional_position\" /><br />
		</p>

		<p>
		$l_position_abbreviation:<br />
		<input type=\"text\" name=\"inp_position_abbr\" size=\"25\" value=\"$get_my_professional_position_abbr\" /><br />
		</p>

		<p>
		$l_district:<br />
		<input type=\"text\" name=\"inp_district\" size=\"25\" value=\"$get_my_professional_district\" /><br />
		</p>

		<p>
		<input type=\"submit\" value=\"$l_save\" class=\"btn\" />
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
		<img src=\"$root/_webdesign/images/loading_22.gif\" alt=\"Loading\" />
		</p>
	  </td>
	  <td>
		<h1>Loading</h1>
	  </td>
	 </tr>
	</table>
		
	<meta http-equiv=\"refresh\" content=\"1;url=index.php\">
	";
}
/*- Footer ---------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");

?>