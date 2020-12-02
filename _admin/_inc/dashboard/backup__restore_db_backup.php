<?php
session_start();
ini_set('arg_separator.output', '&amp;');
/**
*
* File: _restore_db_backup.php
* Version 1.0
* Date 11:45 16.05.2019
* Copyright (c) 2019 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/*- Functions ------------------------------------------------------------------------ */

function clean($value){
	$value = strtolower($value);


	// Norwegian letters
	$value = str_replace("&aelig;", "ae", "$value");
	$value = str_replace("&oslash;", "o", "$value");
	$value = str_replace("&aring;", "a", "$value");

	// Special
	$value = htmlspecialchars("$value");
	$value = htmlentities($value);


	// Signs
	$value = str_replace(" ", "_", "$value");
	$value = str_replace("!", "", "$value");
	$value = str_replace("(", "", "$value");
	$value = str_replace(")", "", "$value");
	$value = str_replace(".", "", "$value");
	$value = str_replace("/", "_", "$value");
	$value = str_replace("#", "_", "$value");
	$value = str_replace(",", "_", "$value");
	$value = str_replace("+", "_", "$value");
	$value = str_replace(":", "_", "$value");
	$value = str_replace(";", "", "$value");
	$value = str_replace("?", "", "$value");
	$value = str_replace(";", "_", "$value");
	$value = str_replace("’", "", "$value");
	$value = str_replace("'", "", "$value");
	$value = str_replace("%", "", "$value");
	
	// Special
	$value = str_replace("&#39;", "", "$value"); // Apostrof

	// Amperstand
	$value = str_replace("&", "", "$value");
	$value = str_replace("ampamp", "", "$value");

        return $value;
}
function quote_smart($link, $value){
	// Table: http://www.starr.net/is/type/htmlcodes.html

	// Norwegian characters
	$value = str_replace("æ","&aelig;","$value"); // &#230;
	$value = str_replace("ø","&oslash;","$value"); // &#248;
	$value = str_replace("å","&aring;","$value"); // &#229;
	$value = str_replace("Æ","&Aelig;","$value"); // &#198;
	$value = str_replace("Ø","&Oslash;","$value"); // &#216;
	$value = str_replace("Å",'&Aring;', "$value"); // &#197;

        // Stripslashes
        if (get_magic_quotes_gpc() && !is_null($value) ) {
                $value = stripslashes($value);
        }

        //Change decimal values from , to . if applicable
        if( is_numeric($value) && strpos($value,',') !== false ){
                $value = str_replace(',','.',$value);
        }
        if( is_null($value) ){
                $value = 'NULL';
        }
        // Quote if not integer or null
        elseif (!is_numeric($value)) {
                $value = "'" . mysqli_real_escape_string($link, $value) . "'";
        }

        return $value;
}



/*- MySQL ------------------------------------------------------------------------- */
$server_name = $_SERVER['HTTP_HOST'];
$server_name = clean($server_name);
$mysql_config_file = "config/mysql_" . $server_name . ".php";
if(file_exists("$mysql_config_file")){
	include("$mysql_config_file");
	$link = mysqli_connect($mysqlHostSav, $mysqlUserNameSav, $mysqlPasswordSav, $mysqlDatabaseNameSav);
	if (!$link) {
		echo "
		<div class=\"alert alert-danger\"><span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span><strong>MySQL connection error</strong>"; 
		echo PHP_EOL;
   		echo "<br />Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    		echo "<br />Debugging error: " . mysqli_connect_error() . PHP_EOL;
    		echo"
		</div>
		";
		die;
	}
}
else{
	echo"<p>Missing MySQL config file $mysql_config_file</p>\n";
	die;
}


/*- Variables ------------------------------------------------------------------------ */
if(isset($_GET['action'])) {
	$action = $_GET['action'];
	$action = strip_tags(stripslashes($action));
}
else{
	$action = "";
}
if(isset($_GET['table_no'])) {
	$table_no = $_GET['table_no'];
	$table_no = strip_tags(stripslashes($table_no));
}
else{
	$table_no = "";
}
if(isset($_GET['row_no'])) {
	$row_no = $_GET['row_no'];
	$row_no = strip_tags(stripslashes($row_no));
}
else{
	$row_no = "";
}

/*- Design ---------------------------------------------------------------------------- */
echo"<!DOCTYPE html>
<html lang=\"en\">
<head>
	<title>Restore database backup</title>
	<meta name=\"viewport\" content=\"width=device-width; initial-scale=1.0;\"/>
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UFT-8\" />
</head>
<body>

<!-- Header -->
	<header>
		<p>Restore database backup</p>
	</header>
<!-- //Header -->


