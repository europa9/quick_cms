<?php
/**
*
* File: _admin/_inc/recipes/tables.php
* Version 17:15 31.12.2020
* Copyright (c) 2020 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}
/*- Tables ---------------------------------------------------------------------------- */
$t_recipes_liquidbase	 			= $mysqlPrefixSav . "recipes_liquidbase";

$t_recipes 	 			= $mysqlPrefixSav . "recipes";
$t_recipes_images			= $mysqlPrefixSav . "recipes_images";
$t_recipes_ingredients			= $mysqlPrefixSav . "recipes_ingredients";
$t_recipes_groups			= $mysqlPrefixSav . "recipes_groups";
$t_recipes_items			= $mysqlPrefixSav . "recipes_items";
$t_recipes_numbers			= $mysqlPrefixSav . "recipes_numbers";
$t_recipes_rating			= $mysqlPrefixSav . "recipes_rating";
$t_recipes_cuisines			= $mysqlPrefixSav . "recipes_cuisines";
$t_recipes_cuisines_translations	= $mysqlPrefixSav . "recipes_cuisines_translations";
$t_recipes_seasons			= $mysqlPrefixSav . "recipes_seasons";
$t_recipes_seasons_translations		= $mysqlPrefixSav . "recipes_seasons_translations";
$t_recipes_occasions			= $mysqlPrefixSav . "recipes_occasions";
$t_recipes_occasions_translations	= $mysqlPrefixSav . "recipes_occasions_translations";
$t_recipes_categories			= $mysqlPrefixSav . "recipes_categories";
$t_recipes_categories_translations	= $mysqlPrefixSav . "recipes_categories_translations";
$t_recipes_measurements			= $mysqlPrefixSav . "recipes_measurements";
$t_recipes_measurements_translations	= $mysqlPrefixSav . "recipes_measurements_translations";
$t_recipes_weekly_special		= $mysqlPrefixSav . "recipes_weekly_special";
$t_recipes_of_the_day			= $mysqlPrefixSav . "recipes_of_the_day";
$t_recipes_comments			= $mysqlPrefixSav . "recipes_comments";
$t_recipes_favorites			= $mysqlPrefixSav . "recipes_favorites";
$t_recipes_tags				= $mysqlPrefixSav . "recipes_tags";
$t_recipes_links			= $mysqlPrefixSav . "recipes_links";
$t_recipes_comments			= $mysqlPrefixSav . "recipes_comments";
$t_recipes_searches			= $mysqlPrefixSav . "recipes_searches";
$t_recipes_age_restrictions 	 	= $mysqlPrefixSav . "recipes_age_restrictions";
$t_recipes_age_restrictions_accepted	= $mysqlPrefixSav . "recipes_age_restrictions_accepted";

$t_recipes_pairing_loaded 		= $mysqlPrefixSav . "recipes_pairing_loaded";
$t_recipes_pairing_recipes		= $mysqlPrefixSav . "recipes_pairing_recipes";


$t_recipes_similar_loaded = $mysqlPrefixSav . "recipes_similar_loaded";
$t_recipes_similar_recipes = $mysqlPrefixSav . "recipes_similar_recipes";


$t_recipes_stats_views_per_month 	= $mysqlPrefixSav . "recipes_stats_views_per_month";
$t_recipes_stats_views_per_month_ips 	= $mysqlPrefixSav . "recipes_stats_views_per_month_ips";

$t_recipes_stats_views_per_year 	= $mysqlPrefixSav . "recipes_stats_views_per_year";
$t_recipes_stats_views_per_year_ips	= $mysqlPrefixSav . "recipes_stats_views_per_year_ips";

$t_recipes_stats_comments_per_month 	= $mysqlPrefixSav . "recipes_stats_comments_per_month";
$t_recipes_stats_comments_per_year 	= $mysqlPrefixSav . "recipes_stats_comments_per_year";

$t_recipes_stats_favorited_per_month 	= $mysqlPrefixSav . "recipes_stats_favorited_per_month";
$t_recipes_stats_favorited_per_year 	= $mysqlPrefixSav . "recipes_stats_favorited_per_year";

$t_recipes_stats_chef_of_the_month 	= $mysqlPrefixSav . "recipes_stats_chef_of_the_month";
$t_recipes_stats_chef_of_the_year 	= $mysqlPrefixSav . "recipes_stats_chef_of_the_year";

