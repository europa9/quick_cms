<?php
/*
Will either create a new total days, or return the data
from the existing date as an array
*/


/*- Functions ------------------------------------------------------------------------- */
include("../../_admin/_functions/output_html.php");
include("../../_admin/_functions/clean.php");
include("../../_admin/_functions/quote_smart.php");
function utf8ize($d) {
    if (is_array($d)) {
        foreach ($d as $k => $v) {
            $d[$k] = utf8ize($v);
        }
    } else if (is_string ($d)) {
        return utf8_encode($d);
    }
    return $d;
}


/*- MySQL ----------------------------------------------------------------------------- */
$server_name = $_SERVER['HTTP_HOST'];
$server_name = clean($server_name);

$mysql_config_file = "../../_admin/_data/mysql_" . $server_name . ".php";
include("$mysql_config_file");
$link = mysqli_connect($mysqlHostSav, $mysqlUserNameSav, $mysqlPasswordSav, $mysqlDatabaseNameSav);
if (!$link) {
	echo "Error MySQL link";
	die;
}


/*- MySQL Tables ---------------------------------------------------------------------- */
$t_users 	 		= $mysqlPrefixSav . "users";
$t_users_profile 		= $mysqlPrefixSav . "users_profile";
$t_food_diary_totals_days	= $mysqlPrefixSav . "food_diary_totals_days";

/*- Variables ------------------------------------------------------------------------- */
if(isset($_POST['inp_user_id'])) {
	$inp_user_id = $_POST['inp_user_id'];
	$inp_user_id = strip_tags(stripslashes($inp_user_id));
	$inp_user_id_mysql = quote_smart($link, $inp_user_id);
} else {
	echo"Missing user id";
	die;
}
if(isset($_POST['inp_user_password'])) {
	$inp_user_password = $_POST['inp_user_password'];
	$inp_user_password = strip_tags(stripslashes($inp_user_password));
} else {
	echo"Missing user password";
	die;
}

if(isset($_POST['inp_total_day_date'])){
	$inp_total_day_date = $_POST['inp_total_day_date'];
	$inp_total_day_date = output_html($inp_total_day_date);
	$inp_total_day_date_mysql = quote_smart($link, $inp_total_day_date);
}
else{
	echo"Missing total_day_date";
	die;
}

// Total consumed
if(isset($_POST['inp_total_day_consumed_energy'])){
	$inp_total_day_consumed_energy = $_POST['inp_total_day_consumed_energy'];
	$inp_total_day_consumed_energy = output_html($inp_total_day_consumed_energy);
	$inp_total_day_consumed_energy_mysql = quote_smart($link, $inp_total_day_consumed_energy);
}
else{
	echo"Missing total_day_consumed_energy";
	die;
}

if(isset($_POST['inp_total_day_consumed_fat'])){
	$inp_total_day_consumed_fat = $_POST['inp_total_day_consumed_fat'];
	$inp_total_day_consumed_fat = output_html($inp_total_day_consumed_fat);
	$inp_total_day_consumed_fat_mysql = quote_smart($link, $inp_total_day_consumed_fat);
}
else{
	echo"Missing total_day_consumed_fat";
	die;
}

if(isset($_POST['inp_total_day_consumed_carb'])){
	$inp_total_day_consumed_carb = $_POST['inp_total_day_consumed_carb'];
	$inp_total_day_consumed_carb = output_html($inp_total_day_consumed_carb);
	$inp_total_day_consumed_carb_mysql = quote_smart($link, $inp_total_day_consumed_carb);
}
else{
	echo"Missing total_day_consumed_carb";
	die;
}

if(isset($_POST['inp_total_day_consumed_protein'])){
	$inp_total_day_consumed_protein = $_POST['inp_total_day_consumed_protein'];
	$inp_total_day_consumed_protein = output_html($inp_total_day_consumed_protein);
	$inp_total_day_consumed_protein_mysql = quote_smart($link, $inp_total_day_consumed_protein);
}
else{
	echo"Missing total_day_consumed_protein";
	die;
}

// Target sedentary
if(isset($_POST['inp_total_day_target_sedentary_energy'])){
	$inp_total_day_target_sedentary_energy = $_POST['inp_total_day_target_sedentary_energy'];
	$inp_total_day_target_sedentary_energy = output_html($inp_total_day_target_sedentary_energy);
	$inp_total_day_target_sedentary_energy_mysql = quote_smart($link, $inp_total_day_target_sedentary_energy);
}
else{
	echo"Missing total_day_target_sedentary_energy";
	die;
}

