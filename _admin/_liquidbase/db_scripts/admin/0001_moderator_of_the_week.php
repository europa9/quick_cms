<?php
if(isset($_SESSION['admin_user_id'])){
	$t_users_moderator_of_the_week 	= $mysqlPrefixSav . "users_moderator_of_the_week";


	mysqli_query($link,"DROP TABLE IF EXISTS $t_users_moderator_of_the_week") or die(mysqli_error());
	

$query = "SELECT * FROM $t_users_moderator_of_the_week LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
}
else{
	mysqli_query($link, "CREATE TABLE $t_users_moderator_of_the_week(
	   moderator_of_the_week_id INT NOT NULL AUTO_INCREMENT,
	   PRIMARY KEY(moderator_of_the_week_id), 
	   moderator_week INT,
	   moderator_year INT,
	   moderator_user_id INT,
	   moderator_user_email VARCHAR(240),
	   moderator_user_name VARCHAR(240),
	   moderator_user_alias VARCHAR(240),
	   moderator_user_first_name VARCHAR(240),
	   moderator_user_last_name VARCHAR(240),
	   moderator_user_language VARCHAR(240),
	   moderator_comment VARCHAR(240))")
	or die(mysqli_error($link));
}




}
?>