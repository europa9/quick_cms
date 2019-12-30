<?php
if(isset($_SESSION['admin_user_id'])){
	
	$t_stats_ip_to_country_ipv4 		= $mysqlPrefixSav . "stats_ip_to_country_ipv4";
	$t_stats_ip_to_country_ipv6 		= $mysqlPrefixSav . "stats_ip_to_country_ipv6";
	$t_stats_ip_to_country_geonames 	= $mysqlPrefixSav . "stats_ip_to_country_geonames";


	/*- Delete invalid ------------------------------------------ */


	/*- Blocks --------------------------------------------------- */
	$number_of_block_files = "94";
	if($counter != $number_of_block_files+1){
		echo"
		<p>Delete from mysql, block $counter of $number_of_block_files</p>
		<p>DELETE FROM $t_admin_liquidbase WHERE liquidbase_module='stats' AND liquidbase_name='0006_ip_to_countries_ipblocks_ipv6.php'</p>
		";
		$result_delete = mysqli_query($link, "DELETE FROM $t_admin_liquidbase WHERE liquidbase_module='stats' AND liquidbase_name='0006_ip_to_countries_ipblocks_ipv6.php'");
	}
	else{
		// We are finished
		$counter = -1;
	}



	// Increase counter
	$counter++;

}


?>