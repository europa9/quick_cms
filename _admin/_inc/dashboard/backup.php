<?php
/**
*
* File: _admin/_inc/backup.php
* Version 1.0.1
* Date 11:46 28-Jul-18
* Copyright (c) 2008-2018 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}


/*- Directories ------------------------------------------------------------------------ */
if(!(is_dir("_data/backup"))){
	mkdir("_data/backup");
}


/*- Tables ----------------------------------------------------------------------------- */
$t_backup_web_cache 		= $mysqlPrefixSav . "backup_web_cache";
$t_backup_web_root_dir_content	= $mysqlPrefixSav . "backup_web_root_dir_content";

/*- Variables -------------------------------------------------------------------------- */
if(isset($_GET['mode'])) {
	$mode = $_GET['mode'];
	$mode = strip_tags(stripslashes($mode));
}
else{
	$mode = "";
}
if(isset($_GET['backup_date'])) {
	$backup_date = $_GET['backup_date'];
	$backup_date = strip_tags(stripslashes($backup_date));
}
else{
	$backup_date = "";
}
if(isset($_GET['backup_secret'])) {
	$backup_secret = $_GET['backup_secret'];
	$backup_secret = strip_tags(stripslashes($backup_secret));
}
else{
	$backup_secret = "";
}


/*- Functions -------------------------------------------------------------------------- */
	function delete_directory($dirname) {
		if (is_dir($dirname))
			$dir_handle = opendir($dirname);
			if (!$dir_handle)
				return false;
			while($file = readdir($dir_handle)) {
				if ($file != "." && $file != "..") {
					if (!is_dir($dirname."/".$file))
					unlink($dirname."/".$file);
               		else
                     		delete_directory($dirname.'/'.$file);
           		}
     		}
     		closedir($dir_handle);
     		rmdir($dirname);
    		return true;
	}


