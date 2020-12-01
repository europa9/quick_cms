<?php

/*- Check if setup is run ------------------------------------------------------------ */
$server_name = $_SERVER['HTTP_HOST'];
$server_name = clean($server_name);
$setup_finished_file = "setup_finished_" . $server_name . ".php";
if(file_exists("../_data/$setup_finished_file")){
	echo"Setup is finished.";
	die;
}

if($action == "test_connection"){

	// MySQL
	$inp_mysql_host = $_POST['inp_mysql_host'];
	$inp_mysql_host = output_html($inp_mysql_host);

	$inp_mysql_user_name = $_POST['inp_mysql_user_name'];
	$inp_mysql_user_name = output_html($inp_mysql_user_name);

	$inp_mysql_password = $_POST['inp_mysql_password'];
	$inp_mysql_password = output_html($inp_mysql_password);
	$inp_mysql_password = str_replace("&amp;", "&", $inp_mysql_password);
	$inp_mysql_password = str_replace("&lt;", "<", $inp_mysql_password);
	$inp_mysql_password = str_replace("&gt;", ">", $inp_mysql_password);

	$inp_mysql_database_name = $_POST['inp_mysql_database_name'];
	$inp_mysql_database_name = output_html($inp_mysql_database_name);

	$inp_mysql_prefix = $_POST['inp_mysql_prefix'];
	$inp_mysql_prefix = output_html($inp_mysql_prefix);
		
	// Try connection
	$link = @mysqli_connect($inp_mysql_host, $inp_mysql_user_name, $inp_mysql_password, $inp_mysql_database_name);
	if (!$link) {
		$error = mysqli_connect_error();
		$error_no = mysqli_connect_error() . PHP_EOL;
		$error_or = mysqli_connect_error() . PHP_EOL;
		$url = "index.php?page=04_a_database&language=$language&inp_mysql_host=$inp_mysql_host&inp_mysql_user_name=$inp_mysql_user_name&inp_mysql_database_name=$inp_mysql_database_name&inp_mysql_prefix=$inp_mysql_prefix&ft=error&fm=$error&error_no=$error_no&error_or=$error_or";
		echo"
		<h1>MySQL Connection failed</h1>
		<meta http-equiv=refresh content=\"1; url=$url\">";
		exit;
	}
	else{
		// Write DB file
		$update_file="<?php
\$mysqlHostSav   	= \"$inp_mysql_host\";
\$mysqlUserNameSav   	= \"$inp_mysql_user_name\";
\$mysqlPasswordSav	= \"$inp_mysql_password\";
\$mysqlDatabaseNameSav 	= \"$inp_mysql_database_name\";
\$mysqlPrefixSav 	= \"$inp_mysql_prefix\";
?>";
		$fh = fopen($mysql_config_file, "w+") or die("can not open file");
		fwrite($fh, $update_file);
		fclose($fh);
	
		$url = "index.php?page=04_b_database_setup_tables&language=$language&process=1";
		header("Location: $url");
		exit;
	}
}

echo"
<h1>$l_database</h1>


<!-- Focus -->
	<script>
	\$(document).ready(function(){
		\$('[name=\"inp_mysql_host\"]').focus();
	});
	</script>
<!-- //Focus -->


<!-- Database form -->
";
if($action == ""){
	// Get variables
	if(isset($_GET['inp_mysql_host'])){
		$inp_mysql_host = $_GET['inp_mysql_host'];
		$inp_mysql_host = output_html($inp_mysql_host);
	}
	if(isset($_GET['inp_mysql_user_name'])){
		$inp_mysql_user_name = $_GET['inp_mysql_user_name'];
		$inp_mysql_user_name = output_html($inp_mysql_user_name);
	}
	if(isset($_GET['inp_mysql_password'])){
		$inp_mysql_password = $_GET['inp_mysql_password'];
		$inp_mysql_password = output_html($inp_mysql_password);
	}
	if(isset($_GET['inp_mysql_database_name'])){
		$inp_mysql_database_name = $_GET['inp_mysql_database_name'];
		$inp_mysql_database_name = output_html($inp_mysql_database_name);
	}
	if(isset($_GET['inp_mysql_prefix'])){
		$inp_mysql_prefix = $_GET['inp_mysql_prefix'];
		$inp_mysql_prefix = output_html($inp_mysql_prefix);
	}
	
	echo"
	<form method=\"post\" action=\"index.php?page=04_a_database&amp;language=$language&amp;action=test_connection&amp;process=1\" enctype=\"multipart/form-data\">

	<!-- Error -->
		";
		if(isset($ft) && isset($fm)){
			echo"<div class=\"error\"><p>$fm</p>";
			if(isset($_GET['error_no'])){
				$error_no = $_GET['error_no'];
				$error_no = output_html($error_no);
				echo"<p>$error_no</p>";
			}
			if(isset($_GET['error_or'])){
				$error_or = $_GET['error_or'];
				$error_or = output_html($error_or);
				echo"<p>$error_or</p>";
			}
			echo"</div>";
		}
		echo"
	<!-- //Error -->

	<p><b>$l_host:</b><br />
	<input type=\"text\" name=\"inp_mysql_host\" value=\""; if(isset($inp_mysql_host)){ echo"$inp_mysql_host"; } 
	else{ 
		$server_name = $_SERVER['HTTP_HOST'];
		$server_name = output_html($server_name);
		echo"$server_name"; 
	} 
	echo"\" size=\"35\" tabindex=\"1\" /></p>

	<p><b>$l_username:</b><br />
	<input type=\"text\" name=\"inp_mysql_user_name\" value=\""; if(isset($inp_mysql_user_name)){ echo"$inp_mysql_user_name"; } 
	else{
		if($server_name == "localhost"){
			echo"root";
		}
	}
	echo"\" size=\"35\" tabindex=\"2\" /></p>

	<p><b>$l_password:</b><br />
	<input type=\"text\" name=\"inp_mysql_password\" value=\""; if(isset($inp_mysql_password)){ echo"$inp_mysql_password"; } else{ echo""; } echo"\" size=\"35\" tabindex=\"3\" /></p>

	<p><b>$l_database_name:</b><br />
	<input type=\"text\" name=\"inp_mysql_database_name\" value=\""; if(isset($inp_mysql_database_name)){ echo"$inp_mysql_database_name"; }
	else{
		if($server_name == "localhost"){
			echo"quick_cms";
		}
	}
	echo"\" size=\"35\" tabindex=\"4\" /></p>

	<p><b>$l_prefix:</b><br />
	<input type=\"text\" name=\"inp_mysql_prefix\" value=\""; if(isset($inp_mysql_prefix)){ echo"$inp_mysql_prefix"; } else{ echo"quick_"; } echo"\" size=\"35\" tabindex=\"5\" /></p>

	
	<p>
	<input type=\"submit\" value=\"$l_test_connection\" class=\"submit\" />
	</p>

	</form>

	";
}

echo"
<!-- //Database form -->
";
?>

