<?php 
/**
*
* File: edb/agent.php
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
include("$root/_admin/_translations/site/$l/users/ts_users.php");

/*- Tables ---------------------------------------------------------------------------- */

$t_edb_agents_index	= $mysqlPrefixSav . "edb_agents_index";



/*- Content ---------------------------------------------------------------------------------- */
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){

	// Agent runtime sharing
	$query = "SELECT agent_id, agent_script_file FROM $t_edb_agents_index ORDER BY agent_last_runned ASC LIMIT 0,1";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_agent_id, $get_agent_script_file) = $row;

	// Update
	$datetime = date("Y-m-d H:i:s");
	$result = mysqli_query($link, "UPDATE $t_edb_agents_index SET agent_last_runned='$datetime' WHERE agent_id=$get_agent_id");


	// Include
	include("agents/$get_agent_script_file");

} // logged in

?>