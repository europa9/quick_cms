<?php
/**
*
* File: _admin/_inc/media/statistics_ipv6_generate_insert_script.php
* Version 2.0.0
* Date 18:16 28.04.2019
* Copyright (c) 2008-2019 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}

/*- Variables -------------------------------------------------------------------------- */
if(isset($_GET['start'])) {
	$start = $_GET['start'];
	$start = strip_tags(stripslashes($start));
	if(!(is_numeric($start))){
		echo"Start is not numeric";
		die;
	}
}
else{
	$start = 0;
}
if(isset($_GET['file_counter'])) {
	$file_counter = $_GET['file_counter'];
	$file_counter = strip_tags(stripslashes($file_counter));
	if(!(is_numeric($file_counter))){
		echo"File_counter is not numeric";
		die;
	}
}
else{
	$file_counter = 0;
}

if($action == ""){
	echo"
	<h1>IPv6 Generate insert script</h1>

	<!-- Info -->
		<table>
		 <tr>
		  <td style=\"padding-right: 10px;\">
			<span>Counter:</span>
		  </td>
		  <td>
			<span>$file_counter</span>
		  </td>
		 </tr>
		 <tr>
		  <td style=\"padding-right: 10px;\">
			<span>Start:</span>
		  </td>
		  <td>
			<span>$start</span>
		  </td>
		 </tr>
		</table>
	<!-- //Info -->

	";

	// Start
	$inp_start_file = "<?php
";
$fh = fopen("../_cache/ipv6_insert_script_$file_counter.php", "w+") or die("can not open file");
fwrite($fh, $inp_start_file);
fclose($fh);


	// Header and footer
	$inp_header = "

mysqli_query(\$link, \"INSERT INTO \$t_stats_ip_to_country_ipv6 
(ip_id, ip_network, ip_from, ip_from_dec_a, ip_from_dec_b, ip_from_dec_c, ip_from_dec_d, ip_from_dec_e, ip_from_dec_f, ip_from_dec_g, ip_from_dec_h, ip_from_dec_numeric, ip_to, ip_to_dec_a, ip_to_dec_b, ip_to_dec_c, ip_to_dec_d, ip_to_dec_e, ip_to_dec_f, ip_to_dec_g, ip_to_dec_h, ip_to_dec_numeric, ip_geoname_id, ip_registered_country_geoname_id, ip_represented_country_geoname_id, ip_is_anonymous_proxy, ip_is_satellite_provider) 
VALUES 
";
	
	$inp_footer = "\")
or die(mysqli_error(\$link));";



	$x = 0;
	$count_inserts = 0;
	$query = "SELECT ip_id, ip_network, ip_from, ip_from_dec_a, ip_from_dec_b, ip_from_dec_c, ip_from_dec_d, ip_from_dec_e, ip_from_dec_f, ip_from_dec_g, ip_from_dec_h, ip_from_dec_numeric, ip_to, ip_to_dec_a, ip_to_dec_b, ip_to_dec_c, ip_to_dec_d, ip_to_dec_e, ip_to_dec_f, ip_to_dec_g, ip_to_dec_h, ip_to_dec_numeric, ip_geoname_id, ip_registered_country_geoname_id, ip_represented_country_geoname_id, ip_is_anonymous_proxy, ip_is_satellite_provider FROM $t_stats_ip_to_country_ipv6 LIMIT $start,1000";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_ip_id, $get_ip_network, $get_ip_from, $get_ip_from_dec_a, $get_ip_from_dec_b, $get_ip_from_dec_c, $get_ip_from_dec_d, $get_ip_from_dec_e, $get_ip_from_dec_f, $get_ip_from_dec_g, $get_ip_from_dec_h, $get_ip_from_dec_numeric, $get_ip_to, $get_ip_to_dec_a, $get_ip_to_dec_b, $get_ip_to_dec_c, $get_ip_to_dec_d, $get_ip_to_dec_e, $get_ip_to_dec_f, $get_ip_to_dec_g, $get_ip_to_dec_h, $get_ip_to_dec_numeric, $get_ip_geoname_id, $get_ip_registered_country_geoname_id, $get_ip_represented_country_geoname_id, $get_ip_is_anonymous_proxy, $get_ip_is_satellite_provider) = $row;


		// Header
		if($x == 0){
			$fh = fopen("../_cache/ipv6_insert_script_$file_counter.php", "a+") or die("can not open file");
			fwrite($fh, $inp_header);
			fclose($fh);
		}

		// Body
		$inp_ip_id_mysql = quote_smart($link, $get_ip_id);
		$inp_ip_network_mysql = quote_smart($link, $get_ip_network);
		$inp_ip_from_mysql = quote_smart($link, $get_ip_from);
		$inp_ip_from_dec_a_mysql = quote_smart($link, $get_ip_from_dec_a);
		$inp_ip_from_dec_b_mysql = quote_smart($link, $get_ip_from_dec_b);
		$inp_ip_from_dec_c_mysql = quote_smart($link, $get_ip_from_dec_c);
		$inp_ip_from_dec_d_mysql = quote_smart($link, $get_ip_from_dec_d);
		$inp_ip_from_dec_e_mysql = quote_smart($link, $get_ip_from_dec_e);
		$inp_ip_from_dec_f_mysql = quote_smart($link, $get_ip_from_dec_f);
		$inp_ip_from_dec_g_mysql = quote_smart($link, $get_ip_from_dec_g);
		$inp_ip_from_dec_h_mysql = quote_smart($link, $get_ip_from_dec_h);
		$inp_ip_from_dec_numeric_mysql = quote_smart($link, $get_ip_from_dec_numeric);

		$inp_ip_to_mysql = quote_smart($link, $get_ip_to);
		$inp_ip_to_dec_a_mysql = quote_smart($link, $get_ip_to_dec_a);
		$inp_ip_to_dec_b_mysql = quote_smart($link, $get_ip_to_dec_b);
		$inp_ip_to_dec_c_mysql = quote_smart($link, $get_ip_to_dec_c);
		$inp_ip_to_dec_d_mysql = quote_smart($link, $get_ip_to_dec_d);
		$inp_ip_to_dec_e_mysql = quote_smart($link, $get_ip_to_dec_e);
		$inp_ip_to_dec_f_mysql = quote_smart($link, $get_ip_to_dec_f);
		$inp_ip_to_dec_g_mysql = quote_smart($link, $get_ip_to_dec_g);
		$inp_ip_to_dec_h_mysql = quote_smart($link, $get_ip_to_dec_h);
		$inp_ip_to_dec_numeric_mysql = quote_smart($link, $get_ip_to_dec_numeric);

		$inp_ip_geoname_id_mysql = quote_smart($link, $get_ip_geoname_id);
		$inp_ip_registered_country_geoname_id_mysql = quote_smart($link, $get_ip_registered_country_geoname_id);
		$inp_ip_represented_country_geoname_id_mysql = quote_smart($link, $get_ip_represented_country_geoname_id);
		$inp_ip_is_anonymous_proxy_mysql = quote_smart($link, $get_ip_is_anonymous_proxy);
		$inp_ip_is_satellite_provider_mysql = quote_smart($link, $get_ip_is_satellite_provider);


		$inp_body = "";
		if($x != 0){
			$inp_body = ",
";	
		}
		$inp_body = $inp_body . "(NULL, $inp_ip_network_mysql, $inp_ip_from_mysql, $inp_ip_from_dec_a_mysql, $inp_ip_from_dec_b_mysql, $inp_ip_from_dec_c_mysql, $inp_ip_from_dec_d_mysql, $inp_ip_from_dec_e_mysql, $inp_ip_from_dec_f_mysql, $inp_ip_from_dec_g_mysql, $inp_ip_from_dec_h_mysql, $inp_ip_from_dec_numeric_mysql, $inp_ip_to_mysql, $inp_ip_to_dec_a_mysql, $inp_ip_to_dec_b_mysql, $inp_ip_to_dec_c_mysql, $inp_ip_to_dec_d_mysql, $inp_ip_to_dec_e_mysql, $inp_ip_to_dec_f_mysql, $inp_ip_to_dec_g_mysql, $inp_ip_to_dec_h_mysql, $inp_ip_to_dec_numeric_mysql, $inp_ip_geoname_id_mysql, $inp_ip_registered_country_geoname_id_mysql, $inp_ip_represented_country_geoname_id_mysql, $inp_ip_is_anonymous_proxy_mysql, $inp_ip_is_satellite_provider_mysql)";

		$fh = fopen("../_cache/ipv6_insert_script_$file_counter.php", "a+") or die("can not open file");
		fwrite($fh, $inp_body);
		fclose($fh);

		// Footer
		if($x == 50){
			$fh = fopen("../_cache/ipv6_insert_script_$file_counter.php", "a+") or die("can not open file");
			fwrite($fh, $inp_footer);
			fclose($fh);

			$x = -1;
		}
		$x++;

		$count_inserts = $count_inserts+1;
	} // while
	
	// Footer again?
	if($x != 0){
		$fh = fopen("../_cache/ipv6_insert_script_$file_counter.php", "a+") or die("can not open file");
		fwrite($fh, $inp_footer);
		fclose($fh);
	}

	// Stop file
	$inp_stop_file = "

?>";
$fh = fopen("../_cache/ipv6_insert_script_$file_counter.php", "a+") or die("can not open file");
fwrite($fh, $inp_stop_file);
fclose($fh);


	// Continue or finish?
	if($count_inserts == 0){
		echo"<p>Finished!</p>

		<p>
		You can download the ipv6 insert scripts by logging into ftp and go into the folder
		_cache. The files are stored as 
		<a href=\"../_cache/ipv6_insert_script_0.php\">../_cache/ipv6_insert_script_0.php</a>
		to
		<a href=\"../_cache/ipv6_insert_script_$file_counter.php\">../_cache/ipv6_insert_script_$file_counter.php</a>.</p>";
	}
	else{

		// Next
		$start = $start+1000;
		$file_counter = $file_counter+1;
		$rand = rand(1,4);
		echo"
		<p><img src=\"_design/gfx/loading_22.gif\" alt=\"loading_22.gif\" /></p>
		<meta http-equiv=\"refresh\" content=\"$rand;url=index.php?open=dashboard&amp;page=statistics_ipv6_generate_insert_script&amp;editor_language=$editor_language&amp;l=$l&amp;start=$start&amp;file_counter=$file_counter\" />
		";		
	}
} 

?>