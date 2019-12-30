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


	mysqli_query($link,"DROP TABLE IF EXISTS $t_stats_users_registered_weekly") or die(mysqli_error());
	mysqli_query($link,"DROP TABLE IF EXISTS $t_stats_users_registered_monthly") or die(mysqli_error());
	mysqli_query($link,"DROP TABLE IF EXISTS $t_stats_users_registered_yearly") or die(mysqli_error());
	mysqli_query($link,"DROP TABLE IF EXISTS $t_stats_monthly") or die(mysqli_error());
	mysqli_query($link,"DROP TABLE IF EXISTS $t_stats_dayli") or die(mysqli_error());
	mysqli_query($link,"DROP TABLE IF EXISTS $t_stats_bot_ipblock") or die(mysqli_error());
	mysqli_query($link,"DROP TABLE IF EXISTS $t_stats_human_ipblock") or die(mysqli_error());
	mysqli_query($link,"DROP TABLE IF EXISTS $t_stats_human_online_records") or die(mysqli_error());
	mysqli_query($link,"DROP TABLE IF EXISTS $t_stats_browsers") or die(mysqli_error());
	mysqli_query($link,"DROP TABLE IF EXISTS $t_stats_os") or die(mysqli_error());
	mysqli_query($link,"DROP TABLE IF EXISTS $t_stats_bots") or die(mysqli_error());
	mysqli_query($link,"DROP TABLE IF EXISTS $t_stats_accepted_languages") or die(mysqli_error());
	mysqli_query($link,"DROP TABLE IF EXISTS $t_stats_countries") or die(mysqli_error());


$query = "SELECT * FROM $t_stats_users_registered_weekly LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
}
else{
	mysqli_query($link, "CREATE TABLE $t_stats_users_registered_weekly(
	   weekly_id INT NOT NULL AUTO_INCREMENT,
	   PRIMARY KEY(weekly_id), 
	   weekly_week INT,
	   weekly_year INT,
	   weekly_users_registed INT,
	   weekly_users_registed_diff_from_last_week INT,
	   weekly_last_updated DATETIME,
	   weekly_last_updated_day INT,
	   weekly_last_updated_month INT,
	   weekly_last_updated_year INT)")
	or die(mysqli_error($link));
}


$query = "SELECT * FROM $t_stats_users_registered_monthly LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
}
else{
	mysqli_query($link, "CREATE TABLE $t_stats_users_registered_monthly(
	   monthly_id INT NOT NULL AUTO_INCREMENT,
	   PRIMARY KEY(monthly_id), 
	   monthly_month INT,
	   monthly_year INT,
	   monthly_users_registed INT,
	   monthly_users_registed_diff_from_last_month INT,
	   monthly_last_updated DATETIME,
	   monthly_last_updated_day INT,
	   monthly_last_updated_month INT,
	   monthly_last_updated_year INT)")
	or die(mysqli_error($link));
}

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


$query = "SELECT * FROM $t_stats_comments_weekly LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
}
else{
	mysqli_query($link, "CREATE TABLE $t_stats_comments_weekly(
	   weekly_id INT NOT NULL AUTO_INCREMENT,
	   PRIMARY KEY(weekly_id), 
	   weekly_week INT,
	   weekly_year INT,
	   weekly_comments_written INT,
	   weekly_comments_written_diff_from_last_week INT,
	   weekly_last_updated DATETIME,
	   weekly_last_updated_day INT,
	   weekly_last_updated_month INT,
	   weekly_last_updated_year INT)")
	or die(mysqli_error($link));
}


$query = "SELECT * FROM $t_stats_comments_monthly LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
}
else{
	mysqli_query($link, "CREATE TABLE $t_stats_comments_monthly(
	   monthly_id INT NOT NULL AUTO_INCREMENT,
	   PRIMARY KEY(monthly_id), 
	   monthly_month INT,
	   monthly_year INT,
	   monthly_comments_written INT,
	   monthly_comments_written_diff_from_last_month INT,
	   monthly_last_updated DATETIME,
	   monthly_last_updated_day INT,
	   monthly_last_updated_month INT,
	   monthly_last_updated_year INT)")
	or die(mysqli_error($link));
}

