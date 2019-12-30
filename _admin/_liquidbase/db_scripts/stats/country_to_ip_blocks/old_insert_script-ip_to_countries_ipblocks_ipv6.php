<?php
if(isset($_SESSION['admin_user_id'])){

	$t_stats_ip_to_country_ipv4 		= $mysqlPrefixSav . "stats_ip_to_country_ipv4";
	$t_stats_ip_to_country_ipv6 		= $mysqlPrefixSav . "stats_ip_to_country_ipv6";
	$t_stats_ip_to_country_geonames 	= $mysqlPrefixSav . "stats_ip_to_country_geonames";
	
	/*- Blocks --------------------------------------------------- */
	echo"
	<p>Delete from mysql</p>
	<p>DELETE FROM $t_admin_liquidbase WHERE liquidbase_module='stats' AND liquidbase_name='0007_ip_to_countries_ipblocks_ipv6_check_for_more_blocks.php'</p>
	";
	$result_delete = mysqli_query($link, "DELETE FROM $t_admin_liquidbase WHERE liquidbase_module='stats' AND liquidbase_name='0007_ip_to_countries_ipblocks_ipv6_check_for_more_blocks.php'");
	



	if(file_exists("db_scripts/stats/country_to_ip_blocks/ipv6/disk$counter.gsd")){
		$fh = fopen("db_scripts/stats/country_to_ip_blocks/ipv6/disk$counter.gsd", "r");
		$data = fread($fh, filesize("db_scripts/stats/country_to_ip_blocks/ipv6/disk$counter.gsd"));
		fclose($fh);

		echo"

			<table style=\"border-collapse: collapse;\">
			 <tr>
			  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
				<span>ip_id</span>
			  </td> 
			  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
				<span>ip_network</span>
			  </td> 
			  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
				<span>ip_from</span>
			  </td> 
			  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
				<span>ip_from_dec_a</span>
			  </td> 
			  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
				<span>ip_from_dec_b</span>
			  </td> 
			  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
				<span>ip_from_dec_c</span>
			  </td> 
			  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
				<span>ip_from_dec_d</span>
			  </td> 
			  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
				<span>ip_from_dec_e</span>
			  </td> 
			  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
				<span>ip_from_dec_f</span>
			  </td> 
			  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
				<span>ip_from_dec_g</span>
			  </td> 
			  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
				<span>ip_from_dec_h</span>
			  </td> 
			  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
				<span>ip_from_dec_numeric</span>
			  </td> 
			  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
				<span>ip_to</span>
			  </td> 
			  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
				<span>ip_to_dec_a</span>
			  </td> 
			  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
				<span>ip_to_dec_b</span>
			  </td> 
			  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
				<span>ip_to_dec_c</span>
			  </td> 
			  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
				<span>ip_to_dec_d </span>
			  </td> 
			  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
				<span>ip_to_dec_e </span>
			  </td> 
			  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
				<span>ip_to_dec_f </span>
			  </td> 
			  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
				<span>ip_to_dec_g </span>
			  </td> 
			  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
				<span>ip_to_dec_h</span>
			  </td> 
			  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
				<span>ip_to_dec_numeric</span>
			  </td> 
			  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
				<span>ip_geoname_id </span>
			  </td> 
			  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
				<span>ip_registered_country_geoname_id </span>
			  </td> 
			  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
				<span>ip_represented_country_geoname_id </span>
			  </td> 
			  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
				<span>ip_is_anonymous_proxy </span>
			  </td> 
			  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
				<span>ip_is_satellite_provider</span>
			  </td> 
			 </tr>
		";

		$array = explode("\n", $data);
		for($x=0;$x<sizeof($array);$x++){
			$temp = explode(",", $array[$x]);
		
			if(isset($temp[0]) && isset($temp[1]) && isset($temp[2])){

				$inp_ips_network = output_html($temp[0]);
				$inp_ips_network_mysql = quote_smart($link, $inp_ips_network);

				$network_array = explode("/", $inp_ips_network);
				$network_ip = $network_array[0];
				$network_ip_array = explode(":", $network_ip);

				if(isset($network_array[1])){
					$network_prefix_lenght = $network_array[1];
			
			
				if(isset($network_ip_array[0])){
					$network_ip_from_a = hexdec($network_ip_array[0]);
				}
				else{
					$network_ip_from_a = 0;
				}
				if(isset($network_ip_array[1])){
					$network_ip_from_b = hexdec($network_ip_array[1]);
				}
				else{
					$network_ip_from_b = 0;
				}
				if(isset($network_ip_array[2])){
					$network_ip_from_c = hexdec($network_ip_array[2]);
				}
				else{
					$network_ip_from_c = 0;
				}
				if(isset($network_ip_array[3])){
					$network_ip_from_d = hexdec($network_ip_array[3]);
				}
				else{
					$network_ip_from_d = 0;
				}
				if(isset($network_ip_array[4])){
					$network_ip_from_e = hexdec($network_ip_array[4]);
				}
				else{
					$network_ip_from_e = 0;
				}
				if(isset($network_ip_array[5])){
					$network_ip_from_f = hexdec($network_ip_array[5]);
				}
				else{
					$network_ip_from_f = 0;
				}
				if(isset($network_ip_array[6])){
					$network_ip_from_g = hexdec($network_ip_array[0]);
				}
				else{
					$network_ip_from_g = 0;
				}
				if(isset($network_ip_array[7])){
					$network_ip_from_h = hexdec($network_ip_array[6]);
				}
				else{
					$network_ip_from_h = 0;
				}
				$network_ip_from = $network_ip_from_a . ":" . $network_ip_from_b . ":" . $network_ip_from_c . ":" . $network_ip_from_d . ":" . $network_ip_from_e . ":" . $network_ip_from_f . ":" . $network_ip_from_g . ":" . $network_ip_from_h;
				$network_ip_from_numeric = $network_ip_from_a . $network_ip_from_b . $network_ip_from_c . $network_ip_from_d . $network_ip_from_e . $network_ip_from_f . $network_ip_from_g . $network_ip_from_h;


				// Calculate to
				$network_ip_to_array = explode("/", getCIDRMatchedIP($inp_ips_network));
				$network_ip_to = $network_ip_to_array[0];
				$network_ip_to_array = explode(":", $network_ip_to);

				$network_ip_to_a = hexdec($network_ip_to_array[0]);
				$network_ip_to_b = hexdec($network_ip_to_array[1]);
				$network_ip_to_c = hexdec($network_ip_to_array[2]);
				$network_ip_to_d = hexdec($network_ip_to_array[3]);
				$network_ip_to_e = hexdec($network_ip_to_array[4]);
				$network_ip_to_f = hexdec($network_ip_to_array[5]);
				$network_ip_to_g = hexdec($network_ip_to_array[6]);
				$network_ip_to_h = hexdec($network_ip_to_array[7]);
				$network_ip_to_numeric = $network_ip_to_a . $network_ip_to_b . $network_ip_to_c . $network_ip_to_d . $network_ip_to_e . $network_ip_to_f . $network_ip_to_g . $network_ip_to_h;




				$inp_ips_geoname_id = output_html($temp[1]);
				$inp_ips_geoname_id_mysql = quote_smart($link, $inp_ips_geoname_id);

				$inp_ips_registered_country_geoname_id = output_html($temp[2]);
				if($inp_ips_registered_country_geoname_id == ""){
					$inp_ips_registered_country_geoname_id = 0;
				}
				$inp_ips_registered_country_geoname_id_mysql = quote_smart($link, $inp_ips_registered_country_geoname_id);

				$inp_ips_represented_country_geoname_id = output_html($temp[3]);
				if($inp_ips_represented_country_geoname_id == ""){
					$inp_ips_represented_country_geoname_id = 0;
				}
				$inp_ips_represented_country_geoname_id_mysql = quote_smart($link, $inp_ips_represented_country_geoname_id);

				$inp_ips_is_anonymous_proxy = output_html($temp[4]);
				$inp_ips_is_anonymous_proxy_mysql = quote_smart($link, $inp_ips_is_anonymous_proxy);

				$inp_ips_is_satellite_provider = output_html($temp[5]);
				$inp_ips_is_satellite_provider_mysql = quote_smart($link, $inp_ips_is_satellite_provider);


				echo"
				 <tr>
				  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
					<span></span>
				  </td> 
				  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
					<span>$inp_ips_network</span>
				  </td> 
				  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
					<span>$network_ip_from</span>
				  </td> 
				  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
					<span>$network_ip_from_a</span>
				  </td> 
				  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
					<span>$network_ip_from_b</span>
				  </td> 
				  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
					<span>$network_ip_from_c</span>
				  </td> 
				  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
					<span>$network_ip_from_d</span>
				  </td> 
				  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
					<span>$network_ip_from_e</span>
				  </td> 
				  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
					<span>$network_ip_from_f</span>
				  </td> 
				  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
					<span>$network_ip_from_g</span>
				  </td> 
				  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
					<span>$network_ip_from_h</span>
				  </td> 
				  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
					<span>$network_ip_from_numeric</span>
				  </td> 
				  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
					<span>$network_ip_to</span>
				  </td> 
				  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
					<span>$network_ip_to_a</span>
				  </td> 
				  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
					<span>$network_ip_to_b</span>
				  </td> 
				  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
					<span>$network_ip_to_c</span>
				  </td> 
				  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
					<span>$network_ip_to_d</span>
				  </td> 
				  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
					<span>$network_ip_to_e</span>
				  </td> 
				  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
					<span>$network_ip_to_f</span>
				  </td> 
				  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
					<span>$network_ip_to_g</span>
				  </td> 
				  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
					<span>$network_ip_to_h</span>
				  </td> 
				  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
					<span>$network_ip_to_numeric</span>
				  </td> 
				  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
					<span>$inp_ips_geoname_id</span>
				  </td> 
				  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
					<span>$inp_ips_registered_country_geoname_id</span>
				  </td> 
				  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
					<span>$inp_ips_represented_country_geoname_id</span>
				  </td> 
				  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
					<span>$inp_ips_is_anonymous_proxy</span>
				  </td> 
				  <td style=\"padding-rigth: 4px;border: 1px solid #ddd;\">
					<span>$inp_ips_is_satellite_provider</span>
				  </td> 
				 </tr>
				";

				mysqli_query($link, "INSERT INTO $t_stats_ip_to_country_ipv6 
				(ip_id, ip_network, 
				ip_from, ip_from_dec_a, ip_from_dec_b, ip_from_dec_c, ip_from_dec_d, ip_from_dec_e, ip_from_dec_f, ip_from_dec_g, ip_from_dec_h, ip_from_dec_numeric, 
				ip_to, ip_to_dec_a, ip_to_dec_b, ip_to_dec_c, ip_to_dec_d, ip_to_dec_e, ip_to_dec_f, ip_to_dec_g, ip_to_dec_h, ip_to_dec_numeric, 
				ip_geoname_id, ip_registered_country_geoname_id, ip_represented_country_geoname_id, ip_is_anonymous_proxy, ip_is_satellite_provider) 
				VALUES 
				(NULL, $inp_ips_network_mysql, 
				'$network_ip_from', '$network_ip_from_a', '$network_ip_from_b', '$network_ip_from_c', '$network_ip_from_d', '$network_ip_from_e', '$network_ip_from_f', '$network_ip_from_g', '$network_ip_from_h', '$network_ip_from_numeric',
				'$network_ip_from', '$network_ip_to_a', '$network_ip_to_b', '$network_ip_to_c', '$network_ip_to_d', '$network_ip_to_e', '$network_ip_to_f', '$network_ip_to_g', '$network_ip_to_h', '$network_ip_to_numeric',
				$inp_ips_geoname_id_mysql, $inp_ips_registered_country_geoname_id_mysql, 
				$inp_ips_represented_country_geoname_id_mysql, $inp_ips_is_anonymous_proxy_mysql, $inp_ips_is_satellite_provider_mysql)")
				or die(mysqli_error($link));
				} // network prefix isset
			} // temp[0] isset
		} // while
		echo"
			</table>
		";
	} // block file exists

}



function getCIDRMatchedIP($ip){
    if (strpos($ip, "::") !== false) {
        $parts = explode(":", $ip);

        $cnt = 0;
        // Count number of parts with a number in it
        for ($i = 0; $i < count($parts); $i++) {
            if (is_numeric("0x" . $parts[$i]))
                $cnt++;
        }
        // This is how many 0000 blocks is needed
        $needed = 8 - $cnt;
        $ip = str_replace("::", str_repeat(":0000", $needed), $ip);
    }

    list($ip, $prefix_len) = explode('/', $ip);
    $parts = explode(":", $ip);

    // This is the start bit mask
    $bstring = str_repeat("1", $prefix_len) . str_repeat("0", 128 - $prefix_len);
    $mins = str_split($bstring, 16);

    $start = array();

    for ($i = 0; $i < 8; $i++) {
        $min = base_convert($mins[$i], 2, 16);
        $start[] = sprintf("%04s", dechex(hexdec($parts[$i]) & hexdec($min)));
    }

    $start = implode(':', $start);

    return $start . '/' . $prefix_len;
}

?>