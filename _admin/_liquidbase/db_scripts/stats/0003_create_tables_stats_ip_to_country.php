<?php
if(isset($_SESSION['admin_user_id'])){

	$t_stats_ip_to_country_ipv4 		= $mysqlPrefixSav . "stats_ip_to_country_ipv4";
	$t_stats_ip_to_country_ipv6 		= $mysqlPrefixSav . "stats_ip_to_country_ipv6";
	$t_stats_ip_to_country_geonames 	= $mysqlPrefixSav . "stats_ip_to_country_geonames";

	mysqli_query($link,"DROP TABLE IF EXISTS $t_stats_ip_to_country_ipv4") or die(mysqli_error());
	mysqli_query($link,"DROP TABLE IF EXISTS $t_stats_ip_to_country_ipv6") or die(mysqli_error());
	mysqli_query($link,"DROP TABLE IF EXISTS $t_stats_ip_to_country_geonames") or die(mysqli_error());

// Stats :: ipv4
$query = "SELECT * FROM $t_stats_ip_to_country_ipv4 LIMIT 1";
$result = mysqli_query($link, $query);

if($result !== FALSE){
}
else{


	mysqli_query($link, "CREATE TABLE $t_stats_ip_to_country_ipv4 (
	   ip_id INT NOT NULL AUTO_INCREMENT,
	   PRIMARY KEY(ip_id), 
		   ip_network VARCHAR(200),
		   ip_from VARCHAR(200),
		   ip_from_a INT,
		   ip_from_b INT,
		   ip_from_c INT,
		   ip_from_d INT,
		   ip_from_numeric BIGINT,
		   ip_to VARCHAR(200),
		   ip_to_a INT,
		   ip_to_b INT,
		   ip_to_c INT,
		   ip_to_d INT,
		   ip_to_numeric BIGINT,
		   ip_geoname_id INT,
		   ip_registered_country_geoname_id INT,
		   ip_represented_country_geoname_id INT,
		   ip_is_anonymous_proxy INT,
		   ip_is_satellite_provider INT)")
	   or die(mysqli_error($link));
}


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


// Stats :: Geonames
$query = "SELECT * FROM $t_stats_ip_to_country_geonames LIMIT 1";
$result = mysqli_query($link, $query);

if($result !== FALSE){
}
else{


	mysqli_query($link, "CREATE TABLE $t_stats_ip_to_country_geonames(
	   geoname_row INT NOT NULL AUTO_INCREMENT,
	   PRIMARY KEY(geoname_row), 
		   geoname_id INT,
		   geoname_locale_code VARCHAR(200),
		   geoname_continent_code VARCHAR(200),
		   geoname_continent_name VARCHAR(200),
		   geoname_country_iso_code VARCHAR(200),
		   geoname_country_name VARCHAR(200),
		   geoname_is_in_european_union VARCHAR(200))")
	   or die(mysqli_error($link));


	$fh = fopen("db_scripts/stats/country_to_ip_geo/geo_en.txt", "r");
	$data = fread($fh, filesize("db_scripts/stats/country_to_ip_geo/geo_en.txt"));
	fclose($fh);

	$array = explode("\n", $data);
	for($x=0;$x<sizeof($array);$x++){
		$temp = explode(",", $array[$x]);
		// 49518,en,AF,Africa,RW,Rwanda,0
		if(isset($temp[0]) && isset($temp[1])){
			$inp_id_mysql = quote_smart($link, output_html($temp[0]));
			$inp_locale_code = quote_smart($link, output_html($temp[1]));

			$inp_continent_code = output_html($temp[2]);
			$inp_continent_code = strtolower($inp_continent_code);
			$inp_continent_code = quote_smart($link, $inp_continent_code);


			$inp_continent_name = output_html($temp[3]);
			$inp_continent_name = str_replace("&quot;", "", $inp_continent_name);
			$inp_continent_name = quote_smart($link, $inp_continent_name);

			$inp_country_iso_code = output_html($temp[4]);
			$inp_country_iso_code = strtolower($inp_country_iso_code);
			$inp_country_iso_code = quote_smart($link, $inp_country_iso_code);

			$inp_country_name = quote_smart($link, output_html($temp[5]));
			$inp_country_name = str_replace("&quot;", "", $inp_country_name);
			$inp_country_name = str_replace("'", "", $inp_country_name);
			$inp_country_name = quote_smart($link, $inp_country_name);

			$inp_is_in_european_union = quote_smart($link, output_html($temp[6]));

			mysqli_query($link, "INSERT INTO $t_stats_ip_to_country_geonames
			(geoname_row, geoname_id, geoname_locale_code, geoname_continent_code, geoname_continent_name, geoname_country_iso_code, geoname_country_name, geoname_is_in_european_union) 
			VALUES 
			(NULL, $inp_id_mysql, $inp_locale_code, $inp_continent_code, $inp_continent_name, $inp_country_iso_code, $inp_country_name, $inp_is_in_european_union)")
			or die(mysqli_error($link));
		}
	}

}




}
?>