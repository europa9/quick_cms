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
	mysqli_query($link,"DROP TABLE IF EXISTS $t_stats_monthly") or die(mysqli_error());




// Stats :: Monthly
// Liquidbase: _liquidbase/db_scripts/2019/7_stats_monthly.php
$query = "SELECT * FROM $t_stats_monthly LIMIT 1";
$result = mysqli_query($link, $query);

if($result !== FALSE){
}
else{
	mysqli_query($link, "CREATE TABLE $t_stats_monthly(
	   stats_monthly_id INT NOT NULL AUTO_INCREMENT,
	   PRIMARY KEY(stats_monthly_id), 
		   stats_monthly_month INT,
		   stats_monthly_month_saying VARCHAR(200),
		   stats_monthly_year YEAR,
		   stats_monthly_human_unique INT,
		   stats_monthly_human_unique_diff_from_last_month INT,
		   stats_monthly_human_average_duration VARCHAR(200),
		   stats_monthly_human_new_visitor_unique INT,
		   stats_monthly_human_returning_visitor_unique INT,
		   stats_monthly_unique_desktop INT,
		   stats_monthly_unique_desktop_diff_from_last_month INT,
		   stats_monthly_unique_mobile INT,
		   stats_monthly_unique_mobile_diff_from_last_month INT,
		   stats_monthly_unique_bots INT,
		   stats_monthly_unique_bots_diff_from_last_month INT,
		   stats_monthly_hits INT,
		   stats_monthly_hits_desktop INT,
		   stats_monthly_hits_mobile INT,
		   stats_monthly_hits_bots INT,
		   stats_monthly_sum_unique_browsers INT,
		   stats_monthly_sum_unique_os INT)")
	   or die(mysqli_error($link));
}


}
?>