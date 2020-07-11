<?php
if(isset($_SESSION['admin_user_id'])){

	$t_stats_ip_to_country_ipv4 		= $mysqlPrefixSav . "stats_ip_to_country_ipv4";
	$t_stats_ip_to_country_ipv6 		= $mysqlPrefixSav . "stats_ip_to_country_ipv6";
	$t_stats_ip_to_country_geonames 	= $mysqlPrefixSav . "stats_ip_to_country_geonames";

	mysqli_query($link,"DROP TABLE IF EXISTS $t_stats_ip_to_country_ipv6") or die(mysqli_error());



// Stats :: ipv6
$query = "SELECT * FROM $t_stats_ip_to_country_ipv6 LIMIT 1";
$result = mysqli_query($link, $query);

if($result !== FALSE){
}
else{


	mysqli_query($link, "CREATE TABLE $t_stats_ip_to_country_ipv6 (
	   ip_id INT NOT NULL AUTO_INCREMENT,
	   PRIMARY KEY(ip_id), 
		   ip_network VARCHAR(200),
		   ip_from VARCHAR(200),
		   ip_from_dec_a INT,
		   ip_from_dec_b INT,
		   ip_from_dec_c INT,
		   ip_from_dec_d INT,
		   ip_from_dec_e INT,
		   ip_from_dec_f INT,
		   ip_from_dec_g INT,
		   ip_from_dec_h INT,
		   ip_from_dec_numeric VARCHAR(200),
		   ip_to VARCHAR(200),
		   ip_to_dec_a INT,
		   ip_to_dec_b INT,
		   ip_to_dec_c INT,
		   ip_to_dec_d INT,
		   ip_to_dec_e INT,
		   ip_to_dec_f INT,
		   ip_to_dec_g INT,
		   ip_to_dec_h INT,
		   ip_to_dec_numeric VARCHAR(200),
		   ip_geoname_id INT,
		   ip_registered_country_geoname_id INT,
		   ip_represented_country_geoname_id INT,
		   ip_is_anonymous_proxy INT,
		   ip_is_satellite_provider INT)")
	   or die(mysqli_error($link));
}




}
?>