if($action == ""){
	echo"
	<h1>Tables</h1>


	<!-- Where am I? -->
	<p><b>You are here:</b><br />
	<a href=\"index.php?open=recipes&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Recipes</a>
	&gt;
	<a href=\"index.php?open=recipes&amp;page=tables&amp;editor_language=$editor_language&amp;l=$l\">Tables</a>
	</p>
	<!-- //Where am I? -->



	<!-- edb_liquidbase-->
	";
	$query = "SELECT * FROM $t_recipes_liquidbase LIMIT 1";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_recipes_liquidbase: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_recipes_liquidbase(
		  liquidbase_id INT NOT NULL AUTO_INCREMENT,
		  PRIMARY KEY(liquidbase_id), 
		   liquidbase_file VARCHAR(200), 
		   liquidbase_run_datetime DATETIME, 
		   liquidbase_run_saying VARCHAR(200))")
	  	 or die(mysqli_error());	
	}
	echo"
	<!-- edb_liquidbase-->


	<!-- Feedback -->
		";
		if($ft != "" && $fm != ""){
			if($fm == "changes_saved"){
				$fm = "$l_changes_saved";
			}
			else{
				$fm = ucfirst($fm);
			}
			echo"<div class=\"$ft\"><p>$fm</p></div>";
		}
		echo"
	<!-- //Feedback -->

	<!-- Run -->
		";
		$path = "_inc/recipes/_liquidbase_db_scripts";
		if(!(is_dir("$path"))){
			echo"$path doesnt exists";
			die;
		}
		if ($handle = opendir($path)) {
			$scripts = array();   
			while (false !== ($script = readdir($handle))) {
				if ($script === '.') continue;
				if ($script === '..') continue;
				array_push($scripts, $script);
			}
	
			sort($scripts);
			foreach ($scripts as $liquidbase_file){
				
				// Has it been executed?
				$inp_liquidbase_file_mysql = quote_smart($link, $liquidbase_file);
					
				$query = "SELECT liquidbase_id FROM $t_recipes_liquidbase WHERE liquidbase_file=$inp_liquidbase_file_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_liquidbase_id) = $row;
				if($get_liquidbase_id == ""){
					// Date
					$datetime = date("Y-m-d H:i:s");
					$run_saying = date("j M Y H:i");


					// Insert
					mysqli_query($link, "INSERT INTO $t_recipes_liquidbase 
					(liquidbase_id, liquidbase_file, liquidbase_run_datetime, liquidbase_run_saying) 
					VALUES 
					(NULL, $inp_liquidbase_file_mysql, '$datetime', '$run_saying')")
					or die(mysqli_error($link));

					// Run code
					include("_inc/recipes/_liquidbase_db_scripts/$liquidbase_file");
				} // not runned before
			} // foreach files
		} // handle opendir path
		echo"
	<!-- //Run -->

	<!-- liquidbase scripts -->
		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\">
			<span>File</span>
		   </th>
		   <th scope=\"col\">
			<span>Run date</span>
		   </th>
		   <th scope=\"col\">
			<span>Actions</span>
		   </th>
		  </tr>
		</thead>
		<tbody>
	";

	$query = "SELECT liquidbase_id, liquidbase_file, liquidbase_run_datetime, liquidbase_run_saying FROM $t_recipes_liquidbase ORDER BY liquidbase_id DESC";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_liquidbase_id, $get_liquidbase_file, $get_liquidbase_run_datetime, $get_liquidbase_run_saying) = $row;

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
			<span>$get_liquidbase_file</span>
		  </td>
		  <td class=\"$style\">
			<span>$get_liquidbase_run_saying</span>
		  </td>
		  <td class=\"$style\">
			<span>
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=delete&amp;liquidbase_id=$get_liquidbase_id&amp;editor_language=$editor_language\">$l_delete</a></span>
		  </td>
		 </tr>
		";

	}
	echo"
		 </tbody>
		</table>

	<!-- //liquidbase scripts -->
	";
}
elseif($action == "delete"){
	if(isset($_GET['liquidbase_id'])) {
		$liquidbase_id = $_GET['liquidbase_id'];
		$liquidbase_id  = strip_tags(stripslashes($liquidbase_id));
	}
	else{
		$liquidbase_id = "";
	}
	$liquidbase_id_mysql = quote_smart($link, $liquidbase_id);
	$query = "SELECT liquidbase_id, liquidbase_file, liquidbase_run_datetime FROM $t_recipes_liquidbase WHERE liquidbase_id=$liquidbase_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_liquidbase_id, $get_liquidbase_file, $get_liquidbase_run_datetime) = $row;

	if($get_liquidbase_id != ""){
		if($process == "1"){

			mysqli_query($link, "DELETE FROM $t_recipes_liquidbase WHERE liquidbase_id=$get_liquidbase_id") or die(mysqli_error($link));

			$url = "index.php?open=$open&page=$page&ft=success&fm=deleted";
			header("Location: $url");
			exit;
		}

		echo"
		<h1>Delete_liquidbase $get_liquidbase_file</h1>


		<p>
		Are you sure you want to dlete the liquidbase script run? 
		This will cause the script to run again after deletion. 
		</p>

		<p>
		<a href=\"index.php?open=$open&amp;page=$page&amp;action=delete&amp;liquidbase_id=$get_liquidbase_id&amp;editor_language=$editor_language&amp;process=1\" class=\"btn_warning\">Confirm delete</a>
		</p>
		";
	}
}

?>