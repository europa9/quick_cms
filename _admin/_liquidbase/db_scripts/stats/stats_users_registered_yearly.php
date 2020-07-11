<?php
if(isset($_SESSION['admin_user_id'])){


	$t_stats_users_registered_weekly  = $mysqlPrefixSav . "stats_users_registered_weekly";
	$t_stats_users_registered_monthly = $mysqlPrefixSav . "stats_users_registered_monthly";
	$t_stats_users_registered_yearly  = $mysqlPrefixSav . "stats_users_registered_yearly";


	$t_stats_comments_weekly  = $mysqlPrefixSav . "stats_comments_weekly";
	$t_stats_comments_monthly = $mysqlPrefixSav . "stats_comments_monthly";
	$t_stats_comments_yearly  = $mysqlPrefixSav . "stats_comments_yearly";

	$t_stats_bot_ipblock		= $mysqlPrefixSav . "stats_bot_ipblock";
	$t_stats_human_ipblock 		= $mysqlPrefixSav . "stats_human_ipblock";
	$t_stats_human_online_records	= $mysqlPrefixSav . "stats_human_online_records";
	$t_stats_user_agents 		= $mysqlPrefixSav . "stats_user_agents";
	$t_stats_dayli 			= $mysqlPrefixSav . "stats_dayli";
	$t_stats_monthly		= $mysqlPrefixSav . "stats_monthly";
	$t_stats_browsers 		= $mysqlPrefixSav . "stats_browsers";
	$t_stats_os	 		= $mysqlPrefixSav . "stats_os";
	$t_stats_bots			= $mysqlPrefixSav . "stats_bots";
	$t_stats_accepted_languages	= $mysqlPrefixSav . "stats_accepted_languages";
	$t_stats_referers		= $mysqlPrefixSav . "stats_referers";
	$t_stats_countries		= $mysqlPrefixSav . "stats_countries";

	// Drop table
	mysqli_query($link,"DROP TABLE IF EXISTS $t_stats_users_registered_yearly") or die(mysqli_error());



$query = "SELECT * FROM $t_stats_users_registered_yearly LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
}
else{
	mysqli_query($link, "CREATE TABLE $t_stats_users_registered_yearly(
	   yearly_id INT NOT NULL AUTO_INCREMENT,
	   PRIMARY KEY(yearly_id), 
	   yearly_year INT,
	   yearly_users_registed INT,
	   yearly_users_registed_diff_from_last_year INT,
	   yearly_last_updated DATETIME,
	   yearly_last_updated_day INT,
	   yearly_last_updated_month INT,
	   yearly_last_updated_year INT)")
	or die(mysqli_error($link));
}



}
?>