if(isset($_POST['inp_total_day_target_sedentary_fat'])){
	$inp_total_day_target_sedentary_fat = $_POST['inp_total_day_target_sedentary_fat'];
	$inp_total_day_target_sedentary_fat = output_html($inp_total_day_target_sedentary_fat);
	$inp_total_day_target_sedentary_fat_mysql = quote_smart($link, $inp_total_day_target_sedentary_fat);
}
else{
	echo"Missing total_day_target_sedentary_fat";
	die;
}

if(isset($_POST['inp_total_day_target_sedentary_carb'])){
	$inp_total_day_target_sedentary_carb = $_POST['inp_total_day_target_sedentary_carb'];
	$inp_total_day_target_sedentary_carb = output_html($inp_total_day_target_sedentary_carb);
	$inp_total_day_target_sedentary_carb_mysql = quote_smart($link, $inp_total_day_target_sedentary_carb);
}
else{
	echo"Missing total_day_target_sedentary_carb";
	die;
}
if(isset($_POST['inp_total_day_target_sedentary_protein'])){
	$inp_total_day_target_sedentary_protein = $_POST['inp_total_day_target_sedentary_protein'];
	$inp_total_day_target_sedentary_protein = output_html($inp_total_day_target_sedentary_protein);
	$inp_total_day_target_sedentary_protein_mysql = quote_smart($link, $inp_total_day_target_sedentary_protein);
}
else{
	echo"Missing total_day_target_sedentary_protein";
	die;
}

// Target_with_activity_energy
if(isset($_POST['inp_total_day_target_with_activity_energy'])){
	$inp_total_day_target_with_activity_energy = $_POST['inp_total_day_target_with_activity_energy'];
	$inp_total_day_target_with_activity_energy = output_html($inp_total_day_target_with_activity_energy);
	$inp_total_day_target_with_activity_energy_mysql = quote_smart($link, $inp_total_day_target_with_activity_energy);
}
else{
	echo"Missing total_day_target_with_activity_energy";
	die;
}
if(isset($_POST['inp_total_day_target_with_activity_fat'])){
	$inp_total_day_target_with_activity_fat = $_POST['inp_total_day_target_with_activity_fat'];
	$inp_total_day_target_with_activity_fat = output_html($inp_total_day_target_with_activity_fat);
	$inp_total_day_target_with_activity_fat_mysql = quote_smart($link, $inp_total_day_target_with_activity_fat);
}
else{
	echo"Missing total_day_target_with_activity_fat";
	die;
}
if(isset($_POST['inp_total_day_target_sedentary_carb'])){
	$inp_total_day_target_sedentary_carb = $_POST['inp_total_day_target_sedentary_carb'];
	$inp_total_day_target_sedentary_carb = output_html($inp_total_day_target_sedentary_carb);
	$inp_total_day_target_sedentary_carb_mysql = quote_smart($link, $inp_total_day_target_sedentary_carb);
}
else{
	echo"Missing total_day_target_sedentary_carb";
	die;
}
if(isset($_POST['inp_total_day_target_with_activity_protein'])){
	$inp_total_day_target_with_activity_protein = $_POST['inp_total_day_target_with_activity_protein'];
	$inp_total_day_target_with_activity_protein = output_html($inp_total_day_target_with_activity_protein);
	$inp_total_day_target_with_activity_protein_mysql = quote_smart($link, $inp_total_day_target_with_activity_protein);
}
else{
	echo"Missing total_day_target_with_activity_protein";
	die;
}

// Diff sedentary
if(isset($_POST['inp_total_day_diff_sedentary_energy'])){
	$inp_total_day_diff_sedentary_energy = $_POST['inp_total_day_diff_sedentary_energy'];
	$inp_total_day_diff_sedentary_energy = output_html($inp_total_day_diff_sedentary_energy);
	$inp_total_day_diff_sedentary_energy_mysql = quote_smart($link, $inp_total_day_diff_sedentary_energy);
}
else{
	echo"Missing total_day_diff_sedentary_energy";
	die;
}

if(isset($_POST['inp_total_day_diff_sedentary_fat'])){
	$inp_total_day_diff_sedentary_fat = $_POST['inp_total_day_diff_sedentary_fat'];
	$inp_total_day_diff_sedentary_fat = output_html($inp_total_day_diff_sedentary_fat);
	$inp_total_day_diff_sedentary_fat_mysql = quote_smart($link, $inp_total_day_diff_sedentary_fat);
}
else{
	echo"Missing total_day_diff_sedentary_fat";
	die;
}

