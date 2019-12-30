<?php 
/**
*
* File: edb/usr_psw_tag_search.php
* Version 1.0
* Date 16:31 13.11.2019
* Copyright (c) 2019 S. A. Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Configuration ---------------------------------------------------------------------------- */
$pageIdSav            = "2";
$pageNoColumnSav      = "2";
$pageAllowCommentsSav = "1";
$pageAuthorUserIdSav  = "1";

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

/*- Language --------------------------------------------------------------------------- */
include("$root/_admin/_translations/site/$l/edb/ts_edb.php");
include("$root/_admin/_translations/site/$l/edb/ts_open_case_overview.php");
include("$root/_admin/_translations/site/$l/edb/ts_open_case_usr_psw.php");


/*- Variables -------------------------------------------------------------------------- */
$tabindex = 0;
if(isset($_GET['tag'])) {
	$tag = $_GET['tag'];
	$tag = strip_tags(stripslashes($tag));
}
else{
	$tag = "";
}
$tag_mysql = quote_smart($link, $tag);


/*- Tables ---------------------------------------------------------------------------- */
$t_edb_case_index_usr_psw		= $mysqlPrefixSav . "edb_case_index_usr_psw";
$t_edb_most_used_passwords_screen_locks = $mysqlPrefixSav . "edb_most_used_passwords_screen_locks";


