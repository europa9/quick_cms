<?php
/**
*
* File: food/food_user_adapted_view.php
* Version 1.0
* Date 21:48 09.03.2021
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
include("_tables_food.php");



/*- Variables ------------------------------------------------------------------------- */
$l_mysql = quote_smart($link, $l);


if(isset($_GET['set'])) {
	$set = $_GET['set'];
	$set = strip_tags(stripslashes($set));
	if($set != "system" && $set != "hundred_metric" && $set != "pcs_metric" && $set != "eight_us" && $set != "pcs_us"){
		echo"Unknown set";
		die;
	}
}
else{
	echo"Missing set";
	die;
}
if(isset($_GET['value'])) {
	$value = $_GET['value'];
	$value = strip_tags(stripslashes($value));
	if($value != "1" && $value != "0" && $value != "metric" && $value != "us"){
		echo"Unknown value";
		die;
	}
}
else{
	echo"Missing value";
	die;
}
if(isset($_GET['referer'])) {
	$referer = $_GET['referer'];
	$referer = strip_tags(stripslashes($referer));
	if($referer != "index"){
		echo"Unknown referer";
		die;
	}
}
else{
	echo"Missing referer";
	die;
}


/*- Headers ---------------------------------------------------------------------------------- */
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }

// Variables
$year = date("Y");

