<?php
if(isset($_SESSION['admin_user_id'])){

	/*- Tables -------------------------------------------------------------------------- */
	$t_stats_ip_to_country_ipv4 		= $mysqlPrefixSav . "stats_ip_to_country_ipv4";
	$t_stats_ip_to_country_ipv6 		= $mysqlPrefixSav . "stats_ip_to_country_ipv6";
	$t_stats_ip_to_country_geonames 	= $mysqlPrefixSav . "stats_ip_to_country_geonames";

	mysqli_query($link,"DROP TABLE IF EXISTS $t_stats_ip_to_country_ipv4") or die(mysqli_error());
	mysqli_query($link,"DROP TABLE IF EXISTS $t_stats_ip_to_country_ipv6") or die(mysqli_error());
	mysqli_query($link,"DROP TABLE IF EXISTS $t_stats_ip_to_country_geonames") or die(mysqli_error());

	
} // admin
?>