$query = "SELECT * FROM $t_stats_comments_yearly LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
}
else{
	mysqli_query($link, "CREATE TABLE $t_stats_comments_yearly(
	   yearly_id INT NOT NULL AUTO_INCREMENT,
	   PRIMARY KEY(yearly_id), 
	   yearly_year INT,
	   yearly_comments_written INT,
	   yearly_comments_written_diff_from_last_year INT,
	   yearly_last_updated DATETIME,
	   yearly_last_updated_day INT,
	   yearly_last_updated_month INT,
	   yearly_last_updated_year INT)")
	or die(mysqli_error($link));
}





// Stats :: User agents
$query = "SELECT * FROM $t_stats_user_agents LIMIT 1";
$result = mysqli_query($link, $query);

if($result !== FALSE){
}
else{
	mysqli_query($link, "CREATE TABLE $t_stats_user_agents(
	   stats_user_agent_id INT NOT NULL AUTO_INCREMENT,
	   PRIMARY KEY(stats_user_agent_id), 
	   stats_user_agent_string VARCHAR(250),
	   stats_user_agent_browser VARCHAR(250),
	   stats_user_agent_browser_version VARCHAR(250),
	   stats_user_agent_browser_icon VARCHAR(250),
	   stats_user_agent_os VARCHAR(250),
	   stats_user_agent_os_version VARCHAR(250),
	   stats_user_agent_os_icon VARCHAR(250),
	   stats_user_agent_bot VARCHAR(250),
	   stats_user_agent_bot_icon VARCHAR(250),
	   stats_user_agent_url VARCHAR(250),
	   stats_user_agent_type VARCHAR(250),
	   stats_user_agent_banned INT)")
	   or die(mysqli_error($link));

	// Type = unknown, desktop, mobile, bot
}


// Stats :: Bot ipblock
$query = "SELECT * FROM $t_stats_bot_ipblock LIMIT 1";
$result = mysqli_query($link, $query);

if($result !== FALSE){
}
else{
	mysqli_query($link, "CREATE TABLE $t_stats_bot_ipblock(
	   stats_bot_ipblock_visitor_id INT NOT NULL AUTO_INCREMENT,
	   PRIMARY KEY(stats_bot_ipblock_visitor_id), 
		   stats_bot_ipblock_visitor_date DATE,
		   stats_bot_ipblock_visitor_time TIME,
		   stats_bot_ipblock_visitor_month INT,
		   stats_bot_ipblock_visitor_year YEAR,
		   stats_bot_ipblock_visitor_name VARCHAR(90),
		   stats_bot_ipblock_visitor_icon VARCHAR(90),
		   stats_bot_ipblock_visitor_page VARCHAR(500))")
	 	  or die(mysqli_error($link));
}


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



// Stats :: Human visitor online records
$query = "SELECT * FROM $t_stats_human_online_records LIMIT 1";
$result = mysqli_query($link, $query);

if($result !== FALSE){
}
else{
	mysqli_query($link, "CREATE TABLE $t_stats_human_online_records(
	   stats_human_online_record_id INT NOT NULL AUTO_INCREMENT,
	   PRIMARY KEY(stats_human_online_record_id), 
		   stats_human_online_record_date DATE,
		   stats_human_online_record_count INT)")
	   or die(mysqli_error($link));
}


// Stats :: Dayli
$query = "SELECT * FROM $t_stats_dayli LIMIT 1";
$result = mysqli_query($link, $query);

if($result !== FALSE){
}
else{
	mysqli_query($link, "CREATE TABLE $t_stats_dayli(
	   stats_dayli_id INT NOT NULL AUTO_INCREMENT,
	   PRIMARY KEY(stats_dayli_id), 
		   stats_dayli_day INT,
		   stats_dayli_month INT,
		   stats_dayli_year YEAR,
		   stats_dayli_weekday VARCHAR(50),
		   stats_dayli_human_unique INT,
		   stats_dayli_human_unique_diff_from_yesterday INT,
		   stats_dayli_human_average_duration VARCHAR(200),
		   stats_dayli_human_new_visitor_unique INT,
		   stats_dayli_human_returning_visitor_unique INT,
		   stats_dayli_unique_desktop INT,
		   stats_dayli_unique_mobile INT,
		   stats_dayli_unique_bots INT,
		   stats_dayli_hits INT,
		   stats_dayli_hits_desktop INT,
		   stats_dayli_hits_mobile INT,
		   stats_dayli_hits_bots INT)")
	   or die(mysqli_error($link));
}

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


