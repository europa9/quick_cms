<?php
if(isset($_SESSION['admin_user_id'])){

	$t_stats_ip_to_country_ipv4 		= $mysqlPrefixSav . "stats_ip_to_country_ipv4";
	$t_stats_ip_to_country_ipv6 		= $mysqlPrefixSav . "stats_ip_to_country_ipv6";
	$t_stats_ip_to_country_geonames 	= $mysqlPrefixSav . "stats_ip_to_country_geonames";

	// Count number of IPv6 files
	$filenames = "";
	$dir = "./db_scripts/stats/country_to_ip_blocks/ipv6";
	$number_of_files = 0;
	if ($handle = opendir($dir)) {
		while (false !== ($file = readdir($handle))) {
			if ($file === '.') continue;
			if ($file === '..') continue;	
			$number_of_files = $number_of_files+1;
		}
	}

	// Counter
	if(file_exists("../../_cache/0005_ip_to_countries_ipv6_counter.dat")){
		$fh = fopen("../../_cache/0005_ip_to_countries_ipv6_counter.dat", "r");
		$file_counter = fread($fh, filesize("../../_cache/0005_ip_to_countries_ipv6_counter.dat"));
		fclose($fh);

		$file_counter = $file_counter+1;

		$fh = fopen("../../_cache/0005_ip_to_countries_ipv6_counter.dat", "w+") or die("can not open file");
		fwrite($fh, $file_counter);
		fclose($fh);
	}
	else{
		$file_counter = "0";
		$fh = fopen("../../_cache/0005_ip_to_countries_ipv6_counter.dat", "w+") or die("can not open file");
		fwrite($fh, $file_counter);
		fclose($fh);
	}

	echo"
	<div style=\"height: 10px;\"></div>
	
	<p>$file_counter / $number_of_files</p>
	";

	// File exists?
	if(file_exists("./db_scripts/stats/country_to_ip_blocks/ipv6/ipv6_insert_script_$file_counter.php")){
		// Delete from MySQL
		$result = mysqli_query($link, "DELETE FROM $t_admin_liquidbase WHERE liquidbase_module='stats' AND liquidbase_name='0005_ip_to_countries_ipv6.php'") or die(mysqli_error($link));


		include("./db_scripts/stats/country_to_ip_blocks/ipv6/ipv6_insert_script_$file_counter.php");
		

	}
	else{
		echo"<p>Finished!</p>";
	}
}


?>