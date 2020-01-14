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
		<a href=\"index.php?open=$open&amp;page=$page&amp;action=scan_all_modules_and_insert_into_index&amp;mode=pick_module&amp;l=$l\" class=\"btn_default\">Scan all modules and insert into index</a>
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
		   <th scope=\"col\">
			<span><b>ID</b></span>
		   </td>
		   <th scope=\"col\">
			<span><b>Title</b></span>
		   </td>
		   <th scope=\"col\">
			<span><b>Description</b></span>
		   </td>
		   <th scope=\"col\">
			<span><b>URL</b></span>
		   </td>
		   <th scope=\"col\">
			<span><b>Unique hits</b></span>
		   </td>
		  </tr>
		 </thead>
		";

		$query = "SELECT index_id, index_title, index_url, index_short_description, index_module_name, index_reference_id, index_is_ad, index_created_datetime, index_created_datetime_print, index_updated_datetime, index_updated_datetime_print, index_language, index_unique_hits, index_hits_ipblock FROM $t_search_engine_index";
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
				$get_index_title
				</span>
			  </td>
			  <td class=\"$style\">
				<span>
				$get_index_short_description
				</span>
			  </td>
			  <td class=\"$style\">
				<span>
				<a href=\"../$get_index_url\">$get_index_url</a>
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
	if($mode == "pick_module"){


		// Make list of modules
		$pick_next_file_as_module = "";
		$next_module = "$module";

		$filenames = "";
		$dir = "_inc";
		if ($handle = opendir($dir)) {
			$files = array();   
			while (false !== ($module_dir = readdir($handle))) {
			

				if(file_exists("$dir/$module_dir/_search_engine_index.php")){
				
					if($next_module == ""){ 
						$next_module = "$module_dir";
					}
					else{
						if($pick_next_file_as_module == ""){
							if($module == "$module_dir"){
								$pick_next_file_as_module = "true";

							}
						}
						elseif($pick_next_file_as_module == "true"){
							$pick_next_file_as_module = "have_picked_one";
							$next_module = "$module_dir";
						}
					}
				}
			}
			closedir($handle);
		}

		echo"
		

		";
		if($module == "$next_module"){
			echo"
			<h1>Pick module</h1>
			<p>
			<a href=\"index.php?open=$open&amp;page=$page&amp;l=$l\">Search engine index</a>
			</p>


			<meta http-equiv=refresh content=\"1; URL=index.php?open=$open&amp;page=$page&amp;l=$l&amp;ft=success&amp;fm=index_updated\">
	
			<!-- Jquery go to URL after x seconds -->
			<!-- In case meta refresh doesnt work -->
   			<script>
			\$(document).ready(function(){
				window.setTimeout(function(){
        				// Move to a new location or you can do something else
					window.location.href = \"index.php?open=$open&page=$page&l=$l&ft=success&fm=index_updated\";
				}, 10000);
			});
   			</script>
			<!-- //Jquery go to URL after x seconds -->

			";
		}
		else{
			echo"
			<h1><img src=\"_design/gfx/loading_22.gif\" alt=\"loading_22.gif\" style=\"float: left;padding-right: 6px;\" /> $module</h1>
			<p>
			$module -&gt; <a href=\"index.php?open=$open&amp;page=$page&amp;action=scan_all_modules_and_insert_into_index&amp;mode=insert_and_update_search_index&amp;module=$next_module&amp;l=$l\">$next_module</a> </p>


			<meta http-equiv=refresh content=\"1; URL=index.php?open=$open&amp;page=$page&amp;action=scan_all_modules_and_insert_into_index&amp;mode=insert_and_update_search_index&amp;module=$next_module&amp;l=$l\">
	
			<!-- Jquery go to URL after x seconds -->
			<!-- In case meta refresh doesnt work -->
   			<script>
			\$(document).ready(function(){
				window.setTimeout(function(){
        				// Move to a new location or you can do something else
					window.location.href = \"index.php?open=$open&page=$page&action=scan_all_modules_and_insert_into_index&mode=insert_and_update_search_index&module=$next_module&l=$l\";
				}, 10000);
			});
   			</script>
			<!-- //Jquery go to URL after x seconds -->

			";
		}

	} // mode pick module
	elseif($mode == "insert_and_update_search_index"){
		echo"
		<h1><img src=\"_design/gfx/loading_22.gif\" alt=\"loading_22.gif\" style=\"float: left;padding-right: 6px;\" /> $module</h1>

		";
		include("_inc/$module/_search_engine_index.php");

		echo"
		<p>
		<a href=\"index.php?open=$open&amp;page=$page&amp;action=scan_all_modules_and_insert_into_index&amp;mode=pick_module&amp;module=$module&amp;l=$l\">Pick a new module</a>
		</p>


		<meta http-equiv=refresh content=\"1; URL=index.php?open=$open&amp;page=$page&amp;action=scan_all_modules_and_insert_into_index&amp;mode=pick_module&amp;module=$module&amp;l=$l\">
	
		<!-- Jquery go to URL after x seconds -->
			<!-- In case meta refresh doesnt work -->
   			<script>
			\$(document).ready(function(){
				window.setTimeout(function(){
        				// Move to a new location or you can do something else
					window.location.href = \"index.php?open=$open&page=$page&action=scan_all_modules_and_insert_into_index&mode=pick_module&amp;module=$module&l=$l\";
				}, 10000);
			});
   			</script>
		<!-- //Jquery go to URL after x seconds -->

		";
	} // mode insert and update_search_index
	
} // scan_all_modules_and_insert_into_index
?>