// Stats :: Browser
$query = "SELECT * FROM $t_stats_browsers LIMIT 1";
$result = mysqli_query($link, $query);

if($result !== FALSE){
}
else{
	mysqli_query($link, "CREATE TABLE $t_stats_browsers(
	   stats_browser_id INT NOT NULL AUTO_INCREMENT,
	   PRIMARY KEY(stats_browser_id), 
		   stats_browser_month INT,
		   stats_browser_year YEAR,
		   stats_browser_name VARCHAR(250),
		   stats_browser_unique INT,
		   stats_browser_hits INT)")
	   or die(mysqli_error($link));
}


// Stats :: OS
$query = "SELECT * FROM $t_stats_os LIMIT 1";
$result = mysqli_query($link, $query);

if($result !== FALSE){
}
else{
	mysqli_query($link, "CREATE TABLE $t_stats_os(
	   stats_os_id INT NOT NULL AUTO_INCREMENT,
	   PRIMARY KEY(stats_os_id), 
		   stats_os_month INT,
		   stats_os_year YEAR,
		   stats_os_name VARCHAR(250),
		   stats_os_type VARCHAR(250),
		   stats_os_unique INT,
		   stats_os_hits INT)")
	   or die(mysqli_error($link));
}

// Stats :: Bots
$query = "SELECT * FROM $t_stats_bots LIMIT 1";
$result = mysqli_query($link, $query);

if($result !== FALSE){
}
else{
	mysqli_query($link, "CREATE TABLE $t_stats_bots(
	   stats_bot_id INT NOT NULL AUTO_INCREMENT,
	   PRIMARY KEY(stats_bot_id), 
		   stats_bot_month INT,
		   stats_bot_year YEAR,
		   stats_bot_name VARCHAR(250),
		   stats_bot_unique INT,
		   stats_bot_hits INT)")
	   or die(mysqli_error($link));
}

// Stats :: Accepted language
$query = "SELECT * FROM $t_stats_accepted_languages LIMIT 1";
$result = mysqli_query($link, $query);

if($result !== FALSE){
}
else{
	mysqli_query($link, "CREATE TABLE $t_stats_accepted_languages(
	   stats_accepted_language_id INT NOT NULL AUTO_INCREMENT,
	   PRIMARY KEY(stats_accepted_language_id), 
		   stats_accepted_language_month INT,
		   stats_accepted_language_year YEAR,
		   stats_accepted_language_name VARCHAR(250),
		   stats_accepted_language_unique INT,
		   stats_accepted_language_hits INT)")
	   or die(mysqli_error($link));
}



// Stats :: REFERER
$query = "SELECT * FROM $t_stats_referers LIMIT 1";
$result = mysqli_query($link, $query);

if($result !== FALSE){
}
else{
	mysqli_query($link, "CREATE TABLE $t_stats_referers(
	   stats_referer_id INT NOT NULL AUTO_INCREMENT,
	   PRIMARY KEY(stats_referer_id), 
		   stats_referer_month INT,
		   stats_referer_year YEAR,
		   stats_referer_from_url VARCHAR(500),
		   stats_referer_to_url VARCHAR(500),
		   stats_referer_unique INT,
		   stats_referer_hits INT)")
	   or die(mysqli_error($link));
}

	// Stats :: Country 
	$query = "SELECT * FROM $t_stats_countries LIMIT 1";
	$result = mysqli_query($link, $query);

	if($result !== FALSE){
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_stats_countries(
	 	  stats_country_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(stats_country_id), 
		 	  stats_country_month INT,
			   stats_country_year YEAR,
			   stats_country_name VARCHAR(200),
			   stats_country_city VARCHAR(200),
			   stats_country_unique INT,
			   stats_country_hits INT,
			   stats_country_last_ip VARCHAR(200))")
	   	or die(mysqli_error($link));
	}

}
?>