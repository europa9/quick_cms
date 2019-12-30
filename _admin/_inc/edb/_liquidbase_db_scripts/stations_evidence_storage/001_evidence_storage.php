<?php
/**
*
* File: _admin/_inc/edb/_liquibase/evidence_storage/001_evidence_storage.php
* Version 1.0.0
* Date 21:19 28.08.2019
* Copyright (c) 2019 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}

/*- Tables ---------------------------------------------------------------------------- */
$t_edb_evidence_storage_locations 	= $mysqlPrefixSav . "edb_evidence_storage_locations";
$t_edb_evidence_storage_shelves		= $mysqlPrefixSav . "edb_evidence_storage_shelves";


echo"


<!-- edb_evidence_storage_locations-->
";

$query = "SELECT * FROM $t_edb_evidence_storage_locations LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_stations_index: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_evidence_storage_locations(
	  storage_location_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(storage_location_id), 
	   storage_location_title VARCHAR(200),
	   storage_location_abbr VARCHAR(200),
	   storage_location_station_id INT,
	   storage_location_station_title VARCHAR(200)
	   )")
	   or die(mysqli_error());

	$query = "SELECT station_id, station_title, station_title_clean, station_number_of_cases_now FROM $t_edb_stations_index";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_station_id, $get_station_title, $get_station_title_clean, $get_station_number_of_cases_now) = $row;

		$inp_storage_location_title_a = "$get_station_title beslagslager";
		$inp_storage_location_title_a_mysql = quote_smart($link, $inp_storage_location_title_a);

		$inp_storage_location_abbr_a = "";
		$words = explode(" ", $inp_storage_location_title_a);
		foreach ($words as $w) {
			$inp_storage_location_abbr_a .= $w[0];
		}
		$inp_storage_location_abbr_a_mysql = quote_smart($link, $inp_storage_location_abbr_a);

		$inp_storage_location_title_b = "$get_station_title Digitalt Politiarbeid";
		$inp_storage_location_title_b_mysql = quote_smart($link, $inp_storage_location_title_b);

		$inp_storage_location_abbr_b = "";
		$words = explode(" ", $inp_storage_location_title_b);
		foreach ($words as $w) {
			$inp_storage_location_abbr_b .= $w[0];
		}
		$inp_storage_location_abbr_b_mysql = quote_smart($link, $inp_storage_location_abbr_b);


		$inp_station_title_mysql = quote_smart($link, $get_station_title);

		mysqli_query($link, "INSERT INTO $t_edb_evidence_storage_locations
		(storage_location_id, storage_location_title, storage_location_abbr, storage_location_station_id, storage_location_station_title) 
		VALUES 
		(NULL, $inp_storage_location_title_a_mysql, $inp_storage_location_abbr_a_mysql, $get_station_id, $inp_station_title_mysql),
		(NULL, $inp_storage_location_title_b_mysql, $inp_storage_location_abbr_b_mysql, $get_station_id, $inp_station_title_mysql)
		") or die(mysqli_error($link));
	}
}
echo"
<!-- //edb_evidence_storage_locations-->


<!-- edb_evidence_storage_shelves -->
";

$query = "SELECT * FROM $t_edb_evidence_storage_shelves LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_evidence_storage_shelves: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_evidence_storage_shelves (
	  shelf_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(shelf_id), 
	   shelf_first_letter VARCHAR(200),
	   shelf_number VARCHAR(200),
	   shelf_full_name VARCHAR(200),
	   shelf_barcode VARCHAR(200),
	   shelf_station_id INT, 
	   shelf_station_title VARCHAR(200),
	   shelf_storage_location_id INT, 
	   shelf_storage_location_title VARCHAR(200),
	   shelf_storage_location_abbr VARCHAR(200),
	   shelf_last_in_date DATE, 
	   shelf_last_in_ddmmyy VARCHAR(200),
	   shelf_last_in_time VARCHAR(200),
	   shelf_last_out_date DATE, 
	   shelf_last_out_ddmmyy VARCHAR(200),
	   shelf_last_out_time VARCHAR(200))")
	   or die(mysqli_error());	

	$query = "SELECT storage_location_id, storage_location_title, storage_location_abbr, storage_location_station_id, storage_location_station_title FROM $t_edb_evidence_storage_locations";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_storage_location_id, $get_storage_location_title, $get_storage_location_abbr, $get_storage_location_station_id, $get_storage_location_station_title) = $row;

	

		$inp_station_title_mysql = quote_smart($link, $get_storage_location_station_title);
		$inp_storage_location_title_mysql = quote_smart($link, $get_storage_location_title);
		$inp_storage_location_abbr_mysql = quote_smart($link, $get_storage_location_abbr);

		$alpabeth = array("A", "B", "C", "D", "E", "F", "G");
		for($x=0;$x<sizeof($alpabeth);$x++){

			for($y=1;$y<6;$y++){
				$inp_name = $alpabeth[$x] . "$y";
	
				// Barcode
				$characters = '0123456789';
				$charactersLength = strlen($characters);
				$inp_barcode = '';
				for ($i = 0; $i < 13; $i++) {
					$inp_barcode .= $characters[rand(0, $charactersLength - 1)];
				}
				

				mysqli_query($link, "INSERT INTO $t_edb_evidence_storage_shelves 
				(shelf_id, shelf_first_letter, shelf_number, shelf_full_name, shelf_barcode, shelf_station_id, shelf_station_title, shelf_storage_location_id, shelf_storage_location_title, shelf_storage_location_abbr) 
				VALUES 
				(NULL, '$alpabeth[$x]', '$y', '$inp_name', '$inp_barcode', $get_storage_location_station_id, $inp_station_title_mysql, $get_storage_location_id, $inp_storage_location_title_mysql, $inp_storage_location_abbr_mysql)
				") or die(mysqli_error($link));
			}
		}
	}

}
echo"
<!-- //edb_evidence_storage_shelves -->




";
?>