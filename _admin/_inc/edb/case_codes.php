<?php
/**
*
* File: _admin/_inc/edb/case_codes.php
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


$t_edb_physical_locations_index		= $mysqlPrefixSav . "edb_physical_locations_index";
$t_edb_physical_locations_directories	= $mysqlPrefixSav . "edb_physical_locations_directories";

$t_edb_software_index	= $mysqlPrefixSav . "edb_software_index";

/*- Variables -------------------------------------------------------------------------- */
if(isset($_GET['code_id'])) {
	$code_id = $_GET['code_id'];
	$code_id = strip_tags(stripslashes($code_id));
}
else{
	$code_id = "";
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
	<h1>Case Codes</h1>


	<!-- Where am I? -->
		<p><b>You are here:</b><br />
		<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
		&gt;
		<a href=\"index.php?open=edb&amp;page=case_codes&amp;editor_language=$editor_language&amp;l=$l\">Case codes</a>
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
				<a href=\"index.php?open=edb&amp;page=case_codes&amp;action=new&amp;order_by=code_number&amp;order_method=$order_method&amp;editor_language=$editor_language&amp;l=$l\" class=\"btn_default\">New</a>
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
				<input type=\"hidden\" name=\"page\" value=\"case_codes\" />
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
               								url: \"_inc/edb/case_codes_search_jquery.php\",
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
				$order_by = "code_number";
			}
			if($order_by == "code_number" && $order_method == "asc"){
				$order_method_link = "desc";
			}
			else{
				$order_method_link = "asc";
			}

			echo"
			<span><a href=\"index.php?open=edb&amp;page=case_codes&amp;order_by=code_number&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>Number</b></a>";
			if($order_by == "code_number" && $order_method == "asc"){
				echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
			}
			if($order_by == "code_number" && $order_method == "desc"){
				echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
			}
	
			echo"</span>
		   </th>
		   <th scope=\"col\">";

			if($order_by == ""){
				$order_by = "code_title";
			}
			if($order_by == "code_title" && $order_method == "asc"){
				$order_method_link = "desc";
			}
			else{
				$order_method_link = "asc";
			}

			echo"
			<span><a href=\"index.php?open=edb&amp;page=case_codes&amp;order_by=code_title&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>Title</b></a>";
			if($order_by == "code_title" && $order_method == "asc"){
				echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
			}
			if($order_by == "code_title" && $order_method == "desc"){
				echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
			}
	
			echo"</span>
		   </th>
		  </tr>
		 </thead>
		 <tbody id=\"autosearch_search_results_hide\">

		";
		$query = "SELECT code_id, code_number, code_title, code_title_clean, code_gives_priority_id, code_gives_priority_title, code_times_used FROM $t_edb_case_codes";
		if($order_by == "code_number" OR $order_by == "code_title"){
			if($order_method  == "asc" OR $order_method == "desc"){
				$query = $query  . " ORDER BY $order_by $order_method";
			}
		}
		else{
		}


		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_code_id, $get_code_number, $get_code_title, $get_code_title_clean, $get_code_gives_priority_id, $get_code_gives_priority_title, $get_code_times_used) = $row;
			
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
				<a id=\"#code$get_code_id\"></a>
				<span>
				<a href=\"index.php?open=$open&amp;page=$page&amp;action=open_code&amp;code_id=$get_code_id&amp;l=$l&amp;editor_language=$editor_language\">$get_code_number</a>
				</span>
			  </td>
			  <td class=\"$style\">
				<span>
				<a href=\"index.php?open=$open&amp;page=$page&amp;action=open_code&amp;code_id=$get_code_id&amp;l=$l&amp;editor_language=$editor_language\">$get_code_title</a>
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

		$inp_number = $_POST['inp_number'];
		$inp_number = output_html($inp_number);
		$inp_number_mysql = quote_smart($link, $inp_number);

		$inp_title = $_POST['inp_title'];
		$inp_title = output_html($inp_title);
		$inp_title_mysql = quote_smart($link, $inp_title);

		$inp_title_clean = clean($inp_title);
		$inp_title_clean_mysql = quote_smart($link, $inp_title_clean);

		$inp_gives_priority_id = $_POST['inp_gives_priority_id'];
		$inp_gives_priority_id = output_html($inp_gives_priority_id);
		$inp_gives_priority_id_mysql = quote_smart($link, $inp_gives_priority_id);

		// Fetch priority title
		$query = "SELECT priority_id, priority_title FROM $t_edb_case_priorities WEHRE priority_id=$inp_gives_priority_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_priority_id, $get_priority_title) = $row;

		$inp_gives_priority_title_mysql = quote_smart($link, $get_priority_title);


		mysqli_query($link, "INSERT INTO $t_edb_case_codes
		(code_id, code_number, code_title, code_title_clean, code_gives_priority_id, code_gives_priority_title, code_times_used) 
		VALUES 
		(NULL, $inp_number_mysql, $inp_title_mysql, $inp_title_clean_mysql, $inp_gives_priority_id_mysql, $inp_gives_priority_title_mysql, 0)
		") or die(mysqli_error($link));

		$url = "index.php?open=edb&page=case_codes&action=new&order_by=$order_by&order_method=$order_method&editor_language=$editor_language&l=$l&ft=success&fm=created_code_$inp_number";
		header("Location: $url");
		exit;
	}
	echo"
	<h1>New case code</h1>


	<!-- Where am I? -->
		<p><b>You are here:</b><br />
		<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
		&gt;
		<a href=\"index.php?open=edb&amp;page=case_codes&amp;editor_language=$editor_language&amp;l=$l\">Case codes</a>
		&gt;
		<a href=\"index.php?open=edb&amp;page=case_codes&amp;action=new&amp;editor_language=$editor_language&amp;l=$l\">New</a>
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
			\$('[name=\"inp_number\"]').focus();
		});
		</script>
	<!-- //Focus -->

	<!-- New form -->";
		
		echo"
		<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
		<p>Number:<br />
		<input type=\"text\" name=\"inp_number\" value=\"\" size=\"25\" />
		</p>

		<p>Title:<br />
		<input type=\"text\" name=\"inp_title\" value=\"\" size=\"25\" />
		</p>

		<p>Gives priority:<br />
		<select name=\"inp_gives_priority_id\">";
		$query = "SELECT priority_id, priority_title FROM $t_edb_case_priorities ORDER BY priority_weight ASC";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_priority_id, $get_priority_title) = $row;
			echo"			<option value=\"$get_priority_id\">$get_priority_title</option>\n";

		}
		echo"
		</select>
		</p>

		<p><input type=\"submit\" value=\"Create\" class=\"btn_default\" /></p>

		</form>
	<!-- //New form -->

	";

} // new
elseif($action == "open_code"){
	// Find code
	$code_id_mysql = quote_smart($link, $code_id);
	$query = "SELECT code_id, code_number, code_title, code_title_clean, code_gives_priority_id, code_gives_priority_title, code_last_used_datetime, code_last_used_time, code_times_used FROM $t_edb_case_codes WHERE code_id=$code_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_code_id, $get_current_code_number, $get_current_code_title, $get_current_code_title_clean, $get_current_code_gives_priority_id, $get_current_code_gives_priority_title, $get_current_code_last_used_datetime, $get_current_code_last_used_time, $get_current_code_times_used) = $row;
	
	if($get_current_code_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{

	

		if($process == "1"){

			$inp_number = $_POST['inp_number'];
			$inp_number = output_html($inp_number);
			$inp_number_mysql = quote_smart($link, $inp_number);

			$inp_title = $_POST['inp_title'];
			$inp_title = output_html($inp_title);
			$inp_title_mysql = quote_smart($link, $inp_title);

			$inp_title_clean = clean($inp_title);
			$inp_title_clean_mysql = quote_smart($link, $inp_title_clean);

			$inp_gives_priority_id = $_POST['inp_gives_priority_id'];
			$inp_gives_priority_id = output_html($inp_gives_priority_id);
			$inp_gives_priority_id_mysql = quote_smart($link, $inp_gives_priority_id);

			// Fetch priority title
			$query = "SELECT priority_id, priority_title FROM $t_edb_case_priorities WEHRE priority_id=$inp_gives_priority_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_priority_id, $get_priority_title) = $row;

			$inp_gives_priority_title_mysql = quote_smart($link, $get_priority_title);


			$result = mysqli_query($link, "UPDATE $t_edb_case_codes SET 
					code_number=$inp_number_mysql, 
					code_title=$inp_title_mysql, 
					code_title_clean=$inp_title_clean_mysql, 
					code_gives_priority_id=$inp_gives_priority_id_mysql, 
					code_gives_priority_title=$inp_gives_priority_title_mysql
					 WHERE code_id=$get_current_code_id");



			$url = "index.php?open=edb&page=case_codes&action=open_code&code_id=$get_current_code_id&order_by=$order_by&order_method=$order_method&editor_language=$editor_language&l=$l&ft=success&fm=changes_saved";
			header("Location: $url");
			exit;
		}
		echo"
		<h1>$get_current_code_number $get_current_code_title</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=case_codes&amp;editor_language=$editor_language&amp;l=$l\">Case codes</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=case_codes&amp;action=open_code&amp;code_id=$get_current_code_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_code_number</a>
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
				\$('[name=\"inp_number\"]').focus();
			});
			</script>
		<!-- //Focus -->

		<!-- Edit form -->";
		
			echo"
			<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;code_id=$get_current_code_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
			<p>Number:<br />
			<input type=\"text\" name=\"inp_number\" value=\"$get_current_code_number\" size=\"25\" />
			</p>

			<p>Title:<br />
			<input type=\"text\" name=\"inp_title\" value=\"$get_current_code_title\" size=\"25\" />
			</p>

			<p>Gives priority:<br />
			<select name=\"inp_gives_priority_id\">";
			$query = "SELECT priority_id, priority_title FROM $t_edb_case_priorities ORDER BY priority_weight ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_priority_id, $get_priority_title) = $row;
				echo"			<option value=\"$get_priority_id\""; if($get_priority_id == "$get_current_code_gives_priority_id"){ echo" selected=\"selected\""; } echo">$get_priority_title</option>\n";

			}
			echo"
			</select>
			</p>

			<p><input type=\"submit\" value=\"Save\" class=\"btn_default\" />
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=delete&amp;code_id=$get_current_code_id&amp;l=$l\" class=\"btn_warning\">Delete</a>
			</p>
	
			</form>
		<!-- //New form -->

		";
	} // case found
} // open_code
elseif($action == "delete"){
	// Find code
	$code_id_mysql = quote_smart($link, $code_id);
	$query = "SELECT code_id, code_number, code_title, code_title_clean, code_gives_priority_id, code_gives_priority_title, code_last_used_datetime, code_last_used_time, code_times_used FROM $t_edb_case_codes WHERE code_id=$code_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_code_id, $get_current_code_number, $get_current_code_title, $get_current_code_title_clean, $get_current_code_gives_priority_id, $get_current_code_gives_priority_title, $get_current_code_last_used_datetime, $get_current_code_last_used_time, $get_current_code_times_used) = $row;
	
	if($get_current_code_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{

	

		if($process == "1"){



			$result = mysqli_query($link, "DELETE FROM $t_edb_case_codes WHERE code_id=$get_current_code_id") or die(mysqli_error($link));



			$url = "index.php?open=edb&page=$page&order_by=$order_by&order_method=$order_method&editor_language=$editor_language&l=$l&ft=success&fm=deleted";
			header("Location: $url");
			exit;

		}
		echo"
		<h1>$get_current_code_number $get_current_code_title</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=case_codes&amp;editor_language=$editor_language&amp;l=$l\">Case codes</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=case_codes&amp;action=open_code&amp;code_id=$get_current_code_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_code_number</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=case_codes&amp;action=open_code&amp;code_id=$get_current_code_id&amp;editor_language=$editor_language&amp;l=$l\">Delete</a>
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

		<!-- Delete -->
			<p>Are you sure you want to delete?</p>

			<p>
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;code_id=$get_current_code_id&amp;l=$l&amp;process=1\" class=\"btn_danger\">Confirm</a>
			</p>
		<!-- //Delete -->

		";
	} // case found
} // delete
?>