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

$t_edb_districts_index		= $mysqlPrefixSav . "edb_districts_index";
$t_edb_districts_members	= $mysqlPrefixSav . "edb_districts_members";
$t_edb_stations_index		= $mysqlPrefixSav . "edb_stations_index";
$t_edb_stations_members		= $mysqlPrefixSav . "edb_stations_members";
$t_edb_stations_directories	= $mysqlPrefixSav . "edb_stations_directories";

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
	$inp_datetime = date("Y-m-d H:i:s");
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
		$query = "SELECT district_id, district_number, district_title, district_title_clean, district_icon_path, district_icon_16, district_icon_32, district_icon_260, district_number_of_stations, district_number_of_cases_now FROM $t_edb_districts_index";
		$query = $query  . " WHERE district_title LIKE $q_mysql";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_district_id, $get_district_number, $get_district_title, $get_district_title_clean, $get_district_icon_path, $get_district_icon_16, $get_district_icon_32, $get_district_icon_260, $get_district_number_of_stations, $get_district_number_of_cases_now) = $row;
			
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
				<a id=\"#district$get_district_id\"></a>
				<span>
				<a href=\"index.php?open=edb&amp;page=districts_index&amp;action=open&amp;district_id=$get_district_id&amp;l=$l&amp;editor_language=$editor_language\">$get_district_title</a>
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