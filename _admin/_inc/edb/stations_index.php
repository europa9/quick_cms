<?php
/**
*
* File: _admin/_inc/edb/stations_index.php
* Version 11:55 30.12.2017
* Copyright (c) 2008-2017 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}
/*- Tables ---------------------------------------------------------------------------- */
$t_edb_case_index		= $mysqlPrefixSav . "edb_case_index";
$t_edb_case_codes		= $mysqlPrefixSav . "edb_case_codes";
$t_edb_case_statuses		= $mysqlPrefixSav . "edb_case_statuses";
$t_edb_case_priorities		= $mysqlPrefixSav . "edb_case_priorities";

$t_edb_districts_index		= $mysqlPrefixSav . "edb_districts_index";
$t_edb_districts_members	= $mysqlPrefixSav . "edb_districts_members";

$t_edb_stations_index		= $mysqlPrefixSav . "edb_stations_index";
$t_edb_stations_members		= $mysqlPrefixSav . "edb_stations_members";
$t_edb_stations_directories	= $mysqlPrefixSav . "edb_stations_directories";


$t_edb_software_index	= $mysqlPrefixSav . "edb_software_index";

/*- Variables -------------------------------------------------------------------------- */
if(isset($_GET['station_id'])) {
	$station_id = $_GET['station_id'];
	$station_id = strip_tags(stripslashes($station_id));
}
else{
	$station_id = "";
}
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
	if($order_method != "asc" && $order_method != "desc"){
		echo"Wrong order method";
		die;
	}
}
else{
	$order_method = "asc";
}