if(isset($_POST['inp_total_day_diff_sedentary_carb'])){
	$inp_total_day_diff_sedentary_carb = $_POST['inp_total_day_diff_sedentary_carb'];
	$inp_total_day_diff_sedentary_carb = output_html($inp_total_day_diff_sedentary_carb);
	$inp_total_day_diff_sedentary_carb_mysql = quote_smart($link, $inp_total_day_diff_sedentary_carb);
}
else{
	echo"Missing total_day_diff_sedentary_carb";
	die;
}
if(isset($_POST['inp_total_day_diff_sedentary_protein'])){
	$inp_total_day_diff_sedentary_protein = $_POST['inp_total_day_diff_sedentary_protein'];
	$inp_total_day_diff_sedentary_protein = output_html($inp_total_day_diff_sedentary_protein);
	$inp_total_day_diff_sedentary_protein_mysql = quote_smart($link, $inp_total_day_diff_sedentary_protein);
}
else{
	echo"Missing total_day_diff_sedentary_protein";
	die;
}



// Diff_with_activity_energy
if(isset($_POST['inp_total_day_diff_with_activity_energy'])){
	$inp_total_day_diff_with_activity_energy = $_POST['inp_total_day_diff_with_activity_energy'];
	$inp_total_day_diff_with_activity_energy = output_html($inp_total_day_diff_with_activity_energy);
	$inp_total_day_diff_with_activity_energy_mysql = quote_smart($link, $inp_total_day_diff_with_activity_energy);
}
else{
	echo"Missing total_day_diff_with_activity_energy";
	die;
}
if(isset($_POST['inp_total_day_diff_with_activity_fat'])){
	$inp_total_day_diff_with_activity_fat = $_POST['inp_total_day_diff_with_activity_fat'];
	$inp_total_day_diff_with_activity_fat = output_html($inp_total_day_diff_with_activity_fat);
	$inp_total_day_diff_with_activity_fat_mysql = quote_smart($link, $inp_total_day_diff_with_activity_fat);
}
else{
	echo"Missing total_day_diff_with_activity_fat";
	die;
}
if(isset($_POST['inp_total_day_diff_sedentary_carb'])){
	$inp_total_day_diff_sedentary_carb = $_POST['inp_total_day_diff_sedentary_carb'];
	$inp_total_day_diff_sedentary_carb = output_html($inp_total_day_diff_sedentary_carb);
	$inp_total_day_diff_sedentary_carb_mysql = quote_smart($link, $inp_total_day_diff_sedentary_carb);
}
else{
	echo"Missing total_day_diff_sedentary_carb";
	die;
}
if(isset($_POST['inp_total_day_diff_with_activity_protein'])){
	$inp_total_day_diff_with_activity_protein = $_POST['inp_total_day_diff_with_activity_protein'];
	$inp_total_day_diff_with_activity_protein = output_html($inp_total_day_diff_with_activity_protein);
	$inp_total_day_diff_with_activity_protein_mysql = quote_smart($link, $inp_total_day_diff_with_activity_protein);
}
else{
	echo"Missing total_day_diff_with_activity_protein";
	die;
}
if(isset($_POST['inp_total_day_diff_with_activity_energy'])){
	$inp_total_day_diff_with_activity_energy = $_POST['inp_total_day_diff_with_activity_energy'];
	$inp_total_day_diff_with_activity_energy = output_html($inp_total_day_diff_with_activity_energy);
	$inp_total_day_diff_with_activity_energy_mysql = quote_smart($link, $inp_total_day_diff_with_activity_energy);
}
else{
	echo"Missing total_day_diff_with_activity_energy";
	die;
}
if(isset($_POST['inp_total_day_diff_with_activity_fat'])){
	$inp_total_day_diff_with_activity_fat = $_POST['inp_total_day_diff_with_activity_fat'];
	$inp_total_day_diff_with_activity_fat = output_html($inp_total_day_diff_with_activity_fat);
	$inp_total_day_diff_with_activity_fat_mysql = quote_smart($link, $inp_total_day_diff_with_activity_fat);
}
else{
	echo"Missing total_day_diff_with_activity_fat";
	die;
}
if(isset($_POST['inp_total_day_diff_with_activity_carb'])){
	$inp_total_day_diff_with_activity_carb = $_POST['inp_total_day_diff_with_activity_carb'];
	$inp_total_day_diff_with_activity_carb = output_html($inp_total_day_diff_with_activity_carb);
	$inp_total_day_diff_with_activity_carb_mysql = quote_smart($link, $inp_total_day_diff_with_activity_carb);
}
else{
	echo"Missing total_day_diff_with_activity_carb";
	die;
}
if(isset($_POST['inp_total_day_diff_with_activity_protein'])){
	$inp_total_day_diff_with_activity_protein = $_POST['inp_total_day_diff_with_activity_protein'];
	$inp_total_day_diff_with_activity_protein = output_html($inp_total_day_diff_with_activity_protein);
	$inp_total_day_diff_with_activity_protein_mysql = quote_smart($link, $inp_total_day_diff_with_activity_protein);
}
else{
	echo"Missing total_day_diff_with_activity_protein";
	die;
}



