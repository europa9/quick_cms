<?php
/**
*
* File: _admin/_inc/search_engine_index.php
* Version 1.0.1
* Date 12:54 28.04.2019
* Copyright (c) 2008-2019 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}


/*- Tables ---------------------------------------------------------------------------- */
$t_search_engine_index = $mysqlPrefixSav . "search_engine_index";




/*- Variables -------------------------------------------------------------------------- */

if(isset($_GET['order_by'])) {
	$order_by = $_GET['order_by'];
	$order_by = strip_tags(stripslashes($order_by));
}
else{
	$order_by = "";
}
if(isset($_GET['order_method'])) {
	$order_method = $_GET['order_method'];
	$order_method = strip_tags(stripslashes($order_method));
}
else{
	$order_method = "";
}
if(isset($_GET['mode'])) {
	$mode = $_GET['mode'];
	$mode = strip_tags(stripslashes($mode));
}
else{
	$mode = "";
}


if(isset($_GET['index_id'])) {
	$index_id = $_GET['index_id'];
	$index_id = strip_tags(stripslashes($index_id));
}
else{
	$index_id = "";
}


if($action == ""){
	
	echo"
	<h1>Search engine index</h1>

	<!-- Menu -->
		<p>
		<a href=\"index.php?open=$open&amp;page=$page&amp;action=scan_all_modules_and_insert_into_index&amp;mode=create_module_list&amp;order_method=$order_method&amp;order_by=$order_by&amp;&amp;l=$l\" class=\"btn_default\">Scan all modules and insert into index</a>
		</p>
	<!-- Menu -->

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

	<!-- Index -->
		
		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\">";
			if($order_by == "index_id" && $order_method == "asc"){
				$order_method_link = "desc";
			}
			else{
				$order_method_link = "asc";
			}

			echo"
			<span><a href=\"index.php?open=$open&amp;page=$page&amp;order_by=index_id&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>ID</b></a>";
			if($order_by == "index_id" && $order_method == "asc"){
				echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
			}
			if($order_by == "index_id" && $order_method == "desc"){
				echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
			}
			echo"</span>
		   </th>
		   <th scope=\"col\">";
			if($order_by == "index_title" && $order_method == "asc"){
				$order_method_link = "desc";
			}
			else{
				$order_method_link = "asc";
			}

			echo"
			<span><a href=\"index.php?open=$open&amp;page=$page&amp;order_by=index_title&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>Title</b></a>";
			if($order_by == "index_title" && $order_method == "asc"){
				echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
			}
			if($order_by == "index_title" && $order_method == "desc"){
				echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
			}
			echo"</span>
		   </th>
		   <th scope=\"col\">";
			if($order_by == "index_module_name" && $order_method == "asc"){
				$order_method_link = "desc";
			}
			else{
				$order_method_link = "asc";
			}

			echo"
			<span><a href=\"index.php?open=$open&amp;page=$page&amp;order_by=index_module_name&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>Module</b></a>";
			if($order_by == "index_module_name" && $order_method == "asc"){
				echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
			}
			if($order_by == "index_module_name" && $order_method == "desc"){
				echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
			}
			echo"</span>
		   </th>
		   <th scope=\"col\">";
			if($order_by == "index_unique_hits" && $order_method == "asc"){
				$order_method_link = "desc";
			}
			else{
				$order_method_link = "asc";
			}

			echo"
			<span><a href=\"index.php?open=$open&amp;page=$page&amp;order_by=index_unique_hits&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>Unique hits</b></a>";
			if($order_by == "index_unique_hits" && $order_method == "asc"){
				echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
			}
			if($order_by == "index_unique_hits" && $order_method == "desc"){
				echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
			}
			echo"</span>
		   </th>
		  </tr>
		 </thead>
		";

		$query = "SELECT index_id, index_title, index_url, index_short_description, index_module_name, index_reference_id, index_is_ad, index_created_datetime, index_created_datetime_print, index_updated_datetime, index_updated_datetime_print, index_language, index_unique_hits, index_hits_ipblock FROM $t_search_engine_index";
		if($order_by == "index_id" OR $order_by == "index_title" OR $order_by == "index_module_name" OR $order_by == "index_unique_hits"){
			if($order_method == "asc" OR $order_method == "desc"){
				$query = $query . " ORDER BY $order_by $order_method";
			}
		}

		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_index_id, $get_index_title, $get_index_url, $get_index_short_description, $get_index_module_name, $get_index_reference_id, $get_index_is_ad, $get_index_created_datetime, $get_index_created_datetime_print, $get_index_updated_datetime, $get_index_updated_datetime_print, $get_index_language, $get_index_unique_hits, $get_index_hits_ipblock) = $row;
			
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
				<span>
				$get_index_id
				</span>
			  </td>
			  <td class=\"$style\">
				<span>
				<a href=\"../$get_index_url\">$get_index_title</a>
				</span>
			  </td>
			  <td class=\"$style\">
				<span>
				$get_index_module_name
				</span>
			  </td>
			  <td class=\"$style\">
				<span>
				$get_index_unique_hits
				</span>
			  </td>
			 </tr>";
		}
		
		echo"
			</table>
		  </td>
		 </tr>
		</table>
	<!-- //Index  -->

	";
}
elseif($action == "scan_all_modules_and_insert_into_index"){
	// Variables
	if(isset($_GET['module'])) {
		$module= $_GET['module'];
		$module = strip_tags(stripslashes($module));
	}
	else{
		$module = "";
	}
	if($mode == "create_module_list"){


		// Make list of modules
		$pick_next_file_as_module = "";
		$next_module = "$module";

		$filenames = "";
		$dir = "_inc";
		$list_inp  = "";
		if ($handle = opendir($dir)) {
			$files = array();   
			while (false !== ($module_dir = readdir($handle))) {
			

				if(file_exists("$dir/$module_dir/_search_engine_index.php")){
				
					// Write this module to text file
					if($list_inp == ""){	
						$list_inp  = "$module_dir";
					}
					else{
						$list_inp  = $list_inp . "\n$module_dir";
					}

					// Pick a module
					if($module == ""){
						$module = "$module_dir";
					}

				}
			}
			closedir($handle);
		}

		// Write list to text file
		$fh = fopen("../_cache/search_engine_modules.txt", "w+") or die("can not open file");
		fwrite($fh, $list_inp);
		fclose($fh); 

		$mode = "insert_and_update_search_index";

	} // mode pick module
	if($mode == "insert_and_update_search_index"){
		echo"
		<h1><img src=\"_design/gfx/loading_22.gif\" alt=\"loading_22.gif\" style=\"float: left;padding-right: 6px;\" /> Inserting</h1>


		<table>
		 <tr>
		  <td style=\"vertical-align: top;padding-right: 30px;\">
			<!-- Modules list on left -->";
				echo"
				<table class=\"hor-zebra\">
				 <tbody>
				  <tr>
				   <td>
					";

					$fh = fopen("../_cache/search_engine_modules.txt", "r");
					$read_modules = fread($fh, filesize("../_cache/search_engine_modules.txt"));
					fclose($fh);
				
					$modules_array = explode("\n", $read_modules);

					$pick_next_module = "";
					$next_module 	  = "";
					for($x=0;$x<sizeof($modules_array);$x++){
						$module_name = $modules_array[$x];
						if($pick_next_module == "true"){ 
							$next_module = "$module_name";
							$pick_next_module = "false";

						}


						echo"
						<a href=\"index.php?open=$open&amp;page=$page&amp;action=scan_all_modules_and_insert_into_index&amp;mode=insert_and_update_search_index&amp;module=$module_name&amp;l=$l\""; if($module_name == "$module"){ echo" style=\"font-weight: bold;\""; } echo">$module_name</a><br />\n";

						if($module_name == "$module"){ 
							$pick_next_module = "true";
						}
					}
					echo"
				   </td>
				  </tr>
				 </tbody>
				</table>

			<!-- //Modules list on left -->
		  </td>
		  <td style=\"vertical-align: top;padding-right: 30px;\">
			<!-- Includes on right -->
				<h2>$module</h2>
				";
				include("_inc/$module/_search_engine_index.php");
				echo"

			<!-- //Includes on right -->
		  </td>
		 </tr>
		</table>

		";
		if($next_module != ""){
			echo"
			<meta http-equiv=refresh content=\"1; URL=index.php?open=$open&amp;page=$page&amp;action=scan_all_modules_and_insert_into_index&amp;mode=insert_and_update_search_index&amp;module=$next_module&amp;order_by=$order_by&amp;order_method=$order_method&amp;l=$l\">
	
			<!-- Jquery go to URL after x seconds -->
			<!-- In case meta refresh doesnt work -->
   			<script>
			\$(document).ready(function(){
				window.setTimeout(function(){
        				// Move to a new location or you can do something else
					window.location.href = \"index.php?open=$open&page=$page&action=scan_all_modules_and_insert_into_index&mode=insert_and_update_search_index&module=$next_module&order_by=$order_by&order_method=$order_method&l=$l\";
				}, 10000);
			});
   			</script>
			<!-- //Jquery go to URL after x seconds -->
			";
		}
		else{
			echo"
			<meta http-equiv=refresh content=\"1; URL=index.php?open=$open&amp;page=$page&amp;order_by=$order_by&amp;order_method=$order_method&amp;l=$l&amp;ft=success&amp;fm=index_complete\">
	
			<!-- Jquery go to URL after x seconds -->
			<!-- In case meta refresh doesnt work -->
   			<script>
			\$(document).ready(function(){
				window.setTimeout(function(){
        				// Move to a new location or you can do something else
					window.location.href = \"index.php?open=$open&page=$page&order_by=$order_by&order_method=$order_method&l=$l&ft=success&fm=index_complete\";
				}, 10000);
			});
   			</script>
			<!-- //Jquery go to URL after x seconds -->
			";
		}
	} // mode insert and update_search_index
	
} // scan_all_modules_and_insert_into_index
?>