if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	$my_user_id = $_SESSION['user_id'];
	$my_user_id = output_html($my_user_id);
	$my_user_id_mysql = quote_smart($link, $my_user_id);
	
	$query_t = "SELECT view_id, view_user_id, view_ip, view_year, view_system, view_hundred_metric, view_pcs_metric, view_eight_us, view_pcs_us FROM $t_food_user_adapted_view WHERE view_user_id=$my_user_id_mysql";
	$result_t = mysqli_query($link, $query_t);
	$row_t = mysqli_fetch_row($result_t);
	list($get_current_view_id, $get_current_view_user_id, $get_current_view_ip, $get_current_view_year, $get_current_view_system, $get_current_view_hundred_metric, $get_current_view_pcs_metric, $get_current_view_eight_us, $get_current_view_pcs_us) = $row_t;
	
	if($get_current_view_id == ""){
		// Create default
		mysqli_query($link, "INSERT INTO $t_food_user_adapted_view 
				(view_id, view_user_id, view_ip, view_year, view_system, 
				view_hundred_metric, view_pcs_metric, view_eight_us, view_pcs_us) 
				VALUES 
				(NULL, $my_user_id_mysql, 0, $year, 'metric', 
				1, 1, 0, 0)")
				or die(mysqli_error($link));


		$query_t = "SELECT view_id, view_user_id, view_ip, view_year, view_system, view_hundred_metric, view_pcs_metric, view_eight_us, view_pcs_us FROM $t_food_user_adapted_view WHERE view_user_id=$my_user_id_mysql";
		$result_t = mysqli_query($link, $query_t);
		$row_t = mysqli_fetch_row($result_t);
		list($get_current_view_id, $get_current_view_user_id, $get_current_view_ip, $get_current_view_year, $get_current_view_system, $get_current_view_hundred_metric, $get_current_view_pcs_metric, $get_current_view_eight_us, $get_current_view_pcs_us) = $row_t;
	}
}
else{
	// IP
	$my_user_ip = $_SERVER['REMOTE_ADDR'];
	$my_user_ip = output_html($my_user_ip);
	$my_user_ip_mysql = quote_smart($link, $my_user_ip);
	
	
	$query_t = "SELECT view_id, view_user_id, view_ip, view_year, view_system, view_hundred_metric, view_pcs_metric, view_eight_us, view_pcs_us FROM $t_food_user_adapted_view WHERE view_ip=$my_user_ip_mysql";
	$result_t = mysqli_query($link, $query_t);
	$row_t = mysqli_fetch_row($result_t);
	list($get_current_view_id, $get_current_view_user_id, $get_current_view_ip, $get_current_view_year, $get_current_view_system, $get_current_view_hundred_metric, $get_current_view_pcs_metric, $get_current_view_eight_us, $get_current_view_pcs_us) = $row_t;


	if($get_current_view_id == ""){
		// Create default
		mysqli_query($link, "INSERT INTO $t_food_user_adapted_view 
				(view_id, view_user_id, view_ip, view_year, view_system, 
				view_hundred_metric, view_pcs_metric, view_eight_us, view_pcs_us) 
				VALUES 
				(NULL, 0, $my_user_ip_mysql, $year, 'metric', 
				1, 1, 0, 0)")
				or die(mysqli_error($link));

	
		$query_t = "SELECT view_id, view_user_id, view_ip, view_year, view_system, view_hundred_metric, view_pcs_metric, view_eight_us, view_pcs_us FROM $t_food_user_adapted_view WHERE view_ip=$my_user_ip_mysql";
		$result_t = mysqli_query($link, $query_t);
		$row_t = mysqli_fetch_row($result_t);
		list($get_current_view_id, $get_current_view_user_id, $get_current_view_ip, $get_current_view_year, $get_current_view_system, $get_current_view_hundred_metric, $get_current_view_pcs_metric, $get_current_view_eight_us, $get_current_view_pcs_us) = $row_t;
	}
}


// Update $get_current_view_id
$fm = "";
if($set == "system"){
	if($value == "metric"){
		mysqli_query($link, "UPDATE $t_food_user_adapted_view SET view_system='metric' WHERE view_id=$get_current_view_id") or die(mysqli_error($link));
		$fm = "system_changed_to_metric";
	}
	else{
		mysqli_query($link, "UPDATE $t_food_user_adapted_view SET view_system='us' WHERE view_id=$get_current_view_id") or die(mysqli_error($link));
		$fm = "system_changed_to_us";
	}
}
elseif($set == "hundred_metric"){
	if($value == "1"){
		mysqli_query($link, "UPDATE $t_food_user_adapted_view SET view_hundred_metric=1 WHERE view_id=$get_current_view_id") or die(mysqli_error($link));
		$fm = "activaed_hundred_metric";
	}
	else{
		mysqli_query($link, "UPDATE $t_food_user_adapted_view SET view_hundred_metric=0 WHERE view_id=$get_current_view_id") or die(mysqli_error($link));
		$fm = "deactivated_hundred_metric";
	}
}
elseif($set == "pcs_metric"){
	if($value == "1"){
		mysqli_query($link, "UPDATE $t_food_user_adapted_view SET view_pcs_metric=1 WHERE view_id=$get_current_view_id") or die(mysqli_error($link));
		$fm = "activaed_pcs_metric";
	}
	else{
		mysqli_query($link, "UPDATE $t_food_user_adapted_view SET view_pcs_metric=0 WHERE view_id=$get_current_view_id") or die(mysqli_error($link));
		$fm = "deactivated_pcs_metric";
	}
}
elseif($set == "eight_us"){
	if($value == "1"){
		mysqli_query($link, "UPDATE $t_food_user_adapted_view SET view_eight_us=1 WHERE view_id=$get_current_view_id") or die(mysqli_error($link));
		$fm = "activaed_eight_us";
	}
	else{
		mysqli_query($link, "UPDATE $t_food_user_adapted_view SET view_eight_us=0 WHERE view_id=$get_current_view_id") or die(mysqli_error($link));
		$fm = "deactivated_eight_us";
	}
}
elseif($set == "pcs_us"){
	if($value == "1"){
		mysqli_query($link, "UPDATE $t_food_user_adapted_view SET view_pcs_us=1 WHERE view_id=$get_current_view_id") or die(mysqli_error($link));
		$fm = "activaed_pcs_us";
	}
	else{
		mysqli_query($link, "UPDATE $t_food_user_adapted_view SET view_pcs_us=0 WHERE view_id=$get_current_view_id") or die(mysqli_error($link));
		$fm = "deactivated_pcs_us";
	}
}
else{
	echo"Unknow request";
	die;
}

// Delete last year
$two_years_ago = $year-2;
mysqli_query($link, "DELETE FROM $t_food_user_adapted_view WHERE view_year=$two_years_ago") or die(mysqli_error($link));


// Header
if($referer == "index"){
	$url = "index.php?l=$l&ft=info&fm=$fm";
	header("Location: $url");
	exit;
}
else{
	echo"Unkwnon referer";
	die;
}

?>