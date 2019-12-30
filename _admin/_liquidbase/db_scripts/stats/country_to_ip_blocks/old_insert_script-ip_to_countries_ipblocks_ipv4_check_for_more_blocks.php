<?php
if(isset($_SESSION['admin_user_id'])){
	
	$t_stats_ip_to_country_ipv4 		= $mysqlPrefixSav . "stats_ip_to_country_ipv4";
	$t_stats_ip_to_country_ipv6 		= $mysqlPrefixSav . "stats_ip_to_country_ipv6";
	$t_stats_ip_to_country_geonames 	= $mysqlPrefixSav . "stats_ip_to_country_geonames";


	/*- Delete invalid ------------------------------------------ */
	$result_delete = mysqli_query($link, "DELETE FROM $t_stats_ip_to_country_ipv4 WHERE ip_registered_country_geoname_id=''");


	/*- Blocks --------------------------------------------------- */
	$number_of_block_files = "329";
	if($counter != $number_of_block_files+1){
		echo"
		<p>Delete from mysql, block $counter of $number_of_block_files</p>
		<pre>DELETE FROM $t_admin_liquidbase WHERE liquidbase_module='stats' AND liquidbase_name='0004_ip_to_countries_ipblocks_ipv4.php'</pre>
		";
		$result_delete = mysqli_query($link, "DELETE FROM $t_admin_liquidbase WHERE liquidbase_module='stats' AND liquidbase_name='0004_ip_to_countries_ipblocks_ipv4.php'");
	}
	else{
		// We are finished
		$counter = -1;
	}



	// Increase counter
	$counter++;

}


?>