if($action == ""){
	echo"
	<h1>Stations</h1>


	<!-- Where am I? -->
		<p><b>You are here:</b><br />
		<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
		&gt;
		<a href=\"index.php?open=edb&amp;page=stations_index&amp;editor_language=$editor_language&amp;l=$l\">Stations</a>
		</p>
	<!-- //Where am I? -->

	<!-- Feedback -->
		";
		if($ft != ""){
			if($fm == "changes_saved"){
				$fm = "$l_changes_saved";
			}
			else{
				$fm = str_replace("_", " ", $fm);
				$fm = ucfirst($fm);
			}
			echo"<div class=\"$ft\"><span>$fm</span></div>";
		}
		echo"	
	<!-- //Feedback -->

	<!-- Navigation + Search -->
		<table>
		 <tr>
		  <td>
			<!-- Navigation -->
				<p>
				<a href=\"index.php?open=edb&amp;page=$page&amp;action=new&amp;order_by=$;order_by&amp;order_method=$order_method&amp;editor_language=$editor_language&amp;l=$l\" class=\"btn_default\">New</a>
				</p>
			<!-- //Navigation -->
		  </td>
		  <td style=\"padding-left: 6px;\">
			<!-- Search -->
				<script>
				\$(document).ready(function(){
					\$('[name=\"inp_search_query\"]').focus();
				});
				</script>

				<form method=\"get\" action=\"index.php\" enctype=\"multipart/form-data\">
			
				<p>
				<input type=\"text\" name=\"inp_search_query\" id=\"autosearch_inp_search_query\" size=\"20\" value=\"Search...\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
				<input type=\"hidden\" name=\"open\" value=\"edb\" />
				<input type=\"hidden\" name=\"page\" value=\"$page\" />
				<input type=\"hidden\" name=\"order_by\" value=\"$order_by\" />
				<input type=\"hidden\" name=\"order_method\" value=\"$order_method\" />
				<input type=\"hidden\" name=\"editor_language\" value=\"$editor_language\" />
				<input type=\"hidden\" name=\"l\" value=\"$l\" />
				</p>
		
				</form>
				<!-- Search script -->
					<script id=\"source\" language=\"javascript\" type=\"text/javascript\">
					\$(document).ready(function () {
						\$('#autosearch_inp_search_query').keyup(function () {
							$(\"#autosearch_search_results_show\").show();
							$(\"#autosearch_search_results_hide\").hide();


       							// getting the value that user typed
       							var searchString    = $(\"#autosearch_inp_search_query\").val();
 							// forming the queryString
      							var data            = 'l=$l&q='+ searchString;
         
        						// if searchString is not empty
        						if(searchString) {
								// Start with Search...
								if (searchString.match(\"^Search...\")) {
									searchString = searchString.replace('Search...', '');
									\$('#autosearch_inp_search_query').val(searchString);
								}
								// Ends with Search...
								if (searchString.endsWith(\"Search...\")) {
									searchString = searchString.replace('Search...', '');
									\$('#autosearch_inp_search_query').val(searchString);
								}

           							// ajax call
            							\$.ajax({
                							type: \"POST\",
               								url: \"_inc/edb/stations_index_search_jquery.php\",
                							data: data,
									beforeSend: function(html) { // this happens before actual call
										\$(\"#autosearch_search_results_show\").html(''); 
									},
               								success: function(html){
                    								\$(\"#autosearch_search_results_show\").append(html);
              								}
            							});
       							}
        						return false;
            					});
         				   });
					</script>
				<!-- //Search script -->
			<!-- //Search -->
		  </td>
		 </tr>
		</table>
	<!-- //Navigation + Search -->


	<!-- Case codes -->

		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\" style=\"width: 40%;\">";

			if($order_by == ""){
				$order_by = "station_title";
			}
			if($order_by == "station_title" && $order_method == "asc"){
				$order_method_link = "desc";
			}
			else{
				$order_method_link = "asc";
			}

			echo"
			<span><a href=\"index.php?open=edb&amp;page=$page&amp;order_by=station_title&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>Title</b></a>";
			if($order_by == "station_title" && $order_method == "asc"){
				echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
			}
			if($order_by == "station_title" && $order_method == "desc"){
				echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
			}
	
			echo"</span>
		   </th>
		  </tr>
		 </thead>
		 <tbody id=\"autosearch_search_results_hide\">

		";
		$query = "SELECT station_id, station_title, station_title_clean, station_number_of_cases_now FROM $t_edb_stations_index";
		if($order_by == "station_title"){
			if($order_method  == "asc" OR $order_method == "desc"){
				$query = $query  . " ORDER BY $order_by $order_method";
			}
		}
		else{
		}


		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_station_id, $get_station_title, $get_station_title_clean, $get_station_number_of_cases_now) = $row;
			
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
				<a id=\"#station$get_station_id\"></a>
				<span>
				<a href=\"index.php?open=$open&amp;page=$page&amp;action=open_station&amp;station_id=$get_station_id&amp;l=$l&amp;editor_language=$editor_language\">$get_station_title</a>
				</span>
			  </td>
			 </tr>";
		} // while
		
		echo"
		 </tbody>
		</table>
		<table class=\"hor-zebra\" id=\"autosearch_search_results_show\">
		</table>
	<!-- //Case codes -->
	";
} // action == ""
elseif($action == "new"){
	if($process == "1"){

		$inp_title = $_POST['inp_title'];
		$inp_title = output_html($inp_title);
		$inp_title_mysql = quote_smart($link, $inp_title);

		$inp_title_clean = clean($inp_title);
		$inp_title_clean_mysql = quote_smart($link, $inp_title_clean);

		$inp_district_id = $_POST['inp_district_id'];
		$inp_district_id = output_html($inp_district_id);
		$inp_district_id_mysql = quote_smart($link, $inp_district_id);

		$query = "SELECT district_id, district_number, district_title, district_title_clean, district_icon_path, district_icon_16, district_icon_32, district_icon_260, district_number_of_stations, district_number_of_cases_now FROM $t_edb_districts_index WHERE district_id=$inp_district_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_district_id, $get_current_district_number, $get_current_district_title, $get_current_district_title_clean, $get_current_district_icon_path, $get_current_district_icon_16, $get_current_district_icon_32, $get_current_district_icon_260, $get_current_district_number_of_stations, $get_current_district_number_of_cases_now) = $row;
	
		$inp_district_title_mysql = quote_smart($link, $get_current_district_title);
		
		mysqli_query($link, "INSERT INTO $t_edb_stations_index
		(station_id, station_title, station_title_clean, station_district_id, station_district_title, station_number_of_cases_now) 
		VALUES 
		(NULL, $inp_title_mysql, $inp_title_clean_mysql, $inp_district_id_mysql, $inp_district_title_mysql, 0)
		") or die(mysqli_error($link));

		$url = "index.php?open=edb&page=$page&action=new&order_by=$order_by&order_method=$order_method&editor_language=$editor_language&l=$l&ft=success&fm=created_$inp_title";
		header("Location: $url");
		exit;
	}
	echo"
	<h1>New</h1>


	<!-- Where am I? -->
		<p><b>You are here:</b><br />
		<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
		&gt;
		<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Stations</a>
		&gt;
		<a href=\"index.php?open=edb&amp;page=$page&amp;action=new&amp;editor_language=$editor_language&amp;l=$l\">New</a>
		</p>
	<!-- //Where am I? -->

	<!-- Feedback -->
		";
		if($ft != ""){
			if($fm == "changes_saved"){
				$fm = "$l_changes_saved";
			}
			else{
				$fm = str_replace("_", " ", $fm);
				$fm = ucfirst($fm);
			}
			echo"<div class=\"$ft\"><span>$fm</span></div>";
		}
		echo"	
	<!-- //Feedback -->

	<!-- Focus -->
		<script>
		\$(document).ready(function(){
			\$('[name=\"inp_title\"]').focus();
		});
		</script>
	<!-- //Focus -->

	<!-- New form -->";
		
		echo"
		<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">


		<p>Title:<br />
		<input type=\"text\" name=\"inp_title\" value=\"\" size=\"25\" />
		</p>

		<p>District:<br />
		<select name=\"inp_district_id\">\n";
		$query = "SELECT district_id, district_title, district_title_clean, district_number_of_cases_now FROM $t_edb_districts_index ORDER BY district_title ASC";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_district_id, $get_district_title, $get_district_title_clean, $get_district_number_of_cases_now) = $row;
			echo"			";
			echo"<option value=\"$get_district_id\">$get_district_title</option>\n";
		}
		echo"</select>
		</p>

		<p><input type=\"submit\" value=\"Create\" class=\"btn_default\" /></p>

		</form>
	<!-- //New form -->

	";

} // new
elseif($action == "open_station"){
	// Find station
	$station_id_mysql = quote_smart($link, $station_id);
	$query = "SELECT station_id, station_number, station_title, station_title_clean, station_district_id, station_district_title, station_icon_path, station_icon_16, station_icon_32, station_icon_260, station_number_of_cases_now FROM $t_edb_stations_index WHERE station_id=$station_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_station_id, $get_current_station_number, $get_current_station_title, $get_current_station_title_clean, $get_current_station_district_id, $get_current_station_district_title, $get_current_station_icon_path, $get_current_station_icon_16, $get_current_station_icon_32, $get_current_station_icon_260, $get_current_station_number_of_cases_now) = $row;
	
	if($get_current_station_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{

	

		if($process == "1"){


			$inp_title = $_POST['inp_title'];
			$inp_title = output_html($inp_title);
			$inp_title_mysql = quote_smart($link, $inp_title);

			$inp_title_clean = clean($inp_title);
			$inp_title_clean_mysql = quote_smart($link, $inp_title_clean);

			$inp_district_id = $_POST['inp_district_id'];
			$inp_district_id = output_html($inp_district_id);
			$inp_district_id_mysql = quote_smart($link, $inp_district_id);

			$query = "SELECT district_id, district_number, district_title, district_title_clean, district_icon_path, district_icon_16, district_icon_32, district_icon_260, district_number_of_stations, district_number_of_cases_now FROM $t_edb_districts_index WHERE district_id=$inp_district_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_district_id, $get_current_district_number, $get_current_district_title, $get_current_district_title_clean, $get_current_district_icon_path, $get_current_district_icon_16, $get_current_district_icon_32, $get_current_district_icon_260, $get_current_district_number_of_stations, $get_current_district_number_of_cases_now) = $row;
	
			$inp_district_title_mysql = quote_smart($link, $get_current_district_title);
			
			$result = mysqli_query($link, "UPDATE $t_edb_stations_index SET 
					station_title=$inp_title_mysql, 
					station_title_clean=$inp_title_clean_mysql,
					station_district_id=$inp_district_id_mysql,
					station_district_title=$inp_district_title_mysql
					 WHERE station_id=$get_current_station_id") or die(mysqli_error($link));



			$url = "index.php?open=edb&page=$page&action=$action&station_id=$get_current_station_id&order_by=$order_by&order_method=$order_method&editor_language=$editor_language&l=$l&ft=success&fm=changes_saved";
			header("Location: $url");
			exit;
		}
		echo"
		<h1>$get_current_station_title</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Stations</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;station_id=$get_current_station_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_station_title</a>
			</p>
		<!-- //Where am I? -->

		<!-- Feedback -->
			";
			if($ft != ""){
				if($fm == "changes_saved"){
					$fm = "$l_changes_saved";
				}
				else{
					$fm = str_replace("_", " ", $fm);
					$fm = ucfirst($fm);
				}
				echo"<div class=\"$ft\"><span>$fm</span></div>";
			}
			echo"	
		<!-- //Feedback -->

		<!-- Focus -->
			<script>
			\$(document).ready(function(){
				\$('[name=\"inp_title\"]').focus();
			});
			</script>
		<!-- //Focus -->

		<!-- Edit form -->

			<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;station_id=$get_current_station_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
		
			<p>Title:<br />
			<input type=\"text\" name=\"inp_title\" value=\"$get_current_station_title\" size=\"25\" />
			</p>

			<p>District:<br />
			<select name=\"inp_district_id\">\n";

			$query = "SELECT district_id, district_title, district_title_clean, district_number_of_cases_now FROM $t_edb_districts_index ORDER BY district_title ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_district_id, $get_district_title, $get_district_title_clean, $get_district_number_of_cases_now) = $row;
				echo"			";
				echo"<option value=\"$get_district_id\""; if($get_current_station_district_id == "$get_district_id"){ echo" selected=\"selected\""; } echo">$get_district_title</option>\n";
			}
			echo"</select>
			</p>


			<p><input type=\"submit\" value=\"Save changes\" class=\"btn_default\" />
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=delete&amp;station_id=$get_current_station_id&amp;l=$l\" class=\"btn_warning\">Delete</a></p>
	
			</form>
		<!-- //New form -->

		";
	} // location found
} // open_location
elseif($action == "delete"){
	// Find code
	$station_id_mysql = quote_smart($link, $station_id);
	$query = "SELECT station_id, station_number, station_title, station_title_clean, station_district_id, station_district_title, station_icon_path, station_icon_16, station_icon_32, station_icon_260, station_number_of_cases_now FROM $t_edb_stations_index WHERE station_id=$station_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_station_id, $get_current_station_number, $get_current_station_title, $get_current_station_title_clean, $get_current_station_district_id, $get_current_station_district_title, $get_current_station_icon_path, $get_current_station_icon_16, $get_current_station_icon_32, $get_current_station_icon_260, $get_current_station_number_of_cases_now) = $row;
	
	if($get_current_station_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{
	

		if($process == "1"){



			$result = mysqli_query($link, "DELETE FROM $t_edb_stations_index WHERE station_id=$get_current_station_id") or die(mysqli_error($link));



			$url = "index.php?open=edb&page=$page&order_by=$order_by&order_method=$order_method&editor_language=$editor_language&l=$l&ft=success&fm=location_deleted";
			header("Location: $url");
			exit;
		}
		echo"
		<h1>$get_current_station_title</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Stations</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=open_location&amp;station_id=$get_current_station_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_station_title</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;station_id=$get_current_station_id&amp;editor_language=$editor_language&amp;l=$l\">Delete</a>
			</p>
		<!-- //Where am I? -->

		<!-- Feedback -->
			";
			if($ft != ""){
				if($fm == "changes_saved"){
					$fm = "$l_changes_saved";
				}
				else{
					$fm = str_replace("_", " ", $fm);
					$fm = ucfirst($fm);
				}
				echo"<div class=\"$ft\"><span>$fm</span></div>";
			}
			echo"	
		<!-- //Feedback -->

		<!-- Delete form -->
			<p>
			Are you sure you want to delete? The action cannot be undone.
			</p>

			<p>
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;station_id=$get_current_station_id&amp;l=$l&amp;process=1\" class=\"btn_danger\">Confirm</a>
			</p>
		<!-- //Delete form -->

		";
	} // station found
} // delete
?>