<?php 
/**
*
* File: food/search_jquery.php
* Version 1.0.0
* Date 11:24 04.02.2019
* Copyright (c) 2018-2019 S. A. Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/



/*- Functions ------------------------------------------------------------------------ */
include("../../_functions/output_html.php");
include("../../_functions/clean.php");
include("../../_functions/quote_smart.php");
include("../../_functions/resize_crop_image.php");
include("../../_functions/get_extension.php");





/*- Common variables ----------------------------------------------------------------- */
$server_name = $_SERVER['HTTP_HOST'];
$server_name = clean($server_name);



/*- MySQL ------------------------------------------------------------ */
$check = substr($server_name, 0, 3);
if($check == "www"){
	$server_name = substr($server_name, 3);
}

$setup_finished_file = "setup_finished_" . $server_name . ".php";
if(!(file_exists("../../_data/$setup_finished_file"))){
	die;
}

else{
	include("../../_data/config/meta.php");
	include("../../_data/config/user_system.php");

}

$mysql_config_file = "../../_data/mysql_" . $server_name . ".php";
include("$mysql_config_file");
$link = mysqli_connect($mysqlHostSav, $mysqlUserNameSav, $mysqlPasswordSav, $mysqlDatabaseNameSav);
if (mysqli_connect_errno()){
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}







/*- MySQL Tables -------------------------------------------------------------------- */
$t_edb_case_index		= $mysqlPrefixSav . "edb_case_index";
$t_edb_case_codes		= $mysqlPrefixSav . "edb_case_codes";
$t_edb_case_statuses		= $mysqlPrefixSav . "edb_case_statuses";
$t_edb_case_priorities		= $mysqlPrefixSav . "edb_case_priorities";


$t_edb_physical_locations_index		= $mysqlPrefixSav . "edb_physical_locations_index";
$t_edb_physical_locations_directories	= $mysqlPrefixSav . "edb_physical_locations_directories";

$t_edb_software_index	= $mysqlPrefixSav . "edb_software_index";



/*- Variables ------------------------------------------------------------------------- */
if(isset($_GET['open'])) {
	$open = $_GET['open'];
	$open = strip_tags(stripslashes($open));
}
else{
	$open = "";
}

if(isset($_GET['page'])) {
	$page = $_GET['page'];
	$page = strip_tags(stripslashes($page));
}
else{
	$page = "";
}

if(isset($_GET['editor_language'])) {
	$editor_language = $_GET['editor_language'];
	$editor_language = strip_tags(stripslashes($editor_language));
}
else{
	$editor_language = "";
}

if(isset($_GET['l']) OR isset($_POST['l'])) {
	if(isset($_GET['l'])){
		$l = $_GET['l'];
	}
	else{
		$l = $_POST['l'];
	}
	$l = strip_tags(stripslashes($l));
}
else{
	$l = "";
}
$l_mysql = quote_smart($link, $l);


if(isset($_GET['order_by']) OR isset($_POST['order_by'])) {
	if(isset($_GET['order_by'])){
		$order_by = $_GET['order_by'];
	}
	else{
		$order_by = $_POST['order_by'];
	}
	$order_by = strip_tags(stripslashes($order_by));
}
else{
	$order_by = "";
}

if(isset($_GET['order_method']) OR isset($_POST['order_method'])) {
	if(isset($_GET['order_method'])){
		$order_method = $_GET['order_method'];
	}
	else{
		$order_method = $_POST['order_method'];
	}
	$order_method = strip_tags(stripslashes($order_method));
}
else{
	$order_method = "";
}

/*- Query --------------------------------------------------------------------------- */
if(isset($_GET['q']) OR isset($_POST['q'])){
	if(isset($_GET['q'])) {
		$q = $_GET['q'];
	}
	else{
		$q = $_POST['q'];
	}
	$q = trim($q);
	$q = strtolower($q);
	$q = output_html($q);
	$q_mysql = quote_smart($link, $q);

	if($q != ""){
		

		
		// Ready for MySQL search
		$q = $q . "%";
		$q_mysql = quote_smart($link, $q);

		// Set layout
		$x = 0;

		// Query
		echo"
		<table class=\"hor-zebra\">
		";
		$query = "SELECT code_id, code_number, code_title, code_title_clean, code_gives_priority_id, code_gives_priority_title, code_last_used_times_used FROM $t_edb_case_codes";
		$query = $query  . " WHERE code_number LIKE $q_mysql OR code_title LIKE $q_mysql";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_code_id, $get_code_number, $get_code_title, $get_code_title_clean, $get_code_gives_priority_id, $get_code_gives_priority_title, $get_code_last_used_times_used) = $row;
			
			// Style
			if(isset($style) && $style == ""){
				$style = "odd";
			}
			else{
				$style = "";
			}

			echo"
			 <tr>
			  <td class=\"$style\" style=\"width: 40%;\">
				<a id=\"#code$get_code_id\"></a>
				<span>
				<a href=\"index.php?open=$open&amp;page=$page&amp;action=open_code&amp;code_id=$get_code_id&amp;l=$l&amp;editor_language=$editor_language\">$get_code_number</a>
				</span>
			  </td>
			  <td class=\"$style\">
				<span>
				<a href=\"index.php?open=$open&amp;page=$page&amp;action=open_code&amp;code_id=$get_code_id&amp;l=$l&amp;editor_language=$editor_language\">$get_code_title</a>
				</span>
			  </td>
			 </tr>";

		} // while
		echo"
		</table>
		";
		
	}

}

else{

	echo"No q";

}



?>