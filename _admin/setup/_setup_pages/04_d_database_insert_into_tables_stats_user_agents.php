<?php

/*- Check if setup is run ------------------------------------------------------------ */
$server_name = $_SERVER['HTTP_HOST'];
$server_name = clean($server_name);
$setup_finished_file = "setup_finished_" . $server_name . ".php";
if(file_exists("../_data/$setup_finished_file")){
	echo"Setup is finished.";
	die;
}

// Mysql Setup
$mysql_config_file = "../_data/mysql_" . $server_name . ".php";
if(!(file_exists("$mysql_config_file"))){
	echo"Missing MySQL info.";
	die;
}


// MOVED


// Header
header("Location: index.php?page=05_site&language=$language");
exit;


?>