<!-- Main -->
	<div id=\"main\">
		<!-- Page -->
		";
		if($action == ""){
			include("_tables.php");
			$tables_size = sizeof($table);
			echo"
			<p>This will restore database backup.</p>

			<p>
			<a href=\"_restore_db_backup.php?action=create_tables&amp;table_no=0\">Start</a>
			</p>
			";
		} // action == ""
		elseif($action == "create_tables"){
			include("_tables.php");
			$tables_size = sizeof($table);			
			
			if($table_no < $tables_size){
				echo"
				<h1>Create tables</h1>

				<table>
				 <tr>
				  <td style=\"padding-right: 5px;\">
					<p>Table no:</p>
				  </td>
				  <td>
					<p>$table_no of $tables_size</p>
				  </td>
				 </tr>
				 <tr>
				  <td style=\"padding-right: 5px;\">
					<p>Table name:</p>
				  </td>
				  <td>
					<p>$table[$table_no]</p>
				  </td>
				 </tr>
				</table>
				";
				
				// Include table setup file
				include("$table[$table_no].php");
				
				// Create table
				mysqli_query($link, "DROP TABLE IF EXISTS $table[$table_no]") or die(mysqli_error($link)); 
				mysqli_query($link, "$create_table_query") or die(mysqli_error($link)); 

				// Refresh
				$next_table_no = $table_no+1;
				echo"
				<meta http-equiv=\"refresh\" content=\"1;url=_restore_db_backup.php?action=create_tables&amp;table_no=$next_table_no\" />
				<p>
				<a href=\"_restore_db_backup.php?action=create_tables&amp;table_no=$next_table_no\">Next</a>
				</p>
				";
			}
			else{
				echo"
				<h1>Create tables completed</h1>
				<p>Completed with table creation. Now starting with inserting.</p>
				
				<meta http-equiv=\"refresh\" content=\"1;url=_restore_db_backup.php?action=restore_data&amp;table_no=0&amp;row_no=0\" />
				<p>
				<a href=\"_restore_db_backup.php?action=restore_data&amp;table_no=0&amp;row_no=0\">Start restoring</a>
				</p>
				";
			} // table size 
		} // action == create_tables
		elseif($action == "restore_data"){
			include("_tables.php");
			$tables_size = sizeof($table);			
			
			if($table_no < $tables_size){
				// Include table setup file
				include("$table[$table_no].php");
				

				echo"
				<h1>Restore data</h1>

				<table>
				 <tr>
				  <td style=\"padding-right: 5px;\">
					<p>Table no:</p>
				  </td>
				  <td>
					<p>$table_no of $tables_size</p>
				  </td>
				 </tr>
				 <tr>
				  <td style=\"padding-right: 5px;\">
					<p>Table name:</p>
				  </td>
				  <td>
					<p>$table[$table_no]</p>
				  </td>
				 </tr>
				 <tr>
				  <td style=\"padding-right: 5px;\">
					<p>Rows:</p>
				  </td>
				  <td>
					<p>$row_no of $table_number_of_rows ";

					$percentage = round(($row_no / $table_number_of_rows)*100, 0);

					echo" ($percentage %)</p>
				  </td>
				 </tr>
				</table>
				";

				// Columns
				$columns_size = sizeof($table_column_types);

				// Insert headline
				$insert_query = "INSERT INTO $table[$table_no]
(";
				for($x=0;$x<$columns_size;$x++){
					if($x != 0){
						$insert_query = $insert_query . ", ";
					}
					$insert_query = $insert_query . "$table_column_names[$x]";
				}
				$insert_query = $insert_query . ") 
VALUES";

				// Read data file
				$content_file = $table[$table_no] . ".txt";
				if(file_exists("$content_file")){
					$fh = fopen($content_file, "r");
					$data = fread($fh, filesize($content_file));
					fclose($fh);

					$data_rows = explode("{start}", $data);
					$data_rows_size = sizeof($data_rows);
			
					$stop = $row_no+100;

					$for_rows_counter = 0;

					for($x=$row_no;$x<$stop;$x++){
						if(isset($data_rows[$x])){
							$temp = explode("|", $data_rows[$x]);
	
							if(isset($temp[1])){
								// echo"<p>Processing line $x<br />\n";
	
								if($for_rows_counter != 0){
									$insert_query = $insert_query . ",";
								}
								$insert_query = $insert_query . "
(";
								for($y=1;$y<$columns_size+1;$y++){
									if(isset($temp[$y])){
										$inp_column_mysql = quote_smart($link, $temp[$y]);
										if($y != 1){
											$insert_query = $insert_query . ", ";	
										}
										$insert_query = $insert_query . $inp_column_mysql;
										// echo"$temp[$y] &middot;\n";
									} // isset
								} // columns
								$insert_query = $insert_query . ")";

								// echo"					</p>\n";
	
								// Increment
								$for_rows_counter++;
							} // isset temp[1] (some data in row)
						} // isset data_rows[x]
					} // rows
				} // file exists
				else{
					// File doesnt exist, we continue to next db
					$data_rows_size = 0;
				}

				// Refresh
				// -> Are we going to go futher?
				if($row_no+100 > $data_rows_size){
					$next_table_no = $table_no+1;

					if($table_no < $tables_size){
						echo"Finished with this table

						<meta http-equiv=\"refresh\" content=\"1;url=_restore_db_backup.php?action=restore_data&amp;table_no=$next_table_no&amp;row_no=0\" />
						<p>
						<a href=\"_restore_db_backup.php?action=restore_data&amp;table_no=$next_table_no&amp;row_no=0\">Next table</a>
						</p>
						";
					}
					else{
						echo"
						<p>Finished with restoring backup!</p>
						";
					}
				}
				else{
					$next_row_no = $row_no+100;
					echo"
					<p>
					Next 100 rows
					</p>

					<meta http-equiv=\"refresh\" content=\"1;url=_restore_db_backup.php?action=restore_data&amp;table_no=$table_no&amp;row_no=$next_row_no\" />

					<p>
					<a href=\"_restore_db_backup.php?action=restore_data&amp;table_no=$next_row_no&amp;row_no=$next_row_no\">Next 100 rows</a>
					</p>
					";
				}

				// Insert
				echo"
				<pre>$insert_query</pre>
				";
				mysqli_query($link, "$insert_query") or die(mysqli_error($link)); 				

			}
			else{
				echo"
				<h1>Restore data completed</h1>
				<p>Completed with data restoring.</p>
				";
			} // table size 
		} // action == restore_data
		echo"
		<!-- Page -->
	</div>
<!-- //Main -->

</body>
</html>";


?>