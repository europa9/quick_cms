<?php
if(isset($_SESSION['admin_user_id'])){

	$t_stats_ip_to_country_ipv4 		= $mysqlPrefixSav . "stats_ip_to_country_ipv4";
	$t_stats_ip_to_country_ipv6 		= $mysqlPrefixSav . "stats_ip_to_country_ipv6";
	$t_stats_ip_to_country_geonames 	= $mysqlPrefixSav . "stats_ip_to_country_geonames";

	/*- Blocks --------------------------------------------------- */
	echo"
	<p>Delete from mysql</p>
	<pre>DELETE FROM $t_admin_liquidbase WHERE liquidbase_module='stats' AND liquidbase_name='0005_ip_to_countries_ipblocks_ipv4_check_for_more_blocks.php'</pre>
	";
	$result_delete = mysqli_query($link, "DELETE FROM $t_admin_liquidbase WHERE liquidbase_module='stats' AND liquidbase_name='0005_ip_to_countries_ipblocks_ipv4_check_for_more_blocks.php'");
	




	


	// Read file
	echo"<p>Read file <a href=\"db_scripts/stats/country_to_ip_blocks/ipv4/disk$counter.gsd\">db_scripts/stats/country_to_ip_blocks/ipv4/disk$counter.gsd</a></p>\n";
	$fh = fopen("db_scripts/stats/country_to_ip_blocks/ipv4/disk$counter.gsd", "r");
	$data = fread($fh, filesize("db_scripts/stats/country_to_ip_blocks/ipv4/disk$counter.gsd"));
	fclose($fh);

	$array = explode("\n", $data);
	for($x=0;$x<sizeof($array);$x++){
		$temp = explode(",", $array[$x]);
		
		if(isset($temp[0]) && isset($temp[1])){
			$inp_ips_network = output_html($temp[0]);
			$inp_ips_network_mysql = quote_smart($link, $inp_ips_network);


			$network_array = explode("/", $inp_ips_network);
			$network_ip = $network_array[0];
			$network_ip_array = explode(".", $network_ip);
			if(isset($network_array[1])){
				$network_mask = $network_array[1];
				
				if(isset($network_ip_array[0])){
					$network_ip_start_a = $network_ip_array[0];
				}
				else{
					$network_ip_start_a = 0;
				}
				if(isset($network_ip_array[1])){
					$network_ip_start_b = $network_ip_array[1];
				}
				else{
					$network_ip_start_b = 0;
				}

				if(isset($network_ip_array[2])){
					$network_ip_start_c = $network_ip_array[2];
				}
				else{
					$network_ip_start_c = 0;
				}
				if(isset($network_ip_array[3])){
					$network_ip_start_d = $network_ip_array[3];
				}
				else{
					$network_ip_start_d = 0;
				}
				$network_ip_start = $network_ip_start_a . "." . $network_ip_start_b . "." . $network_ip_start_c . "." . $network_ip_start_d;
				$network_ip_start_numeric = $network_ip_start_a . $network_ip_start_b . $network_ip_start_c . $network_ip_start_d;

				if($network_mask == "32"){
					$network_difference_to_last_address  = "+0.0.0.0";
					$network_ip_stop_a = $network_ip_start_a;
					$network_ip_stop_b = $network_ip_start_b;
					$network_ip_stop_c = $network_ip_start_c;
					$network_ip_stop_d = $network_ip_start_d;
					$network_ip_stop = $network_ip_stop_a . "." . $network_ip_stop_b . "." . $network_ip_stop_c . "." . $network_ip_stop_d ;
				}
				elseif($network_mask == "31"){
					$network_difference_to_last_address  = "+0.0.0.1";
					$network_ip_stop_a = $network_ip_start_a;
					$network_ip_stop_b = $network_ip_start_b;
					$network_ip_stop_c = $network_ip_start_c;
					$network_ip_stop_d = $network_ip_start_d+1;
					$network_ip_stop = $network_ip_stop_a . "." . $network_ip_stop_b . "." . $network_ip_stop_c . "." . $network_ip_stop_d ;
				}
				elseif($network_mask == "30"){
					$network_difference_to_last_address  = "+0.0.0.3";
					$network_ip_stop_a = $network_ip_start_a;
					$network_ip_stop_b = $network_ip_start_b;
					$network_ip_stop_c = $network_ip_start_c;
					$network_ip_stop_d = $network_ip_start_d+3;
					$network_ip_stop = $network_ip_stop_a . "." . $network_ip_stop_b . "." . $network_ip_stop_c . "." . $network_ip_stop_d ;
				}
				elseif($network_mask == "29"){
					$network_difference_to_last_address  = "+0.0.0.7";
					$network_ip_stop_a = $network_ip_start_a;
					$network_ip_stop_b = $network_ip_start_b;
					$network_ip_stop_c = $network_ip_start_c;
					$network_ip_stop_d = $network_ip_start_d+7;
					$network_ip_stop = $network_ip_stop_a . "." . $network_ip_stop_b . "." . $network_ip_stop_c . "." . $network_ip_stop_d ;
				}
				elseif($network_mask == "28"){
					$network_difference_to_last_address  = "+0.0.0.15";
					$network_ip_stop_a = $network_ip_start_a;
					$network_ip_stop_b = $network_ip_start_b;
					$network_ip_stop_c = $network_ip_start_c;
					$network_ip_stop_d = $network_ip_start_d+15;
					$network_ip_stop = $network_ip_stop_a . "." . $network_ip_stop_b . "." . $network_ip_stop_c . "." . $network_ip_stop_d ;
				}
				elseif($network_mask == "27"){
					$network_difference_to_last_address  = "+0.0.0.31";
					$network_ip_stop_a = $network_ip_start_a;
					$network_ip_stop_b = $network_ip_start_b;
					$network_ip_stop_c = $network_ip_start_c;
					$network_ip_stop_d = $network_ip_start_d+31;
					$network_ip_stop = $network_ip_stop_a . "." . $network_ip_stop_b . "." . $network_ip_stop_c . "." . $network_ip_stop_d ;
				}
				elseif($network_mask == "26"){
					$network_difference_to_last_address  = "+0.0.0.63";
					$network_ip_stop_a = $network_ip_start_a;
					$network_ip_stop_b = $network_ip_start_b;
					$network_ip_stop_c = $network_ip_start_c;
					$network_ip_stop_d = $network_ip_start_d+63;
					$network_ip_stop = $network_ip_stop_a . "." . $network_ip_stop_b . "." . $network_ip_stop_c . "." . $network_ip_stop_d ;
				}
				elseif($network_mask == "25"){
					$network_difference_to_last_address  = "+0.0.0.127";
					$network_ip_stop_a = $network_ip_start_a;
					$network_ip_stop_b = $network_ip_start_b;
					$network_ip_stop_c = $network_ip_start_c;
					$network_ip_stop_d = $network_ip_start_d+127;
					$network_ip_stop = $network_ip_stop_a . "." . $network_ip_stop_b . "." . $network_ip_stop_c . "." . $network_ip_stop_d ;
				}
				elseif($network_mask == "24"){
					$network_difference_to_last_address  = "+0.0.0.255";
					$network_ip_stop_a = $network_ip_start_a;
					$network_ip_stop_b = $network_ip_start_b;
					$network_ip_stop_c = $network_ip_start_c;
					$network_ip_stop_d = $network_ip_start_d+225;
					$network_ip_stop = $network_ip_stop_a . "." . $network_ip_stop_b . "." . $network_ip_stop_c . "." . $network_ip_stop_d ;
				}
				elseif($network_mask == "23"){
					$network_difference_to_last_address  = "+0.0.1.255";
					$network_ip_stop_a = $network_ip_start_a;
					$network_ip_stop_b = $network_ip_start_b;
					$network_ip_stop_c = $network_ip_start_c+1;
					$network_ip_stop_d = $network_ip_start_d+225;
					$network_ip_stop = $network_ip_stop_a . "." . $network_ip_stop_b . "." . $network_ip_stop_c . "." . $network_ip_stop_d ;
				}
				elseif($network_mask == "22"){
					$network_difference_to_last_address  = "+0.0.3.255";
					$network_ip_stop_a = $network_ip_start_a;
					$network_ip_stop_b = $network_ip_start_b;
					$network_ip_stop_c = $network_ip_start_c+3;
					$network_ip_stop_d = $network_ip_start_d+225;
					$network_ip_stop = $network_ip_stop_a . "." . $network_ip_stop_b . "." . $network_ip_stop_c . "." . $network_ip_stop_d ;
				}
				elseif($network_mask == "21"){
					$network_difference_to_last_address  = "+0.0.7.255";
					$network_ip_stop_a = $network_ip_start_a;
					$network_ip_stop_b = $network_ip_start_b;
					$network_ip_stop_c = $network_ip_start_c+7;
					$network_ip_stop_d = $network_ip_start_d+225;
					$network_ip_stop = $network_ip_stop_a . "." . $network_ip_stop_b . "." . $network_ip_stop_c . "." . $network_ip_stop_d ;
				}
				elseif($network_mask == "20"){
					$network_difference_to_last_address  = "+0.0.15.255";
					$network_ip_stop_a = $network_ip_start_a;
					$network_ip_stop_b = $network_ip_start_b;
					$network_ip_stop_c = $network_ip_start_c+15;
					$network_ip_stop_d = $network_ip_start_d+225;
					$network_ip_stop = $network_ip_stop_a . "." . $network_ip_stop_b . "." . $network_ip_stop_c . "." . $network_ip_stop_d ;
				}
				elseif($network_mask == "19"){
					$network_difference_to_last_address  = "+0.0.31.255";
					$network_ip_stop_a = $network_ip_start_a;
					$network_ip_stop_b = $network_ip_start_b;
					$network_ip_stop_c = $network_ip_start_c+31;
					$network_ip_stop_d = $network_ip_start_d+225;
					$network_ip_stop = $network_ip_stop_a . "." . $network_ip_stop_b . "." . $network_ip_stop_c . "." . $network_ip_stop_d ;
				}
				elseif($network_mask == "18"){
					$network_difference_to_last_address  = "+0.0.63.255";
					$network_ip_stop_a = $network_ip_start_a;
					$network_ip_stop_b = $network_ip_start_b;
					$network_ip_stop_c = $network_ip_start_c+63;
					$network_ip_stop_d = $network_ip_start_d+225;
					$network_ip_stop = $network_ip_stop_a . "." . $network_ip_stop_b . "." . $network_ip_stop_c . "." . $network_ip_stop_d ;
				}
				elseif($network_mask == "17"){
					$network_difference_to_last_address  = "+0.0.127.255";
					$network_ip_stop_a = $network_ip_start_a;
					$network_ip_stop_b = $network_ip_start_b;
					$network_ip_stop_c = $network_ip_start_c+127;
					$network_ip_stop_d = $network_ip_start_d+225;
					$network_ip_stop = $network_ip_stop_a . "." . $network_ip_stop_b . "." . $network_ip_stop_c . "." . $network_ip_stop_d ;
				}
				elseif($network_mask == "16"){
					$network_difference_to_last_address  = "+0.0.255.255";
					$network_ip_stop_a = $network_ip_start_a;
					$network_ip_stop_b = $network_ip_start_b;
					$network_ip_stop_c = $network_ip_start_c+255;
					$network_ip_stop_d = $network_ip_start_d+225;
					$network_ip_stop = $network_ip_stop_a . "." . $network_ip_stop_b . "." . $network_ip_stop_c . "." . $network_ip_stop_d ;
				}
				elseif($network_mask == "15"){
					$network_difference_to_last_address  = "+0.1.255.255";
					$network_ip_stop_a = $network_ip_start_a;
					$network_ip_stop_b = $network_ip_start_b+1;
					$network_ip_stop_c = $network_ip_start_c+255;
					$network_ip_stop_d = $network_ip_start_d+225;
					$network_ip_stop = $network_ip_stop_a . "." . $network_ip_stop_b . "." . $network_ip_stop_c . "." . $network_ip_stop_d ;
				}
				elseif($network_mask == "14"){
					$network_difference_to_last_address  = "+0.3.255.255";
					$network_ip_stop_a = $network_ip_start_a;
					$network_ip_stop_b = $network_ip_start_b+3;
					$network_ip_stop_c = $network_ip_start_c+255;
					$network_ip_stop_d = $network_ip_start_d+225;
					$network_ip_stop = $network_ip_stop_a . "." . $network_ip_stop_b . "." . $network_ip_stop_c . "." . $network_ip_stop_d ;
				}
				elseif($network_mask == "13"){
					$network_difference_to_last_address  = "+0.7.255.255";
					$network_ip_stop_a = $network_ip_start_a;
					$network_ip_stop_b = $network_ip_start_b+7;
					$network_ip_stop_c = $network_ip_start_c+255;
					$network_ip_stop_d = $network_ip_start_d+225;
					$network_ip_stop = $network_ip_stop_a . "." . $network_ip_stop_b . "." . $network_ip_stop_c . "." . $network_ip_stop_d ;
				}
				elseif($network_mask == "12"){
					$network_difference_to_last_address  = "+0.15.255.255";
					$network_ip_stop_a = $network_ip_start_a;
					$network_ip_stop_b = $network_ip_start_b+15;
					$network_ip_stop_c = $network_ip_start_c+255;
					$network_ip_stop_d = $network_ip_start_d+225;
					$network_ip_stop = $network_ip_stop_a . "." . $network_ip_stop_b . "." . $network_ip_stop_c . "." . $network_ip_stop_d ;
				}
				elseif($network_mask == "11"){
					$network_difference_to_last_address  = "+0.31.255.255";
					$network_ip_stop_a = $network_ip_start_a;
					$network_ip_stop_b = $network_ip_start_b+31;
					$network_ip_stop_c = $network_ip_start_c+255;
					$network_ip_stop_d = $network_ip_start_d+225;
					$network_ip_stop = $network_ip_stop_a . "." . $network_ip_stop_b . "." . $network_ip_stop_c . "." . $network_ip_stop_d ;
				}
				elseif($network_mask == "10"){
					$network_difference_to_last_address  = "+0.63.255.255";
					$network_ip_stop_a = $network_ip_start_a;
					$network_ip_stop_b = $network_ip_start_b+63;
					$network_ip_stop_c = $network_ip_start_c+255;
					$network_ip_stop_d = $network_ip_start_d+225;
					$network_ip_stop = $network_ip_stop_a . "." . $network_ip_stop_b . "." . $network_ip_stop_c . "." . $network_ip_stop_d ;
				}
				elseif($network_mask == "9"){
					$network_difference_to_last_address  = "+0.127.255.255";
					$network_ip_stop_a = $network_ip_start_a;
					$network_ip_stop_b = $network_ip_start_b+127;
					$network_ip_stop_c = $network_ip_start_c+255;
					$network_ip_stop_d = $network_ip_start_d+225;
					$network_ip_stop = $network_ip_stop_a . "." . $network_ip_stop_b . "." . $network_ip_stop_c . "." . $network_ip_stop_d ;
				}
				elseif($network_mask == "8"){
					$network_difference_to_last_address  = "+0.255.255.255";
					$network_ip_stop_a = $network_ip_start_a;
					$network_ip_stop_b = $network_ip_start_b+255;
					$network_ip_stop_c = $network_ip_start_c+255;
					$network_ip_stop_d = $network_ip_start_d+225;
					$network_ip_stop = $network_ip_stop_a . "." . $network_ip_stop_b . "." . $network_ip_stop_c . "." . $network_ip_stop_d ;
				}
				elseif($network_mask == "7"){
					$network_difference_to_last_address  = "+1.255.255.255";
					$network_ip_stop_a = $network_ip_start_a+1;
					$network_ip_stop_b = $network_ip_start_b+255;
					$network_ip_stop_c = $network_ip_start_c+255;
					$network_ip_stop_d = $network_ip_start_d+225;
					$network_ip_stop = $network_ip_stop_a . "." . $network_ip_stop_b . "." . $network_ip_stop_c . "." . $network_ip_stop_d ;
				}
				elseif($network_mask == "6"){
					$network_difference_to_last_address  = "+3.255.255.255";
					$network_ip_stop_a = $network_ip_start_a+3;
					$network_ip_stop_b = $network_ip_start_b+255;
					$network_ip_stop_c = $network_ip_start_c+255;
					$network_ip_stop_d = $network_ip_start_d+225;
					$network_ip_stop = $network_ip_stop_a . "." . $network_ip_stop_b . "." . $network_ip_stop_c . "." . $network_ip_stop_d ;
				}
				elseif($network_mask == "5"){
					$network_difference_to_last_address  = "+7.255.255.255";
					$network_ip_stop_a = $network_ip_start_a+7;
					$network_ip_stop_b = $network_ip_start_b+225;
					$network_ip_stop_c = $network_ip_start_c+225;
					$network_ip_stop_d = $network_ip_start_d+225;
					$network_ip_stop = $network_ip_stop_a . "." . $network_ip_stop_b . "." . $network_ip_stop_c . "." . $network_ip_stop_d ;
				}
				elseif($network_mask == "4"){
					$network_difference_to_last_address  = "+15.255.255.255";
					$network_ip_stop_a = $network_ip_start_a+15;
					$network_ip_stop_b = $network_ip_start_b+225;
					$network_ip_stop_c = $network_ip_start_c+225;
					$network_ip_stop_d = $network_ip_start_d+225;
					$network_ip_stop = $network_ip_stop_a . "." . $network_ip_stop_b . "." . $network_ip_stop_c . "." . $network_ip_stop_d ;
				}
				elseif($network_mask == "3"){
					$network_difference_to_last_address  = "+31.255.255.255";
					$network_ip_stop_a = $network_ip_start_a+31;
					$network_ip_stop_b = $network_ip_start_b+225;
					$network_ip_stop_c = $network_ip_start_c+225;
					$network_ip_stop_d = $network_ip_start_d+225;
					$network_ip_stop = $network_ip_stop_a . "." . $network_ip_stop_b . "." . $network_ip_stop_c . "." . $network_ip_stop_d ;
				}
				elseif($network_mask == "2"){
					$network_difference_to_last_address  = "+63.255.255.255";
					$network_ip_stop_a = $network_ip_start_a+63;
					$network_ip_stop_b = $network_ip_start_b+225;
					$network_ip_stop_c = $network_ip_start_c+225;
					$network_ip_stop_d = $network_ip_start_d+225;
					$network_ip_stop = $network_ip_stop_a . "." . $network_ip_stop_b . "." . $network_ip_stop_c . "." . $network_ip_stop_d ;
				}
				elseif($network_mask == "1"){
					$network_difference_to_last_address  = "+127.255.255.255";
					$network_ip_stop_a = $network_ip_start_a+127;
					$network_ip_stop_b = $network_ip_start_b+225;
					$network_ip_stop_c = $network_ip_start_c+225;
					$network_ip_stop_d = $network_ip_start_d+225;
					$network_ip_stop = $network_ip_stop_a . "." . $network_ip_stop_b . "." . $network_ip_stop_c . "." . $network_ip_stop_d ;
				}
				else{
					$network_difference_to_last_address  = "+255.255.255.255";
					$network_ip_stop_a = $network_ip_start_a+255;
					$network_ip_stop_b = $network_ip_start_b+225;
					$network_ip_stop_c = $network_ip_start_c+225;
					$network_ip_stop_d = $network_ip_start_d+225;
				}
				$network_ip_stop = $network_ip_stop_a . "." . $network_ip_stop_b . "." . $network_ip_stop_c . "." . $network_ip_stop_d;
				$network_ip_stop_numeric = $network_ip_stop_a . $network_ip_stop_b . $network_ip_stop_c . $network_ip_stop_d;


				$inp_ips_geoname_id = output_html($temp[1]);
				if(!(is_numeric($inp_ips_geoname_id)) OR empty($inp_ips_geoname_id)){
					$inp_ips_geoname_id = 0;	
				}
				$inp_ips_geoname_id_mysql = quote_smart($link, $inp_ips_geoname_id);

				if(isset($temp[2])){
					$inp_ips_registered_country_geoname_id = output_html($temp[2]);	
					if(!(is_numeric($inp_ips_registered_country_geoname_id))){
						$inp_ips_registered_country_geoname_id = "0";	
					}
				}
				else{
					$inp_ips_registered_country_geoname_id = "0";	
				}
				$inp_ips_registered_country_geoname_id_mysql = quote_smart($link, $inp_ips_registered_country_geoname_id);

				if(isset($temp[3])){
					$inp_ips_represented_country_geoname_id = output_html($temp[3]);
					if(!(is_numeric($inp_ips_represented_country_geoname_id))){
						$inp_ips_represented_country_geoname_id = "0";	
					}
				}
				else{
					$inp_ips_represented_country_geoname_id = "0";
				}
				$inp_ips_represented_country_geoname_id_mysql = quote_smart($link, $inp_ips_represented_country_geoname_id);

				if(isset($temp[4])){
					$inp_ips_is_anonymous_proxy = output_html($temp[4]);
					if(!(is_numeric($inp_ips_is_anonymous_proxy))){
						$inp_ips_is_anonymous_proxy = "0";	
					}
				}
				else{
					$inp_ips_is_anonymous_proxy = "0";
				}
				$inp_ips_is_anonymous_proxy_mysql = quote_smart($link, $inp_ips_is_anonymous_proxy);

				if(isset($temp[5])){
					$inp_ips_is_satellite_provider = output_html($temp[5]);
					if(!(is_numeric($inp_ips_is_satellite_provider))){
						$inp_ips_is_satellite_provider = "0";	
					}
				}
				else{
					$inp_ips_is_satellite_provider = "0";
				}
				$inp_ips_is_satellite_provider_mysql = quote_smart($link, $inp_ips_is_satellite_provider);


				if($inp_ips_geoname_id != 0 && $network_ip_start_b != "" && $network_ip_start_d != ""){
					mysqli_query($link, "INSERT INTO $t_stats_ip_to_country_ipv4 
					(ip_id, ip_network, ip_from, ip_from_a, ip_from_b, 
					ip_from_c, ip_from_d, ip_from_numeric, ip_to, ip_to_a, 
					ip_to_b, ip_to_c, ip_to_d, ip_to_numeric, ip_geoname_id, 
					ip_registered_country_geoname_id, ip_represented_country_geoname_id, ip_is_anonymous_proxy, ip_is_satellite_provider) 
					VALUES 
					(NULL, $inp_ips_network_mysql, '$network_ip_start', '$network_ip_start_a', '$network_ip_start_b', 
					'$network_ip_start_c', '$network_ip_start_d', '$network_ip_start_numeric', '$network_ip_stop', '$network_ip_stop_a', 
					'$network_ip_stop_b', '$network_ip_stop_c', '$network_ip_stop_d', '$network_ip_stop_numeric', $inp_ips_geoname_id_mysql, 
					$inp_ips_registered_country_geoname_id_mysql, $inp_ips_represented_country_geoname_id_mysql, $inp_ips_is_anonymous_proxy_mysql, $inp_ips_is_satellite_provider_mysql)")
					or die(mysqli_error($link));
				}

			} // missing network mask
		}
	}
}


?>