if($process != 1){

	echo"
	<h1>Backup</h1>
	
	<!-- Tabs -->
		<div class=\"tabs\">
			<ul>
				<li><a href=\"index.php?open=$open&amp;page=$page&amp;l=$l&amp;editor_language=$editor_language\""; if($action == ""){ echo" class=\"active\""; } echo">Backup</a></li>
			</ul>
		</div>
		<div class=\"clear\"></div>
	<!-- //Tabs -->

	<!-- Feedback -->
		";
		if($ft != ""){
			if($fm == "changes_saved"){
				$fm = "$l_changes_saved";
			}
			else{
				$fm = ucfirst($fm);
			}
			echo"<div class=\"$ft\"><span>$fm</span></div>";
		}
		echo"	
	<!-- //Feedback -->
	";
}
if($action == ""){

	echo"
	<h2>Backup</h2>
	
	<!-- Backups -->

		<p>
		<a href=\"index.php?open=$open&amp;page=$page&amp;action=new_backup&amp;l=$l&amp;editor_language=$editor_language\" class=\"btn\">New backup</a>
		</p>

	<!-- //Backups -->


	<!-- Clean up -->

	";
	// Remove db files, we dont need them anymore as they are zipped
	//delete_directory("_data/backup/$backup_dir_name/");
	echo"
	<!-- //Clean up -->



	<!-- Backups -->

		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\">
			<span><b>Database</b></span>
		   </td>
		   <th scope=\"col\">
			<span><b>Web</b></span>
		   </td>
		   <th scope=\"col\">
			<span><b>Actions</b></span>
		   </td>
		  </tr>
		 </thead>
	";
	$filenames = "";
	$previous_backup_zip_db_file = "";
	$dir = "_data/backup/";
	if ($handle = opendir($dir)) {
		while (false !== ($file = readdir($handle))) {
			if ($file === '.') continue;
			if ($file === '..') continue;

			// Date and secret
			$name_array = explode("_", $file);
			$date = $name_array[0];
			$secret = $name_array[1];

			// Dir?
			if(is_dir("$dir$file")){
				echo"
				 <tr>
				  <td class=\"danger\">
					<span>Cache $file</span>
				  </td>
				  <td class=\"danger\">
				  </td>
				  <td class=\"danger\">
					<span><a href=\"index.php?open=$open&amp;page=$page&amp;action=delete_cache&amp;backup_date=$date&amp;backup_secret=$secret\">Delete cache dir $file</a></span>
				  </td>
				 </tr>
				";
			}
			else{
				// Files
				$backup_zip_db_file = $date. "_" . $secret . "_db.zip";
				$backup_zip_web_file = $date. "_" . $secret . "_web.zip";


				// We only want to list files when they end with _db.zip
				$name_check_for_db_zip = substr($file, -7);

				// Already printed this line?
				// if($previous_backup_zip_db_file != "$backup_zip_db_file"){
				if($name_check_for_db_zip == "_db.zip"){
					// Style
					if(isset($style) && $style == ""){
						$style = "odd";
					}
					else{
						$style = "";
					}


					echo"
					 <tr>
					  <td class=\"$style\">
						<table>
						 <tr>
						  <td style=\"padding-right: 6px;\">
							<a href=\"_data/backup/$backup_zip_db_file\"><img src=\"_inc/dashboard/_img/icon_db.png\" alt=\"icon_db.png\" /></a>
						  </td>
						  <td>
							<a href=\"_data/backup/$backup_zip_db_file\">$backup_zip_db_file</a>
						  </td>
						 </tr>
						</table>
					  </td>
					  <td class=\"$style\">
						<table>
						 <tr>
						  <td style=\"padding-right: 6px;\">
							<a href=\"_data/backup/$backup_zip_web_file\"><img src=\"_inc/dashboard/_img/icon_website.png\" alt=\"icon_website.png\" /></a>
						  </td>
						  <td>
							<a href=\"_data/backup/$backup_zip_web_file\">$backup_zip_web_file</a>
						  </td>
						 </tr>
						</table>
					  </td>
					  <td class=\"$style\">
						<span><a href=\"index.php?open=$open&amp;page=$page&amp;action=delete_backup&amp;backup_date=$date&amp;backup_secret=$secret\">Delete</a></span>
					  </td>
					 </tr>
					";

				}
			} // is file
		} // while
	} // if open
	echo"
		</table>

	<!-- //Backups -->
	";
}
elseif($action == "new_backup"){
	// Truncate cache tables
	$result = mysqli_query($link, "TRUNCATE TABLE $t_backup_web_root_dir_content") or die(mysqli_error($link));
	$result = mysqli_query($link, "TRUNCATE TABLE $t_backup_web_cache") or die(mysqli_error($link));
	
	// Delete cache
	delete_directory("../_cache");
	if(!(is_dir("../_cache"))){
		mkdir("../_cache");
	}

	// Create secret
	$alphabet = 'abcdefghijklmnopqrstuvwxyz';
	$pass = array(); //remember to declare $pass as an array
	$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	for ($i = 0; $i < 8; $i++) {
		$n = rand(0, $alphaLength);
		$pass[] = $alphabet[$n];
	}

	$backup_secret = implode($pass); 



	$datetime = date("y-m-d");
	$backup_dir_name = "$datetime" . "_" . $backup_secret;
	if(!(is_dir("_data/backup/$backup_dir_name"))){
		mkdir("_data/backup/$backup_dir_name");
	}
	if(!(is_dir("_data/backup/$backup_dir_name/mysql"))){
		mkdir("_data/backup/$backup_dir_name/mysql");
	}


	echo"
	
	<h2><img src=\"_design/gfx/loading_22.gif\" alt=\"loading_22.gif\" style=\"float: left;padding-right: 6px;\" /> New Backup - Listing tables</h2>

	<div class=\"clear\"></div>

	";

	$my_prefix_lenght = strlen($mysqlPrefixSav);



	echo"
	<p>Prefix: $mysqlPrefixSav<br />
	Lenght: $my_prefix_lenght</p>
		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\">
			<span><b>Table name</b></span>
		   </td>
		   <th scope=\"col\">
			<span><b>File name</b></span>
		   </td>
		  </tr>
		 </thead>
	";

	$fh = fopen("_data/backup/$backup_dir_name/mysql/_tables.php", "w+") or die("can not open file");
	fwrite($fh, "<?php");
	fclose($fh);

	$x = 0;
	$query = "SHOW TABLES";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_table_name) = $row;

		// Does the table fit my prefix?
		$get_table_name_prefix = substr($get_table_name, 0, $my_prefix_lenght);

		if($get_table_name_prefix == "$mysqlPrefixSav"){
			// Style
			if(isset($style) && $style == ""){
				$style = "odd";
			}
			else{
				$style = "";
			}
			echo"
			 <tr>
			  <td class=\"$style\">
				<span>$get_table_name</span>
			  </td>
			  <td class=\"$style\">
				<span>_data/backup/$datetime/mysql/$get_table_name.php</span>
			  </td>
			 </tr>
			";
			
			

$input_body ="
\$table[$x] = \"$get_table_name\";";

			$fh = fopen("_data/backup/$backup_dir_name/mysql/_tables.php", "a+") or die("can not open file");
			fwrite($fh, $input_body);
			fclose($fh);

			$x++;

		} // prefix
	}
	echo"
		</table>
	";


	$fh = fopen("_data/backup/$backup_dir_name/mysql/_tables.php", "a+") or die("can not open file");
	fwrite($fh, "
?>");
	fclose($fh);





	echo"
	
	<meta http-equiv=refresh content=\"1; URL=index.php?open=$open&amp;page=$page&amp;action=new_backup_step_2_mysql_tables_structure&amp;backup_date=$datetime&amp;table_id=0&amp;backup_secret=$backup_secret\">
	
				<!-- Jquery go to URL after x seconds -->
					<!-- In case meta refresh doesnt work -->
   					<script>
					\$(document).ready(function(){
						window.setTimeout(function(){
        						// Move to a new location or you can do something else
							window.location.href = \"index.php?open=$open&page=$page&action=new_backup_step_2_mysql_tables_structure&backup_date=$datetime&table_id=0&backup_secret=$backup_secret\";
						}, 10000);
					});
   					</script>
				<!-- //Jquery go to URL after x seconds -->

	";
}
elseif($action == "new_backup_step_2_mysql_tables_structure"){
	$backup_dir_name = $backup_date . "_" . $backup_secret;


	if(isset($_GET['table_id'])) {
		$table_id = $_GET['table_id'];
		$table_id = strip_tags(stripslashes($table_id));

		include("_data/backup/$backup_dir_name/mysql/_tables.php");


		$mysql_backup_content_file = "$table[$table_id]" . "_content.dat";

		if(isset($table[$table_id])){
			// Get header
			echo"

			<h2><img src=\"_design/gfx/loading_22.gif\" alt=\"\" style=\"float: left;padding-right: 6px;\" /> New Backup - Table structure</h2>
			

			<!-- General info -->
				<table>
				 <tr>
				  <td style=\"padding-right: 25px;\">
					<table>
					 <tr>
					  <td style=\"padding-right: 5px;\">
						<span><b>Table name:</b></span>
					  </td>
					  <td>
						<span>$table[$table_id]</span>
					  </td>
					 </tr>
					 <tr>
					  <td style=\"padding-right: 5px;\">
						<span><b>Backup file:</b></span>
					  </td>
					  <td>
						<span>$mysql_backup_content_file</span>
					  </td>
					 </tr>
					</table>
				  </td>
				  <td>
					<table>
					 <tr>
					  <td style=\"padding-right: 5px;\">
						<span><b>Date:</b></span>
					  </td>
					  <td>
						<span>$backup_date</span>
					  </td>
					 </tr>
					 <tr>
					  <td style=\"padding-right: 5px;\">
						<span><b>Secret:</b></span>
					  </td>
					  <td>
						<span>$backup_secret</span>
					  </td>
					 </tr>
					</table>
				  </td>
				 </tr>
				</table>
			<!-- //General info -->



			";


			// Ready insert into statement
			$table_column_names = array();
			$table_column_types = array();

			// Ready create table
			$create_table = "CREATE TABLE $table[$table_id](
";


			$x = 0;
			$query = "SELECT COLUMN_NAME, COLUMN_DEFAULT, IS_NULLABLE, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH, NUMERIC_PRECISION, COLUMN_TYPE, COLUMN_KEY, EXTRA FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '$table[$table_id]'";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_column_name, $get_column_default, $get_is_nullable, $get_data_type, $get_character_maximum_lenght, $get_mumeric_precision, $get_column_type, $get_column_key, $get_extra) = $row;

				$get_data_type = strtoupper($get_data_type);
				$get_extra = strtoupper($get_extra);
				

				if($x > 1){
					$create_table = $create_table . ",
";
				}

				$create_table = $create_table . " $get_column_name $get_data_type";
				
				if($get_data_type == "VARCHAR"){
					$create_table = $create_table . " ($get_character_maximum_lenght)";
				}
				if($get_is_nullable == "NO"){
					$create_table = $create_table . " NOT NULL";
				}
				if($get_extra == "AUTO_INCREMENT"){
					$create_table = $create_table . " AUTO_INCREMENT";
				}




				if($get_column_key == "PRI"){
					$create_table = $create_table . ",
 PRIMARY KEY($get_column_name), 
";
				}



				// Add to columns
				$table_column_names[$x] = "$get_column_name";
				$table_column_types[$x] = "$get_data_type";
							
				$x++;
			}

			// Create table footer
			$create_table = $create_table . ");
";




			// Columns
			$input_columns_header = "<?php

// Columns";
			$fh = fopen("_data/backup/$backup_dir_name/mysql/$table[$table_id].php", "w+") or die("can not open file");
			fwrite($fh, $input_columns_header);
			fclose($fh);


			for($i=0;$i<$x;$i++){
				$input_columns = "
\$table_column_names[$i] = \"$table_column_names[$i]\";
\$table_column_types[$i] = \"$table_column_types[$i]\";";
				$fh = fopen("_data/backup/$backup_dir_name/mysql/$table[$table_id].php", "a+") or die("can not open file");
				fwrite($fh, $input_columns);
				fclose($fh);
			}


			// Create table
			$input_create_table ="

// Create table statement
\$create_table_query = '$create_table';";

			$fh = fopen("_data/backup/$backup_dir_name/mysql/$table[$table_id].php", "a+") or die("can not open file");
			fwrite($fh, $input_create_table);
			fclose($fh);

			// Number of rows in table
			$query = "SELECT count(*) FROM $table[$table_id]";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($row_cnt) = $row;


			$input_number_of_rows ="

// Number of rows
\$table_number_of_rows = \"$row_cnt\";
?>
";

			$fh = fopen("_data/backup/$backup_dir_name/mysql/$table[$table_id].php", "a+") or die("can not open file");
			fwrite($fh, $input_number_of_rows);
			fclose($fh);


			echo"
			<div class=\"clear\"></div>

			<meta http-equiv=refresh content=\"1; URL=index.php?open=$open&amp;page=$page&amp;action=new_backup_step_3_mysql_table_contents&amp;backup_date=$backup_date&amp;table_id=$table_id&amp;start=0&amp;backup_secret=$backup_secret\">

				<!-- Jquery go to URL after x seconds -->
					<!-- In case meta refresh doesnt work -->
   					<script>
					\$(document).ready(function(){
						window.setTimeout(function(){
        						// Move to a new location or you can do something else
							window.location.href = \"index.php?open=$open&page=$page&action=new_backup_step_3_mysql_table_contents&backup_date=$backup_date&table_id=$table_id&start=0&backup_secret=$backup_secret\";
						}, 10000);
					});
   					</script>
				<!-- //Jquery go to URL after x seconds -->

			";

		}
		else{
			echo"
			<meta http-equiv=refresh content=\"1; URL=index.php?open=$open&amp;page=$page&amp;action=new_backup_step_4_mysql_table_zip&amp;backup_date=$backup_date&amp;backup_secret=$backup_secret\">
				<!-- Jquery go to URL after x seconds -->
					<!-- In case meta refresh doesnt work -->
   					<script>
					\$(document).ready(function(){
						window.setTimeout(function(){
        						// Move to a new location or you can do something else
							window.location.href = \"index.php?open=$open&page=$page&action=new_backup_step_4_mysql_table_zip&backup_date=$backup_date&backup_secret=$backup_secret\";
						}, 10000);
					});
   					</script>
				<!-- //Jquery go to URL after x seconds -->

			<p>
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=new_backup_step_4_mysql_table_zip&amp;backup_date=$backup_date&amp;backup_secret=$backup_secret\" class=\"btn\">Start zip</a>
			</p>
			
			";
		}
	}
	else{
		echo"Missing table id";
	}
	echo"

	<p>
	<a href=\"index.php?open=$open&amp;page=$page&amp;action=new_backup_step_5_make_website_list_of_dir_and_files&amp;backup_date=$backup_date&amp;backup_secret=$backup_secret\" class=\"btn\">Skip database and go to web</a>
	</p>

	";

} // table structures
elseif($action == "new_backup_step_3_mysql_table_contents"){
	$backup_dir_name = $backup_date . "_" . $backup_secret;
	if(isset($_GET['table_id']) && isset($_GET['start'])) {
		$table_id = $_GET['table_id'];
		$table_id = strip_tags(stripslashes($table_id));

		$start = $_GET['start'];
		$start = strip_tags(stripslashes($start));

		$current_date = date("Y-m-d");
		$current_datetime = date("Y-m-d H:i:s");

		include("_data/backup/$backup_dir_name/mysql/_tables.php");

		$number_of_rows_for_each_run = 1000;

		if(isset($table[$table_id])){
			// Include file
			include("_data/backup/$backup_dir_name/mysql/$table[$table_id].php");

			// File to write to 
			$mysql_backup_content_path = "_data/backup/$backup_dir_name/mysql";
			$mysql_backup_content_file = "$table[$table_id]" . "_content.dat";


			$stop = $start+$number_of_rows_for_each_run;
			echo"
			<h2><img src=\"_design/gfx/loading_22.gif\" alt=\"loading_22.gif\" style=\"float: left;padding-right: 6px;\" /> New Backup - Table contents</h2>
			
			<!-- General info -->
				<table>
				 <tr>
				  <td style=\"padding-right: 25px;\">
					<table>
					 <tr>
					  <td style=\"padding-right: 5px;\">
						<span><b>Table name:</b></span>
					  </td>
					  <td>
						<span>$table[$table_id]</span>
					  </td>
					 </tr>
					 <tr>
					  <td style=\"padding-right: 5px;\">
						<span><b>Backup file:</b></span>
					  </td>
					  <td>
						<span>$mysql_backup_content_file</span>
					  </td>
					 </tr>
					</table>
				  </td>
				  <td>
					<table>
					 <tr>
					  <td style=\"padding-right: 5px;\">
						<span><b>Date:</b></span>
					  </td>
					  <td>
						<span>$backup_date</span>
					  </td>
					 </tr>
					 <tr>
					  <td style=\"padding-right: 5px;\">
						<span><b>Secret:</b></span>
					  </td>
					  <td>
						<span>$backup_secret</span>
					  </td>
					 </tr>
					</table>
				  </td>
				 </tr>
				</table>
			<!-- //General info -->
			";
			$percentage = 100;
			if($table_number_of_rows > $stop){
				$percentage = round(($stop/$table_number_of_rows)*100, 0);
			}
			echo"
			<p>
			<b>Rows:</b> $table_number_of_rows<br />
			<b>Location:</b> $start-$stop<br />
			<b>Percentage:</b> $percentage %<br />
			</p>
			";
	
			if($table_number_of_rows > 0){
				
				// Fetch data
				$query = "SELECT * FROM $table[$table_id] LIMIT $start,$number_of_rows_for_each_run";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					
					$input_row = "{start}";
					$count = count($row, COUNT_RECURSIVE);
					for($x=0;$x<$count;$x++){

						
						// Data
						if($table_column_types[$x] == "INT" && $row[$x] == ""){
							$input_data = "0";
						}
						elseif($table_column_types[$x] == "DATE" && $row[$x] == ""){
							$input_data = "$current_date";
						}
						elseif($table_column_types[$x] == "DATETIME" && $row[$x] == ""){
							$input_data = "$current_datetime";
						}
						elseif($table_column_types[$x] == "TIME" && $row[$x] == ""){
							$input_data = "NULL";
						}
						elseif($table_column_types[$x] == "DOUBLE" && $row[$x] == ""){
							$input_data = "NULL";
						}
						else{
							$input_data = "$row[$x]";
						}

						// Seperator
						if($input_row == ""){
							$input_row = $input_data;
						}
						else{
							$input_row = $input_row . "|" . $input_data;
						}

					}

					$input = "$input_row
";
					$fh = fopen("$mysql_backup_content_path/$mysql_backup_content_file", "a+") or die("can not open file");
					fwrite($fh, $input);
					fclose($fh);
				}
			} // Rows > 0 

			// Continue
			$next_start = $start+$number_of_rows_for_each_run;
			if($next_start > $table_number_of_rows){
				// Next table
				$next_table_id = $table_id + 1;
				echo"
				<meta http-equiv=refresh content=\"1; URL=index.php?open=$open&amp;page=$page&amp;action=new_backup_step_2_mysql_tables_structure&amp;backup_date=$backup_date&amp;table_id=$next_table_id&amp;backup_secret=$backup_secret\">
				<!-- Jquery go to URL after x seconds -->
					<!-- In case meta refresh doesnt work -->
   					<script>
					\$(document).ready(function(){
						window.setTimeout(function(){
        						// Move to a new location or you can do something else
							window.location.href = \"index.php?open=$open&page=$page&action=new_backup_step_2_mysql_tables_structure&backup_date=$backup_date&table_id=$next_table_id&backup_secret=$backup_secret\";
						}, 10000);
					});
   					</script>
				<!-- //Jquery go to URL after x seconds -->
				";

			}
			else{
				$skip_next_table_id = $table_id + 1;
				echo"
				<meta http-equiv=refresh content=\"1; URL=index.php?open=$open&amp;page=$page&amp;action=new_backup_step_3_mysql_table_contents&amp;backup_date=$backup_date&amp;table_id=$table_id&amp;start=$next_start&amp;backup_secret=$backup_secret\">
				<!-- Jquery go to URL after x seconds -->
					<!-- In case meta refresh doesnt work -->
   					<script>
					\$(document).ready(function(){
						window.setTimeout(function(){
        						// Move to a new location or you can do something else
							window.location.href = \"index.php?open=$open&page=$page&action=new_backup_step_3_mysql_table_contents&backup_date=$backup_date&table_id=$table_id&start=$next_start&backup_secret=$backup_secret\";
						}, 10000);
					});
   					</script>
				<!-- //Jquery go to URL after x seconds -->
				<p>
				<a href=\"index.php?open=$open&amp;page=$page&amp;action=new_backup_step_3_mysql_table_contents&amp;backup_date=$backup_date&amp;table_id=$table_id&amp;start=$next_start&amp;backup_secret=$backup_secret\" class=\"btn\">Continue from $next_start</a>
				<a href=\"index.php?open=$open&amp;page=$page&amp;action=new_backup_step_2_mysql_tables_structure&amp;backup_date=$backup_date&amp;table_id=$skip_next_table_id&amp;backup_secret=$backup_secret\" class=\"btn\">Skip this table</a>
				</p>
				";
			}
			

		}
		else{
			echo"
			<p>
			Finished with table contents.
			</p>

			";
		}
	}
	else{
		echo"Missing table id or start";
	}
} // table structures
elseif($action == "new_backup_step_4_mysql_table_zip"){
	$backup_dir_name = $backup_date . "_" . $backup_secret;
	$backup_zip_db_file = "_data/backup/$backup_date" . "_" . $backup_secret . "_db.zip";
	$backup_zip_web_file = "_data/backup/$backup_date" . "_" . $backup_secret . "_web.zip";
	echo"
	<h2><img src=\"_design/gfx/loading_22.gif\" alt=\"loading_22.gif\" style=\"float: left;padding-right: 6px;\" /> New Backup - Zip</h2>

	";

	// Todo: Add "install db file" to zip


	// Get real path for our folder
	$rootPath = realpath("_data/backup/$backup_dir_name/mysql/");

	// Initialize archive object
	$zip = new ZipArchive();
	$zip->open("$backup_zip_db_file", ZipArchive::CREATE | ZipArchive::OVERWRITE);
	
	// Create recursive directory iterator
	/** @var SplFileInfo[] $files */
	$files = new RecursiveIteratorIterator(
	    new RecursiveDirectoryIterator($rootPath),
	    RecursiveIteratorIterator::LEAVES_ONLY
	);

	// echo"<p>Add sql files:<br />\n";
	foreach ($files as $name => $file){
    		// Skip directories (they would be added automatically)
    		if (!$file->isDir()){
			// Get real and relative path for current file
			$filePath = $file->getRealPath();
			$relativePath = substr($filePath, strlen($rootPath) + 1);

			// Add current file to archive
			$zip->addFile($filePath, $relativePath);
			// echo"Add /$filePath, $relativePath<br />\n";
		}
	}
	// echo"</p>\n";


	// Add config files
	// echo"<p>Add config:<br />\n";
	$filenames = "";
	$dir = "_data/";
	if ($handle = opendir($dir)) {
		while (false !== ($file = readdir($handle))) {
			if ($file === '.') continue;
			if ($file === '..') continue;
			if(!(is_dir("$dir$file"))){
				$zip->addFile("$dir$file", "config/$file");
				// echo"Add /config/$file, $dir$file<br />\n";
			}
		}
	}

	// Add backup____restore_db_backup.php
	$zip->addFile("_inc/dashboard/backup__restore_db_backup.php", "_restore_db_backup.php");
	

	// echo"</p>\n";


	// Zip archive will be created only after closing object
	$zip->close();

	





	echo"
	<p>Created <a href=\"$backup_zip_db_file\">$backup_zip_db_file</a></p>

	<meta http-equiv=refresh content=\"5; URL=index.php?open=$open&amp;page=$page&amp;action=new_backup_step_5_make_website_list_of_dir_and_files&amp;backup_date=$backup_date&amp;backup_secret=$backup_secret\">
				<!-- Jquery go to URL after x seconds -->
					<!-- In case meta refresh doesnt work -->
   					<script>
					\$(document).ready(function(){
						window.setTimeout(function(){
        						// Move to a new location or you can do something else
							window.location.href = \"index.php?open=$open&page=$page&action=new_backup_step_5_make_website_list_of_dir_and_files&backup_date=$backup_date&backup_secret=$backup_secret\";
						}, 10000);
					});
   					</script>
				<!-- //Jquery go to URL after x seconds -->
	<p>
	<a href=\"index.php?open=$open&amp;page=$page&amp;action=new_backup_step_5_make_website_list_of_dir_and_files&amp;backup_date=$backup_date&amp;backup_secret=$backup_secret\" class=\"btn\">Continue</a>
	</p>
	
	";
}
elseif($action == "new_backup_step_5_make_website_list_of_dir_and_files"){

	$backup_dir_name = $backup_date . "_" . $backup_secret;
	$backup_zip_db_file = "_data/backup/$backup_date" . "_" . $backup_secret . "_db.zip";
	$backup_zip_web_file = "_data/backup/$backup_date" . "_" . $backup_secret . "_web.zip";

	// Truncate table
	$result = mysqli_query($link, "TRUNCATE TABLE $t_backup_web_root_dir_content") or die(mysqli_error($link));
	$result = mysqli_query($link, "TRUNCATE TABLE $t_backup_web_cache") or die(mysqli_error($link));


	echo"
	<h2>Make list of dir and files in root</h2>

		<table>
		 <tr>
		  <td style=\"padding-right: 5px;\">
			<span>File path</span>
		  </td>
		  <td style=\"padding-right: 5px;\">
			<span>Relative path</span>
		  </td>
		  <td style=\"padding-right: 5px;\">
			<span>Is dir?</span>
		  </td>
		 </tr>
	";

	// Step 1: Make list of all directories in root
	// Step 2: Loop trough one and one directory, and insert them
	$filenames = "";
	$dir = "../";
	if ($handle = opendir($dir)) {
		while (false !== ($file = readdir($handle))) {
			if ($file === '.') continue;
			if ($file === '..') continue;

			// File path
			$inp_file_path_mysql = quote_smart($link, "../$file");

			// Relative path
			$inp_real_path = realpath("../$file");
			$inp_real_path_mysql = quote_smart($link, $inp_real_path);

			// Size
			$inp_size = filesize("../$file");
			$inp_size_mysql = quote_smart($link, $inp_size);

			// is dir
			$inp_is_dir = 0;
			if(is_dir("../$file")){
				$inp_is_dir = 1;
			}
			$inp_is_dir_mysql = quote_smart($link, $inp_is_dir);


			// Insert
			if($inp_is_dir == 1){
				mysqli_query($link, "INSERT INTO $t_backup_web_root_dir_content	
				(content_id, content_file_path, content_relative_path, content_size) 
				VALUES 
				(NULL, $inp_file_path_mysql, $inp_real_path_mysql, $inp_size_mysql)")
				or die(mysqli_error($link));
			}
			elseif($inp_is_dir == 0){
				mysqli_query($link, "INSERT INTO $t_backup_web_cache
				(web_id, web_file_path, web_relative_path, web_size) 
				VALUES 
				(NULL, $inp_real_path_mysql, $inp_file_path_mysql, $inp_size_mysql)")
				or die(mysqli_error($link));
			}


			echo"
			 <tr>
			  <td style=\"padding-right: 5px;\">
				<span>../$file</span>
			  </td>
			  <td style=\"padding-right: 5px;\">
				<span>$inp_real_path</span>
			  </td>
			  <td style=\"padding-right: 5px;\">
				<span>$inp_is_dir</span>
			  </td>
			 </tr>
			";
		}
		closedir($handle);
	}
	echo"
		</table>


	<meta http-equiv=refresh content=\"2; URL=index.php?open=$open&amp;page=$page&amp;action=new_backup_step_6_make_web_cache&amp;backup_date=$backup_date&amp;backup_secret=$backup_secret\">
				<!-- Jquery go to URL after x seconds -->
					<!-- In case meta refresh doesnt work -->
   					<script>
					\$(document).ready(function(){
						window.setTimeout(function(){
        						// Move to a new location or you can do something else
							window.location.href = \"index.php?open=$open&page=$page&action=new_backup_step_6_make_web_cache&backup_date=$backup_date&backup_secret=$backup_secret\";
						}, 10000);
					});
   					</script>
				<!-- //Jquery go to URL after x seconds -->
	<p>
	<a href=\"index.php?open=$open&amp;page=$page&amp;action=new_backup_step_6_make_web_cache&amp;backup_date=$backup_date&amp;backup_secret=$backup_secret\" class=\"btn\">Continue</a>
	</p>
	
	";	
	

}
elseif($action == "new_backup_step_6_make_web_cache"){
	// We will take one and one dir from "backup_web_root_dir_content"

	// 1: Look for line in "backup_web_root_dir_content"
	// 2: Loop trought the dir
	// 3: Go to next, if empty list then 

	// Variables
	$backup_dir_name = $backup_date . "_" . $backup_secret;
	$backup_zip_db_file = "_data/backup/$backup_date" . "_" . $backup_secret . "_db.zip";
	$backup_zip_web_file = "_data/backup/$backup_date" . "_" . $backup_secret . "_web.zip";



	$query = "SELECT content_id, content_file_path, content_relative_path, content_size FROM $t_backup_web_root_dir_content LIMIT 0,1";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_content_id, $get_content_file_path, $get_content_relative_path, $get_content_size) = $row;
	if($get_content_id == ""){
		echo"<h2>Finished with make web cache</h2>\n

		<meta http-equiv=refresh content=\"10; URL=index.php?open=$open&amp;page=$page&amp;action=new_backup_step_7_backup_website&amp;backup_date=$backup_date&amp;backup_secret=$backup_secret\">

				<!-- Jquery go to URL after x seconds -->
					<!-- In case meta refresh doesnt work -->
   					<script>
					\$(document).ready(function(){
						window.setTimeout(function(){
        						// Move to a new location or you can do something else
							window.location.href = \"index.php?open=$open&page=$page&action=new_backup_step_7_backup_website&backup_date=$backup_date&backup_secret=$backup_secret\";
						}, 20000);
					});
   					</script>
				<!-- //Jquery go to URL after x seconds -->

		<p>
		<a href=\"index.php?open=$open&amp;page=$page&amp;action=new_backup_step_7_backup_website&amp;backup_date=$backup_date&amp;backup_secret=$backup_secret\" class=\"btn\">Continue</a>
		</p>
		";
	}
	else{
		// Loop trough
		echo"
		<h2>Making list of dir and files from <em>$get_content_file_path</em></h2>
		";

		// Get real path for our folder
		$rootPath = realpath($get_content_file_path);

	
	
		// Create recursive directory iterator
		/** @var SplFileInfo[] $files */
		$files = new RecursiveIteratorIterator(
		    new RecursiveDirectoryIterator($rootPath),
		    RecursiveIteratorIterator::LEAVES_ONLY
		);

		foreach ($files as $name => $file){
    			// Skip directories (they would be added automatically)
    			if (!$file->isDir()){
				// Get real and relative path for current file
				$filePath = $file->getRealPath();
				$relativePath = substr($filePath, strlen($rootPath) + 1);

				$relative_path_str_len = strlen($relativePath);
				$check_if_zipped_dir = "";
				$check_if_admin_backup_dir = "";
				if($relative_path_str_len > 6){
					$check_if_zipped_dir = substr($relativePath, 0, 7);
				}
				if($relative_path_str_len > 18){
					$check_if_admin_backup_dir = substr($relativePath, 0, 19);
				}

				// Add current file to archive
				if($relativePath != "$backup_zip_db_file" && $check_if_zipped_dir != "_zipped" && $check_if_admin_backup_dir != "_admin\_data\backup" && $check_if_admin_backup_dir != "_admin/_data/backup"){
					// echo"$filePath &middot; $relativePath &middot; $check_if_zipped_dir<br />";
					$inp_web_file_path_mysql = quote_smart($link, $filePath);
					$inp_web_relative_path_mysql = quote_smart($link, $relativePath);
					$inp_web_size_mysql = quote_smart($link, filesize($filePath));

					mysqli_query($link, "INSERT INTO $t_backup_web_cache
					(web_id, web_file_path, web_relative_path, web_size) 
					VALUES 
					(NULL, $inp_web_file_path_mysql, $inp_web_relative_path_mysql, $inp_web_size_mysql)")
					or die(mysqli_error($link));
				}
			}
		}

		// Delete
		$result = mysqli_query($link, "DELETE FROM $t_backup_web_root_dir_content WHERE content_id=$get_content_id");

		echo"
		<p>Delete from <em>$get_content_id</em> and go to next</p>

		<meta http-equiv=refresh content=\"1; URL=index.php?open=$open&amp;page=$page&amp;action=new_backup_step_6_make_web_cache&amp;backup_date=$backup_date&amp;backup_secret=$backup_secret\">
				<!-- Jquery go to URL after x seconds -->
					<!-- In case meta refresh doesnt work -->
   					<script>
					\$(document).ready(function(){
						window.setTimeout(function(){
        						// Move to a new location or you can do something else
							window.location.href = \"index.php?open=$open&page=$page&action=new_backup_step_6_make_web_cache&backup_date=$backup_date&backup_secret=$backup_secret\";
						}, 10000);
					});
   					</script>
				<!-- //Jquery go to URL after x seconds -->
		<p>
		<a href=\"index.php?open=$open&amp;page=$page&amp;action=new_backup_step_6_make_web_cache&amp;backup_date=$backup_date&amp;backup_secret=$backup_secret\" class=\"btn\">Continue</a>
		</p>

		";
		

	} // loop



} // new_backup_step_6_make_web_cache
elseif($action == "new_backup_step_7_backup_website"){
	$backup_dir_name = $backup_date . "_" . $backup_secret;
	$backup_zip_db_file = "_data/backup/$backup_date" . "_" . $backup_secret . "_db.zip";
	$backup_zip_web_file = "_data/backup/$backup_date" . "_" . $backup_secret . "_web.zip";

	if(isset($_GET['start'])){
		$start = $_GET['start'];
		$start = strip_tags(stripslashes($start));
	}
	else{
		$start = 0;
	}

	// Count left
	$query = "SELECT count(*) FROM $t_backup_web_cache";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($row_cnt_backup_web_cache) = $row;


	// Output
	echo"
	<h1>Backing up website</h1>

	<p>
	Start: $start<br />
	Items left: $row_cnt_backup_web_cache<br />
	</p>
	</p>
	";

	// Get real path for our folder
	$rootPath = realpath('../');

	// Initialize archive object
	$zip = new ZipArchive();

	if($start == 0){
		$zip->open("$backup_zip_web_file", ZipArchive::CREATE | ZipArchive::OVERWRITE);
	}
	else{
		$zip->open("$backup_zip_web_file");
	}
	
	// Fetch file and dir list
	echo"<ul>\n";
	$query = "SELECT web_id, web_file_path, web_relative_path FROM $t_backup_web_cache ORDER BY web_id ASC LIMIT 0,25";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_web_id, $get_web_file_path, $get_web_relative_path) = $row;
		echo"<li><span>$get_web_relative_path</span></li>\n";
		$zip->addFile($get_web_file_path, $get_web_relative_path);

		// Remove
		$result_remove = mysqli_query($link, "DELETE FROM $t_backup_web_cache WHERE web_id=$get_web_id");

	}
	echo"</ul>\n";
	
	// Zip archive will be created only after closing object
	$zip->close();


	// Next
	if($row_cnt_backup_web_cache != 0){
		$next = $start+25;
		$rand = rand(0,1);
		echo"
		<meta http-equiv=refresh content=\"$rand; URL=index.php?open=$open&amp;page=$page&amp;action=new_backup_step_7_backup_website&amp;start=$next&amp;backup_date=$backup_date&amp;backup_secret=$backup_secret\">

				<!-- Jquery go to URL after x seconds -->
					<!-- In case meta refresh doesnt work -->
   					<script>
					\$(document).ready(function(){
						window.setTimeout(function(){
        						// Move to a new location or you can do something else
							window.location.href = \"index.php?open=$open&page=$page&action=new_backup_step_7_backup_website&start=$next&backup_date=$backup_date&backup_secret=$backup_secret\";
						}, 10000);
					});
   					</script>
				<!-- //Jquery go to URL after x seconds -->
		";
	}
	else{
		echo"
		<p>Finished!</p>
		<meta http-equiv=refresh content=\"3; URL=index.php?open=$open&amp;page=$page&amp;action=send_email&amp;backup_date=$backup_date&amp;backup_secret=$backup_secret\">
				<!-- Jquery go to URL after x seconds -->
					<!-- In case meta refresh doesnt work -->
   					<script>
					\$(document).ready(function(){
						window.setTimeout(function(){
        						// Move to a new location or you can do something else
							window.location.href = \"index.php?open=$open&page=$page&action=send_email&backup_date=$backup_date&backup_secret=$backup_secret\";
						}, 10000);
					});
   					</script>
				<!-- //Jquery go to URL after x seconds -->
		<p><a href=\"index.php?open=$open&amp;page=$page&amp;action=send_email&amp;backup_date=$backup_date&amp;backup_secret=$backup_secret\">Continue</a></p>
		";

		// Email
		
	}

	
}
elseif($action == "send_email"){
	$backup_dir_name = $backup_date . "_" . $backup_secret;
	$backup_zip_db_file = "_data/backup/$backup_date" . "_" . $backup_secret . "_db.zip";
	$backup_zip_web_file = "_data/backup/$backup_date" . "_" . $backup_secret . "_web.zip";


	echo"
	<p>Finished!</p>
		
	<p><a href=\"index.php?open=$open&amp;page=$page&amp;action=send_email&amp;backup_date=$backup_date&amp;backup_secret=$backup_secret\">Continue</a></p>
	";

	$date_saying = date("j F Y");
	$query = "SELECT user_id, user_email, user_name, user_rank FROM $t_users WHERE user_rank='admin'";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_user_id, $get_user_email, $get_user_name, $get_user_rank) = $row;

		
		$subject = "$configWebsiteTitleSav Backup $date_saying";
		$message = "Hello $get_user_name\n\n";
		$message = $message . "A backup is ready for download from $date_saying.\n\n";
		$message = $message . "Database: $configControlPanelURLSav/$backup_zip_db_file\n";
		$message = $message . "Web: $configControlPanelURLSav/$backup_zip_web_file\n\n";
		$message = $message . "--\n";
		$message = $message . "Regards\n";
		$message = $message . "$configWebsiteWebmasterSav at $configWebsiteTitleSav\n";
		$headers = "From: $configFromEmailSav" . "\r\n" .
		    'X-Mailer: PHP/' . phpversion();

		mail($get_user_email, $subject, $message, $headers);
	}
	echo"
	<meta http-equiv=refresh content=\"2; URL=index.php?open=$open&amp;page=$page&amp;action=delete_cache&amp;backup_date=$backup_date&amp;backup_secret=$backup_secret\">
				<!-- Jquery go to URL after x seconds -->
					<!-- In case meta refresh doesnt work -->
   					<script>
					\$(document).ready(function(){
						window.setTimeout(function(){
        						// Move to a new location or you can do something else
							window.location.href = \"index.php?open=$open&page=$page&action=delete_cache&backup_date=$backup_date&backup_secret=$backup_secret\";
						}, 10000);
					});
   					</script>
				<!-- //Jquery go to URL after x seconds -->

	";
}
elseif($action == "download_backup"){
	$backup_dir_name = $backup_date . "_" . $backup_secret;
	$backup_zip_db_file = "_data/backup/$backup_date" . "_" . $backup_secret . "_db.zip";
	$backup_zip_web_file = "_data/backup/$backup_date" . "_" . $backup_secret . "_web.zip";


	echo"
	<h2>$backup_date</h2>

	<!-- Download MySQL -->
		<table>
		 <tr>
		  <td>
			<p><b>Db:</b></p>
		  </td>
		  <td>
			<p><a href=\"$backup_zip_db_file\" class=\"btn\">$backup_zip_db_file</a></p>
		  </td>
		 </tr>
		 <tr>
		  <td>
			<p><b>Web:</b></p>
		  </td>
		  <td>
			<p><a href=\"$backup_zip_web_file\" class=\"btn\">$backup_zip_web_file</a></p>
		  </td>
		 </tr>
		</table>
	<!-- //Download MySQL -->




	<p>
	<a href=\"index.php?open=$open&amp;page=$page\" class=\"btn_default\">Home</a>
	</p>
	";
}
elseif($action == "delete_backup"){
	$backup_dir_name = $backup_date . "_" . $backup_secret;
	$backup_zip_db_file = "_data/backup/$backup_date" . "_" . $backup_secret . "_db.zip";
	$backup_zip_web_file = "_data/backup/$backup_date" . "_" . $backup_secret . "_web.zip";


	if($mode == "do_delete"){
		if(file_exists("$backup_zip_db_file")){
			unlink("$backup_zip_db_file");
		}
		if(file_exists("$backup_zip_web_file")){
			unlink("$backup_zip_web_file");
		}
		
		echo"
		<h2><img src=\"_design/gfx/loading_22.gif\" alt=\"loading_22.gif\" style=\"float: left;padding-right: 6px;\" /> $backup_date</h2>

		<p>Deleting...</p>
		
		<meta http-equiv=refresh content=\"1; URL=index.php?open=$open&amp;page=$page&amp;ft=success&amp;fm=backup_deleted\">
				<!-- Jquery go to URL after x seconds -->
					<!-- In case meta refresh doesnt work -->
   					<script>
					\$(document).ready(function(){
						window.setTimeout(function(){
        						// Move to a new location or you can do something else
							window.location.href = \"index.php?open=$open&page=$page&ft=success&fm=backup_deleted\";
						}, 10000);
					});
   					</script>
				<!-- //Jquery go to URL after x seconds -->
		";
		
	}
	else{
		echo"
		<h2>$backup_date</h2>

	

		<p>
		Are you sure you want to delete the backup?
		</p>

		<table>
		 <tr>
		  <td style=\"padding-right: 6px;\">
			<a href=\"$backup_zip_db_file\"><img src=\"_inc/dashboard/_img/icon_db.png\" alt=\"icon_db.png\" /></a>
		  </td>
		  <td>
			<a href=\"$backup_zip_db_file\">$backup_zip_db_file</a>
		  </td>
		 </tr>
		 <tr>
		  <td style=\"padding-right: 6px;\">
			<a href=\"$backup_zip_web_file\"><img src=\"_inc/dashboard/_img/icon_website.png\" alt=\"icon_website.png\" /></a>
		  </td>
		  <td>
			<a href=\"$backup_zip_web_file\">$backup_zip_web_file</a>
		  </td>
		 </tr>
		</table>

		<p>
		<a href=\"index.php?open=dashboard&amp;page=backup&amp;action=delete_backup&amp;backup_date=$backup_date&amp;backup_secret=$backup_secret&amp;mode=do_delete\" class=\"btn\">Delete</a>
		<a href=\"index.php?open=$open&amp;page=$page\" class=\"btn_default\">Home</a>
		</p>
		";
	}
}
elseif($action == "delete_cache"){
		

	$filenames = "";
	$dir = "_data/backup/";
	if ($handle = opendir($dir)) {
		while (false !== ($file = readdir($handle))) {
			if ($file === '.') continue;
			if ($file === '..') continue;

			// Date and secret
			$name_array = explode("_", $file);
			$date = $name_array[0];
			$secret = $name_array[1];

			// Dir?
			if(is_dir("$dir$file")){
				delete_directory("$dir$file/");
			}
		}
	}

	echo"
	<h2><img src=\"_design/gfx/loading_22.gif\" alt=\"loading_22.gif\" style=\"float: left;padding-right: 6px;\" /> Deleting cache</h2>
		
	<meta http-equiv=refresh content=\"1; URL=index.php?open=$open&amp;page=$page&amp;ft=success&amp;fm=cache_deleted\">

	";
}


?>