/*- Content ---------------------------------------------------------------------------------- */
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){

	/*- Headers ---------------------------------------------------------------------------------- */
	$website_title = "$l_edb - #$tag";
	if(file_exists("./favicon.ico")){ $root = "."; }
	elseif(file_exists("../favicon.ico")){ $root = ".."; }
	elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
	elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
	include("$root/_webdesign/header.php");

	// Me
	$my_user_id = $_SESSION['user_id'];
	$my_user_id = output_html($my_user_id);
	$my_user_id_mysql = quote_smart($link, $my_user_id);

	echo"
	<!-- Headline + Select cases board -->
		<h1>#$tag</h1>
	<!-- Headline + Select cases board -->

	<!-- Where am I? -->
		<p style=\"padding-top:0;margin-top:0;\"><b>$l_you_are_here:</b><br />
		<a href=\"index.php?l=$l\">$l_edb</a>
		&gt;
		<a href=\"usr_psw_tags_search.php?tag=$tag&amp;l=$l\">#$tag</a>
		</p>
		<div style=\"height: 10px;\"></div>
	<!-- //Where am I? -->

		
	<!-- List of username / passwords -->
					<table class=\"hor-zebra\">
					 <thead>
					  <tr>
					   <th scope=\"col\">
						<span>$l_related_to</span>
					   </th>
					   <th scope=\"col\">
						<span>$l_service</span>
					   </th>
					   <th scope=\"col\">
						<span>$l_username</span>
					   </th>
					   <th scope=\"col\">
						<span>$l_password</span>
					   </th>
					   <th scope=\"col\">
						<span>$l_tags</span>
					   </th>
					   <th scope=\"col\">
						<span>$l_reset</span>
					   </th>
					  </tr>
					 </thead>
					 <tbody>
					";
					$x = 0;
					$query = "SELECT usr_psw_id, usr_psw_case_id, usr_psw_related_to_text, usr_psw_item_id, usr_psw_record_id, usr_psw_review_matrix_item_id, usr_psw_domain, usr_psw_login_user, usr_psw_login_password, usr_psw_startup_password, usr_psw_screen_lock, usr_psw_pin, usr_psw_unlock_pattern, usr_psw_decrypt_password, usr_psw_bios_password, usr_psw_reset_to_a, usr_psw_reset_to_b, usr_psw_tag_a, usr_psw_tag_b, usr_psw_tag_c, usr_psw_tag_d, usr_psw_updated_datetime, usr_psw_updated_user_id, usr_psw_updated_user_name FROM $t_edb_case_index_usr_psw WHERE ";
					$query = $query . " usr_psw_tag_a=$tag_mysql OR  usr_psw_tag_b=$tag_mysql OR  usr_psw_tag_c=$tag_mysql";
					$query = $query . " ORDER BY usr_psw_related_to_text ASC";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_usr_psw_id, $get_usr_psw_case_id, $get_usr_psw_related_to_text, $get_usr_psw_item_id, $get_usr_psw_record_id, $get_usr_psw_review_matrix_item_id, $get_usr_psw_domain, $get_usr_psw_login_user, $get_usr_psw_login_password, $get_usr_psw_startup_password, $get_usr_psw_screen_lock, $get_usr_psw_pin, $get_usr_psw_unlock_pattern, $get_usr_psw_decrypt_password, $get_usr_psw_bios_password, $get_usr_psw_reset_to_a, $get_usr_psw_reset_to_b, $get_usr_psw_tag_a, $get_usr_psw_tag_b, $get_usr_psw_tag_c, $get_usr_psw_tag_d, $get_usr_psw_updated_datetime, $get_usr_psw_updated_user_id, $get_usr_psw_updated_user_name) = $row;

						if(isset($style) && $style == ""){
							$style = "odd";
						}
						else{
							$style = "";
						}

						echo"
						 <tr>
						  <td class=\"$style\">
							<span><a href=\"open_case_usr_psw.php?case_id=$get_usr_psw_case_id&amp;l=$l\">$get_usr_psw_related_to_text</a></span>
						  </td>
						  <td class=\"$style\">
							<span>$get_usr_psw_domain</span>
						  </td>
						  <td class=\"$style\">
							<span>
							";
							$found_username = 0;
							if($get_usr_psw_login_user != ""){
								echo"$get_usr_psw_login_user";
								$found_username = 1;
							}
							echo" 
							</span>
						  </td>
						  <td class=\"$style\">
							";
							if($get_usr_psw_unlock_pattern != ""){
								echo"<div style=\"float: left;\">
									<span>
									<img src=\"most_used_passwords_unlock_pattern_drawer_to_image.php?pattern=$get_usr_psw_unlock_pattern\" id=\"drawer_to_image\" alt=\"$get_usr_psw_unlock_pattern\" /><br >
									$get_usr_psw_unlock_pattern
									</span>
								</div>";
							}
							echo"


							<span>
							";
							$found_password = 0;
							if($get_usr_psw_login_password != ""){
								echo"$get_usr_psw_login_password";
								$found_password = 1;
							}
							if($get_usr_psw_startup_password != ""){
								if($found_password == "1"){
									echo" &middot; ";
								}
								echo"$get_usr_psw_startup_password";
								$found_password = 1;
							}
							if($get_usr_psw_screen_lock != ""){
								if($found_password == "1"){
									echo" &middot; ";
								}
								echo"$get_usr_psw_screen_lock";
								$found_password = 1;
							}
							if($get_usr_psw_pin != ""){
								if($found_password == "1"){
									echo" &middot; ";
								}
								echo"$get_usr_psw_pin";
								$found_password = 1;
							}
							if($get_usr_psw_decrypt_password != ""){
								if($found_password == "1"){
									echo" &middot; ";
								}
								echo"$get_usr_psw_decrypt_password";
								$found_password = 1;
							}
							if($get_usr_psw_bios_password != ""){
								if($found_password == "1"){
									echo" &middot; ";
								}
								echo"$get_usr_psw_bios_password";
								$found_password = 1;
							}
							echo"
							</span>
						  </td>
						  <td class=\"$style\">
							<span>
							";
							$found_tag = 0;
							if($get_usr_psw_tag_a != ""){
								echo"<a href=\"usr_psw_tags_search.php?tag=$get_usr_psw_tag_a&amp;l=$l\">$get_usr_psw_tag_a</a>";
								$found_tag = 1;
							}
							if($get_usr_psw_tag_b != ""){
								if($found_tag == "1"){
									echo" &middot; ";
								}
								echo"<a href=\"usr_psw_tags_search.php?tag=$get_usr_psw_tag_b&amp;l=$l\">$get_usr_psw_tag_b</a>";
								$found_tag = 1;
							}
							if($get_usr_psw_tag_c != ""){
								if($found_tag == "1"){
									echo" &middot; ";
								}
								echo"<a href=\"usr_psw_tags_search.php?tag=$get_usr_psw_tag_c&amp;l=$l\">$get_usr_psw_tag_c</a>";
								$found_tag = 1;
							}
							if($get_usr_psw_tag_d != ""){
								if($found_tag == "1"){
									echo" &middot; ";
								}
								echo"<a href=\"usr_psw_tags_search.php?tag=$get_usr_psw_tag_d&amp;l=$l\">$get_usr_psw_tag_d</a>";
								$found_tag = 1;
							}
							echo"
							</span>
						  </td>
						  <td class=\"$style\">
							<span>
							";
							$found_reset = 0;
							if($get_usr_psw_reset_to_a != ""){
								echo"$get_usr_psw_reset_to_a";
								$found_reset= 1;
							}
							if($get_usr_psw_reset_to_b != ""){
								if($found_reset == "1"){
									echo" &middot; ";
								}
								echo"$get_usr_psw_reset_to_b";
								$found_reset = 1;
							}
							echo"
							</span>
						  </td>
						</tr>
					";
					$x++;
				} // while usr_psw
				echo"
				 </tbody>
				</table>

	<!-- List of username and passwords -->
	";

} // logged in
else{
	// Log in
	echo"
	<h1><img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" /> $l_please_log_in...</h1>
	<meta http-equiv=\"refresh\" content=\"1;url=$root/users/login.php?l=$l&amp;referer=$root/edb\">
	";
} // not logged in
/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/$webdesignSav/footer.php");
?>