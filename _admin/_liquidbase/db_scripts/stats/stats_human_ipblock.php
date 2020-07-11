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
	mysqli_query($link,"DROP TABLE IF EXISTS $t_stats_human_ipblock") or die(mysqli_error());


// Stats :: Human visitor ipblock
$query = "SELECT * FROM $t_stats_human_ipblock LIMIT 1";
$result = mysqli_query($link, $query);

if($result !== FALSE){
}
else{
	mysqli_query($link, "CREATE TABLE $t_stats_human_ipblock(
	   stats_human_visitor_id INT NOT NULL AUTO_INCREMENT,
	   PRIMARY KEY(stats_human_visitor_id), 
		   stats_human_visitor_date DATE,
		   stats_human_visitor_time TIME,
		   stats_human_visitor_month INT,
		   stats_human_visitor_year YEAR,
		   stats_human_visitor_timestamp_first_seen INT,
		   stats_human_visitor_timestamp_last_seen INT,
		   stats_human_visitor_hits INT,
		   stats_human_visitor_ip VARCHAR(90),
		   stats_human_visitor_host_ny_addr VARCHAR(90),
		   stats_human_visitor_browser VARCHAR(90),
		   stats_human_visitor_os VARCHAR(90),
		   stats_human_visitor_language VARCHAR(90),
		   stats_human_visitor_type VARCHAR(90),
		   stats_human_visitor_page VARCHAR(500))")
	   or die(mysqli_error($link));
}

}
?>