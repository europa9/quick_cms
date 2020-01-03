<?php 
/**
*
* File: edb/agent_display_log.php
* Version 1.0
* Date 21:03 04.08.2019
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
include("$root/_admin/_translations/site/$l/edb/ts_agent.php");




/*- Content ---------------------------------------------------------------------------------- */
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	/*- Headers ---------------------------------------------------------------------------------- */
	$website_title = "$l_edb - $l_agent";
	if(file_exists("./favicon.ico")){ $root = "."; }
	elseif(file_exists("../favicon.ico")){ $root = ".."; }
	elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
	elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
	include("$root/_webdesign/header.php");

	if($action == ""){
		echo"
		<h1>$l_agent</h1>

		<!-- Refresh every 350 seconds -->
			<meta http-equiv=\"refresh\" content=\"350;URL='agent_display_log.php?l=$l'\" />
		<!-- Refresh every 350 seconds -->

		<!-- Agent log -->
			<table class=\"hor-zebra\">
			 <thead>
			  <tr>
			   <th scope=\"col\">
				<span>$l_id</span>
			   </th>
			   <th scope=\"col\">
				<span>$l_date</span>
			   </th>
			   <th scope=\"col\">
				<span>$l_text</span>
			   </th>
			  </tr>
			 </thead>
			 <tbody>
			";
			$x = 0;
			$query = "SELECT agent_log_id, agent_log_datetime, agent_log_date_ddmmyyhi, agent_log_date_saying, agent_log_text FROM $t_edb_agent_log ORDER BY agent_log_id DESC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_agent_log_id, $get_agent_log_datetime, $get_agent_log_date_ddmmyyhi, $get_agent_log_date_saying, $get_agent_log_text) = $row;

				if(isset($odd) && $odd == false){
					$odd = true;
				}
				else{
					$odd = false;
				}

				// Log dont break line
				$get_agent_log_date_ddmmyyhi = str_replace(" ", "&nbsp;", $get_agent_log_date_ddmmyyhi);
		
				echo"
				<tr>
				  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
					<span>$get_agent_log_id</span>
				  </td>
				  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
					<span>$get_agent_log_date_ddmmyyhi</span>
				  </td>
				  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
					$get_agent_log_text
				 </td>
				</tr>
				";

				$x++;
				if($x > 200){
					$result_delete = mysqli_query($link, "DELETE FROM $t_edb_agent_log WHERE agent_log_id=$get_agent_log_id");
				}
			}
			echo"
			  </tr>
			 </tbody>
			</table>


		<!-- //Agent log -->

		<!-- Special Actions -->
			<p>
			<a href=\"agent_display_log.php?action=truncate&amp;l=$l&amp;process=1\" class=\"btn_warning\">$l_truncate</a>
			</p>
		<!-- //Special Actions -->
		";
	} // action == ""
	elseif($action == "truncate"){
		$result_delete = mysqli_query($link, "TRUNCATE $t_edb_agent_log") or die(mysqli_error($link));

		$url = "agent_display_log.php?l=$l&ft=success&fm=table_truncated";
		header("Location: $url");
		exit;

	} // action == "truncate"
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