// Check that user exists
$query = "SELECT user_id, user_password FROM $t_users WHERE user_id=$inp_user_id_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_user_id, $get_user_password) = $row;
if($get_user_id == ""){
	echo"User not found";
	die;
}

// Check password
if($inp_user_password != "$get_user_password"){
	echo"Wrong password for user ID $inp_user_id";
	echo"$inp_user_password != $get_user_password";
	die;
}


// Check if I have a goal for this day
// If I have, then give the data back (dont update)
// If not, then create and give same data back as we got
		
$query = "SELECT total_day_id FROM $t_food_diary_totals_days WHERE total_day_user_id=$inp_user_id_mysql AND total_day_date=$inp_total_day_date_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_total_day_id) = $row;
if($get_total_day_id == ""){
	// We dont have that data
	// Insert it
	$inp_total_day_updated = DATE("Y-m-d H:i:s");
	mysqli_query($link, "INSERT INTO $t_food_diary_totals_days
	(total_day_id, total_day_user_id, total_day_date, 
	total_day_consumed_energy, total_day_consumed_fat, total_day_consumed_carb, total_day_consumed_protein, 
	total_day_target_sedentary_energy, total_day_target_sedentary_fat, total_day_target_sedentary_carb, total_day_target_sedentary_protein, 
	total_day_target_with_activity_energy, total_day_target_with_activity_fat, total_day_target_with_activity_carb, total_day_target_with_activity_protein, 
	total_day_diff_sedentary_energy, total_day_diff_sedentary_fat, total_day_diff_sedentary_carb, total_day_diff_sedentary_protein, 
	total_day_diff_with_activity_energy, total_day_diff_with_activity_fat, total_day_diff_with_activity_carb, total_day_diff_with_activity_protein,
	total_day_updated) 
	VALUES 
	(NULL, $inp_user_id_mysql, $inp_total_day_date_mysql, 
	$inp_total_day_consumed_energy_mysql, $inp_total_day_consumed_fat_mysql, $inp_total_day_consumed_carb_mysql, $inp_total_day_consumed_protein_mysql,
	$inp_total_day_target_sedentary_energy_mysql, $inp_total_day_target_sedentary_fat_mysql, $inp_total_day_target_sedentary_carb_mysql, $inp_total_day_target_sedentary_protein_mysql, 
	$inp_total_day_target_with_activity_energy_mysql, $inp_total_day_target_with_activity_fat_mysql, $inp_total_day_target_sedentary_carb_mysql, $inp_total_day_target_with_activity_protein_mysql, 
	$inp_total_day_diff_sedentary_energy_mysql, $inp_total_day_diff_sedentary_fat_mysql, $inp_total_day_diff_sedentary_carb_mysql, $inp_total_day_diff_sedentary_protein_mysql,
	$inp_total_day_diff_with_activity_energy_mysql, $inp_total_day_diff_with_activity_fat_mysql, $inp_total_day_diff_with_activity_carb_mysql, $inp_total_day_diff_with_activity_protein_mysql,
	'$inp_total_day_updated'
	)")
	or die(mysqli_error($link));

}

// Give data back as array
$rows_array = array();
$query = "SELECT total_day_id, total_day_user_id, total_day_date, total_day_consumed_energy, total_day_consumed_fat, total_day_consumed_carb, total_day_consumed_protein, total_day_target_sedentary_energy, total_day_target_sedentary_fat, total_day_target_sedentary_carb, total_day_target_sedentary_protein, total_day_target_with_activity_energy, total_day_target_with_activity_fat, total_day_target_with_activity_carb, total_day_target_with_activity_protein, total_day_diff_sedentary_energy, total_day_diff_sedentary_fat, total_day_diff_sedentary_carb, total_day_diff_sedentary_protein, total_day_diff_with_activity_energy, total_day_diff_with_activity_fat, total_day_diff_with_activity_carb, total_day_diff_with_activity_protein, total_day_updated FROM $t_food_diary_totals_days WHERE total_day_user_id=$inp_user_id_mysql AND total_day_date=$inp_total_day_date_mysql";
$result = mysqli_query($link, $query);
while($row = mysqli_fetch_array($result)) {
	$rows_array[] = $row;	
}

// Json everything
$rows_json = json_encode(utf8ize($rows_array));

echo"$rows_json";






?>