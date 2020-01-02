<?php
/**
*
* File: _admin/_inc/edb/software_index.php
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
if(isset($_GET['software_id'])) {
	$software_id = $_GET['software_id'];
	$software_id = strip_tags(stripslashes($software_id));
}
else{
	$software_id = "";
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
	<h1>Software index</h1>


	<!-- Where am I? -->
		<p><b>You are here:</b><br />
		<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
		&gt;
		<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Software index</a>
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

	<!-- Navigation -->
		<p>
		<a href=\"index.php?open=edb&amp;page=$page&amp;action=new&amp;order_by=$;order_by&amp;order_method=$order_method&amp;editor_language=$editor_language&amp;l=$l\" class=\"btn_default\">New</a>
		</p>
	<!-- //Navigation -->


	<!-- Active software -->
		<h2>Active software</h2>
		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\">
			<span><b>ID</b></span>
		   </th>
		   <th scope=\"col\">
			<span><b>Title</b></span>
		   </th>
		   <th scope=\"col\">
			<span><b>Version</b></span>
		   </th>
		   <th scope=\"col\">
			<span><b>Show in acquire list</b></span>
		   </th>
		  </tr>
		 </thead>

		";
		$query = "SELECT software_id, software_title, software_version, software_used_for, software_description, software_report_text, software_image_path, software_image_file, software_show_in_acquire_list FROM $t_edb_software_index WHERE software_show_in_acquire_list='1'";
		$query = $query  . " ORDER BY software_title ASC";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_software_id, $get_software_title, $get_software_version, $get_software_used_for, $get_software_description, $get_software_report_text, $get_software_image_path, $get_software_image_file, $get_software_show_in_acquire_list) = $row;
			
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
				<a id=\"#software$get_software_id\"></a>
				<span>
				<a href=\"index.php?open=$open&amp;page=$page&amp;action=edit&amp;software_id=$get_software_id&amp;l=$l&amp;editor_language=$editor_language\">$get_software_id</a>
				</span>
			  </td>
			  <td class=\"$style\">
				<a id=\"#software$get_software_id\"></a>
				<span>
				<a href=\"index.php?open=$open&amp;page=$page&amp;action=edit&amp;software_id=$get_software_id&amp;l=$l&amp;editor_language=$editor_language\">$get_software_title</a>
				</span>
			  </td>
			  <td class=\"$style\">
				<span>
				$get_software_version
				</span>
			  </td>
			  <td class=\"$style\">
				<span>
				";
				if($get_software_show_in_acquire_list == "1"){
					echo"Yes";
				}
				else{
					echo"No";
				}
				echo"
				</span>
			  </td>
			 </tr>";
		} // while
		
		echo"
		 </tbody>
		</table>
	<!-- //Active software -->


	<!-- Inactive software -->
		<hr />
		<h2>Inactive software</h2>
		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\">
			<span><b>ID</b></span>
		   </th>
		   <th scope=\"col\">
			<span><b>Title</b></span>
		   </th>
		   <th scope=\"col\">
			<span><b>Version</b></span>
		   </th>
		   <th scope=\"col\">
			<span><b>Show in acquire list</b></span>
		   </th>
		  </tr>
		 </thead>

		";
		$query = "SELECT software_id, software_title, software_version, software_used_for, software_description, software_report_text, software_image_path, software_image_file, software_show_in_acquire_list FROM $t_edb_software_index WHERE software_show_in_acquire_list='0'";
		$query = $query  . " ORDER BY software_title ASC";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_software_id, $get_software_title, $get_software_version, $get_software_used_for, $get_software_description, $get_software_report_text, $get_software_image_path, $get_software_image_file, $get_software_show_in_acquire_list) = $row;
			
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
				<a id=\"#software$get_software_id\"></a>
				<span>
				<a href=\"index.php?open=$open&amp;page=$page&amp;action=edit&amp;software_id=$get_software_id&amp;l=$l&amp;editor_language=$editor_language\">$get_software_id</a>
				</span>
			  </td>
			  <td class=\"$style\">
				<a id=\"#software$get_software_id\"></a>
				<span>
				<a href=\"index.php?open=$open&amp;page=$page&amp;action=edit&amp;software_id=$get_software_id&amp;l=$l&amp;editor_language=$editor_language\">$get_software_title</a>
				</span>
			  </td>
			  <td class=\"$style\">
				<span>
				$get_software_version
				</span>
			  </td>
			  <td class=\"$style\">
				<span>
				";
				if($get_software_show_in_acquire_list == "1"){
					echo"Yes";
				}
				else{
					echo"No";
				}
				echo"
				</span>
			  </td>
			 </tr>";
		} // while
		
		echo"
		 </tbody>
		</table>
	<!-- //Inactive software -->
	";
} // action == ""
elseif($action == "edit"){
	// Find
	$software_id_mysql = quote_smart($link, $software_id);
	$query = "SELECT software_id, software_title, software_version, software_used_for, software_description, software_report_text, software_image_path, software_image_file, software_show_in_acquire_list FROM $t_edb_software_index WHERE software_id=$software_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_software_id, $get_current_software_title, $get_current_software_version, $get_current_software_used_for, $get_current_software_description, $get_current_software_report_text, $get_current_software_image_path, $get_current_software_image_file, $get_current_software_show_in_acquire_list) = $row;
	
	if($get_current_software_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{

	

		if($process == "1"){


			$inp_title = $_POST['inp_title'];
			$inp_title = output_html($inp_title);
			$inp_title_mysql = quote_smart($link, $inp_title);

			$inp_version = $_POST['inp_version'];
			$inp_version = output_html($inp_version);
			$inp_version_mysql = quote_smart($link, $inp_version);

			$inp_used_for = $_POST['inp_used_for'];
			$inp_used_for = output_html($inp_used_for);
			$inp_used_for_mysql = quote_smart($link, $inp_used_for);

			$inp_description = $_POST['inp_description'];
			$inp_description = output_html($inp_description);
			$inp_description_mysql = quote_smart($link, $inp_description);

			$inp_show_in_acquire_list = $_POST['inp_show_in_acquire_list'];
			$inp_show_in_acquire_list = output_html($inp_show_in_acquire_list);
			$inp_show_in_acquire_list_mysql = quote_smart($link, $inp_show_in_acquire_list);

			$datetime = date("Y-m-d H:i:s");


			$result = mysqli_query($link, "UPDATE $t_edb_software_index SET 
					software_title=$inp_title_mysql, 
					software_version=$inp_version_mysql,
					software_used_for=$inp_used_for_mysql,
					software_description=$inp_description_mysql,
					software_show_in_acquire_list=$inp_show_in_acquire_list_mysql,
					software_updated_datetime='$datetime'
					 WHERE software_id=$get_current_software_id") or die(mysqli_error($link));


			$url = "index.php?open=edb&page=$page&action=$action&software_id=$get_current_software_id&order_by=$order_by&order_method=$order_method&editor_language=$editor_language&l=$l&ft=success&fm=changes_saved";
			header("Location: $url");
			exit;
		}
		echo"
		<h1>$get_current_software_title</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=software_index&amp;editor_language=$editor_language&amp;l=$l\">Software</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;software_id=$get_current_software_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_software_title</a>
			</p>
		<!-- //Where am I? -->

		<!-- Tabs -->
			<div class=\"tabs\">
				<ul>
					<li><a href=\"index.php?open=edb&amp;page=$page&amp;action=edit&amp;software_id=$get_current_software_id&amp;editor_language=$editor_language&amp;l=$l\" class=\"active\">General</a></li>
					<li><a href=\"index.php?open=edb&amp;page=$page&amp;action=edit_image&amp;software_id=$get_current_software_id&amp;editor_language=$editor_language&amp;l=$l\">Image</a></li>
					<li><a href=\"index.php?open=edb&amp;page=$page&amp;action=edit_report&amp;software_id=$get_current_software_id&amp;editor_language=$editor_language&amp;l=$l\">Report</a></li>
					<li><a href=\"index.php?open=edb&amp;page=$page&amp;action=delete&amp;software_id=$get_current_software_id&amp;editor_language=$editor_language&amp;l=$l\">Delete</a></li>
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
			<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;software_id=$get_current_software_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

			<p>Title:<br />
			<input type=\"text\" name=\"inp_title\" value=\"$get_current_software_title\" size=\"25\" style=\"width: 99%;\" />
			</p>

			<p>Version:<br />
			<input type=\"text\" name=\"inp_version\" value=\"$get_current_software_version\" size=\"10\" />
			</p>

			<p>Used for:<br />
			<select name=\"inp_used_for\">
				<option value=\"forensic_imaging_of_hard_drives_memory_cards_usb_sticks\""; if($get_current_software_used_for == "forensic_imaging_of_hard_drives_memory_cards_usb_sticks"){ echo" selected=\"selected\""; } echo">Forensic imaging of hard drives, memory cards and usb sticks</option>
				<option value=\"forensic_imaging_of_mobiles\""; if($get_current_software_used_for == "forensic_imaging_of_mobiles"){ echo" selected=\"selected\""; } echo">Forensic imaging of mobiles</option>v
				<option value=\"forensic_imaging_of_pc\""; if($get_current_software_used_for == "forensic_imaging_of_pc"){ echo" selected=\"selected\""; } echo">Forensic imaging of PC</option>
				<option value=\"forensic_imaging_of_windows\""; if($get_current_software_used_for == "forensic_imaging_of_windows"){ echo" selected=\"selected\""; } echo">Forensic imaging of Windows</option>
				<option value=\"forensic_imaging_of_linux\""; if($get_current_software_used_for == "forensic_imaging_of_linux"){ echo" selected=\"selected\""; } echo">Forensic imaging of Linux</option>
				<option value=\"forensic_imaging_of_windows_and_linux\""; if($get_current_software_used_for == "forensic_imaging_of_windows_and_linux"){ echo" selected=\"selected\""; } echo">Forensic imaging of Windows and Linux</option>
				<option value=\"forensic_imaging_of_mac\""; if($get_current_software_used_for == "forensic_imaging_of_mac"){ echo" selected=\"selected\""; } echo">Forensic imaging of Mac</option>
				<option value=\"forensic_imaging_of_video\""; if($get_current_software_used_for == "forensic_imaging_of_video"){ echo" selected=\"selected\""; } echo">Forensic imaging of video</option>
				<option value=\"forensic_imaging_of_hardware\""; if($get_current_software_used_for == "forensic_imaging_of_hardware"){ echo" selected=\"selected\""; } echo">Forensic imaging of hardware</option>
				<option value=\"other\""; if($get_current_software_used_for == "other"){ echo" selected=\"selected\""; } echo">Other</option>
			</select>
			</p>

			<p>Description:<br />
			<textarea name=\"inp_description\" rows=\"4\" cols=\"30\">";
			$get_current_software_description = str_replace("<br />", "\n", $get_current_software_description);
			echo"$get_current_software_description</textarea>
			</p>


			<p>Show in acquire list:<br />
			<select name=\"inp_show_in_acquire_list\">
				<option value=\"1\""; if($get_current_software_show_in_acquire_list == "1"){ echo" selected=\"selected\""; } echo">Yes</option>
				<option value=\"0\""; if($get_current_software_show_in_acquire_list == "0"){ echo" selected=\"selected\""; } echo">No</option>
			</select>
			</p>


			<p>
			<input type=\"submit\" value=\"Save changes\" class=\"btn_default\" />
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=copy&amp;software_id=$get_current_software_id&amp;l=$l\" class=\"btn_default\">Make copy</a>
			</p>
	
			</form>
		<!-- //Edit form -->


		";
	} // found
} // edit
elseif($action == "edit_image"){
	// Find
	$software_id_mysql = quote_smart($link, $software_id);
	$query = "SELECT software_id, software_title, software_version, software_used_for, software_description, software_report_text, software_image_path, software_image_file FROM $t_edb_software_index WHERE software_id=$software_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_software_id, $get_current_software_title, $get_current_software_version, $get_current_software_used_for, $get_current_software_description, $get_current_software_report_text, $get_current_software_image_path, $get_current_software_image_file) = $row;
	
	if($get_current_software_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{

	

		if($process == "1"){


			// Sjekk filen
			$file_name = basename($_FILES['inp_image']['name']);
			$file_exp = explode('.', $file_name); 
			$file_type = $file_exp[count($file_exp) -1]; 
			$file_type = strtolower("$file_type");

			// Finnes mappen?
			$upload_path = "../_uploads/edb/software_index";

			if(!(is_dir("../_uploads"))){
				mkdir("../_uploads");
			}
			if(!(is_dir("../_uploads/edb"))){
				mkdir("../_uploads/edb");
			}
			if(!(is_dir("../_uploads/edb/software_index"))){
				mkdir("../_uploads/edb/software_index");
			}

			// Sett variabler
			$new_name = $get_current_software_id . ".png";
			$target_path = $upload_path . "/" . $new_name;

			// Sjekk om det er en OK filendelse
			if($file_type == "jpg" OR $file_type == "jpeg" OR $file_type == "png" OR $file_type == "gif"){
				if(move_uploaded_file($_FILES['inp_image']['tmp_name'], $target_path)) {

					// Sjekk om det faktisk er et bilde som er lastet opp
					list($width,$height) = getimagesize($target_path);
					if(is_numeric($width) && is_numeric($height)){

						// Dette bildet er OK


						// image_path
						$inp_image_path = "_uploads/edb/software_index";
						$inp_image_path_mysql = quote_smart($link, $inp_image_path);

						// image
						$inp_image = $new_name;
						$inp_image_mysql = quote_smart($link, $inp_image);
						
						// Datetime
						$datetime = date("Y-m-d H:i:s");
				
						// Update MySQL
						$result = mysqli_query($link, "UPDATE $t_edb_software_index SET software_image_path=$inp_image_path_mysql, software_image_file=$inp_image_mysql, software_updated_datetime='$datetime' WHERE software_id=$software_id_mysql") or die(mysqli_error($link));

					
						$url = "index.php?open=edb&page=software_index&action=edit_image&software_id=$get_current_software_id&editor_language=$editor_language&l=$l&ft=success&fm=image_uploaded";
						header("Location: $url");
						exit;
					}
					else{
						// Dette er en fil som har fått byttet filendelse...
						unlink("$target_path");
	
						$url = "index.php?open=edb&page=software_index&action=edit_image&software_id=$get_current_software_id&editor_language=$editor_language&l=$l&ft=error&fm=file_is_not_an_image";
						header("Location: $url");
						exit;
					}
				}
				else{
					switch ($_FILES['inp_image'] ['error']){
					case 1:
						$url = "index.php?open=edb&page=software_index&action=edit_image&software_id=$get_current_software_id&editor_language=$editor_language&l=$l&ft=error&fm=to_big_file";
						header("Location: $url");
						exit;
						break;
					case 2:
						$url = "index.php?open=edb&page=software_index&action=edit_image&software_id=$get_current_software_id&editor_language=$editor_language&l=$l&ft=error&fm=to_big_file";
						header("Location: $url");
						exit;
						break;
					case 3:
						$url = "index.php?open=edb&page=software_index&action=edit_image&software_id=$get_current_software_id&editor_language=$editor_language&l=$l&ft=error&fm=only_parts_uploaded";
						header("Location: $url");
						exit;
						break;
					case 4:
						$url = "index.php?open=edb&page=software_index&action=edit_image&software_id=$get_current_software_id&editor_language=$editor_language&l=$l&ft=error&fm=no_file_uploaded";
						header("Location: $url");
						exit;
						break;
					}
				} // if(move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
			}
			else{
				$url = "index.php?open=edb&page=software_index&action=edit_image&software_id=$get_current_software_id&editor_language=$editor_language&l=$l&ft=error&fm=invalid_file_type&file_type=$file_type";
				header("Location: $url");
				exit;
			}
		}
		echo"
		<h1>$get_current_software_title</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=software_index&amp;editor_language=$editor_language&amp;l=$l\">Software</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;software_id=$get_current_software_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_software_title</a>
			</p>
		<!-- //Where am I? -->

		<!-- Tabs -->
			<div class=\"tabs\">
				<ul>
					<li><a href=\"index.php?open=edb&amp;page=$page&amp;action=edit&amp;software_id=$get_current_software_id&amp;editor_language=$editor_language&amp;l=$l\">General</a></li>
					<li><a href=\"index.php?open=edb&amp;page=$page&amp;action=edit_image&amp;software_id=$get_current_software_id&amp;editor_language=$editor_language&amp;l=$l\" class=\"active\">Image</a></li>
					<li><a href=\"index.php?open=edb&amp;page=$page&amp;action=edit_report&amp;software_id=$get_current_software_id&amp;editor_language=$editor_language&amp;l=$l\">Report</a></li>
					<li><a href=\"index.php?open=edb&amp;page=$page&amp;action=delete&amp;software_id=$get_current_software_id&amp;editor_language=$editor_language&amp;l=$l\">Delete</a></li>
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
			<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;software_id=$get_current_software_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

			";

			if(file_exists("../$get_current_software_image_path/$get_current_software_image_file") && $get_current_software_image_file != ""){
				echo"
				<p><b>Existing image:<br />
				<img src=\"../$get_current_software_image_path/$get_current_software_image_file\" alt=\"$get_current_software_image_file\" />
				</p>
				";
			}

			echo"
				
			<p><b>New image (256x256 png):</b><br />
			<input type=\"file\" name=\"inp_image\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
			</p>

			<p><input type=\"submit\" value=\"Save changes\" class=\"btn_default\" />
			</p>
	
			</form>
		<!-- //Edit form -->

		";
	} // found
} // edit_image
elseif($action == "edit_report"){
	// Find
	$software_id_mysql = quote_smart($link, $software_id);
	$query = "SELECT software_id, software_title, software_version, software_used_for, software_description, software_report_text, software_image_path, software_image_file FROM $t_edb_software_index WHERE software_id=$software_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_software_id, $get_current_software_title, $get_current_software_version, $get_current_software_used_for, $get_current_software_description, $get_current_software_report_text, $get_current_software_image_path, $get_current_software_image_file) = $row;
	
	if($get_current_software_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{

	

		if($process == "1"){

			$inp_report_text = $_POST['inp_report_text'];
			$sql = "UPDATE $t_edb_software_index SET software_report_text=? WHERE software_id=$get_current_software_id";
			$stmt = $link->prepare($sql);
			$stmt->bind_param("s", $inp_report_text);
			$stmt->execute();
			if ($stmt->errno) {
				echo "FAILURE!!! " . $stmt->error; die;
			}

			// Datetime
			$datetime = date("Y-m-d H:i:s");
			$result = mysqli_query($link, "UPDATE $t_edb_software_index SET software_updated_datetime='$datetime' WHERE software_id=$software_id_mysql") or die(mysqli_error($link));

	

			$url = "index.php?open=edb&page=$page&action=$action&software_id=$get_current_software_id&order_by=$order_by&order_method=$order_method&editor_language=$editor_language&l=$l&ft=success&fm=changes_saved";
			header("Location: $url");
			exit;
		}
		echo"
		<h1>$get_current_software_title</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=software_index&amp;editor_language=$editor_language&amp;l=$l\">Software</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;software_id=$get_current_software_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_software_title</a>
			</p>
		<!-- //Where am I? -->

		<!-- Tabs -->
			<div class=\"tabs\">
				<ul>
					<li><a href=\"index.php?open=edb&amp;page=$page&amp;action=edit&amp;software_id=$get_current_software_id&amp;editor_language=$editor_language&amp;l=$l\">General</a></li>
					<li><a href=\"index.php?open=edb&amp;page=$page&amp;action=edit_image&amp;software_id=$get_current_software_id&amp;editor_language=$editor_language&amp;l=$l\">Image</a></li>
					<li><a href=\"index.php?open=edb&amp;page=$page&amp;action=edit_report&amp;software_id=$get_current_software_id&amp;editor_language=$editor_language&amp;l=$l\" class=\"active\">Report</a></li>
					<li><a href=\"index.php?open=edb&amp;page=$page&amp;action=delete&amp;software_id=$get_current_software_id&amp;editor_language=$editor_language&amp;l=$l\">Delete</a></li>
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
					$fm = str_replace("_", " ", $fm);
					$fm = ucfirst($fm);
				}
				echo"<div class=\"$ft\"><span>$fm</span></div>";
			}
			echo"	
		<!-- //Feedback -->



		<!-- TinyMCE -->
			<script type=\"text/javascript\" src=\"_javascripts/tinymce/tinymce.min.js\"></script>
			<script>
				tinymce.init({
					selector: 'textarea.editor',
					plugins: 'print preview searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern help',
					toolbar: 'formatselect | bold italic strikethrough forecolor backcolor permanentpen formatpainter | link image media pageembed | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent | removeformat | addcomment',
					image_advtab: true,
					content_css: [
					],
					link_list: [
						{ title: 'My page 1', value: 'http://www.tinymce.com' },
						{ title: 'My page 2', value: 'http://www.moxiecode.com' }
					],
					image_list: [
						{ title: 'My page 1', value: 'http://www.tinymce.com' },
						{ title: 'My page 2', value: 'http://www.moxiecode.com' }
					],
						image_class_list: [
						{ title: 'None', value: '' },
						{ title: 'Some class', value: 'class-name' }
					],
					importcss_append: true,
					height: 500,
					file_picker_callback: function (callback, value, meta) {
						/* Provide file and text for the link dialog */
						if (meta.filetype === 'file') {
							callback('https://www.google.com/logos/google.jpg', { text: 'My text' });
						}
						/* Provide image and alt text for the image dialog */
						if (meta.filetype === 'image') {
							callback('https://www.google.com/logos/google.jpg', { alt: 'My alt text' });
						}
						/* Provide alternative source and posted for the media dialog */
						if (meta.filetype === 'media') {
							callback('movie.mp4', { source2: 'alt.ogg', poster: 'https://www.google.com/logos/google.jpg' });
						}
					}
				});
			</script>
		<!-- //TinyMCE -->
		<!-- Focus -->
			<script>
			\$(document).ready(function(){
				\$('[name=\"inp_software_report_text\"]').focus();
			});
			</script>
		<!-- //Focus -->

		<!-- Edit form -->
			<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;software_id=$get_current_software_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

			

			<p>
			<textarea name=\"inp_report_text\" rows=\"40\" cols=\"120\" class=\"editor\">$get_current_software_report_text</textarea>
			</p>

			<p><input type=\"submit\" value=\"Save changes\" class=\"btn_default\" />
			</p>
	
			</form>
		<!-- //Edit form -->

		";
	} // found
} // edit_report
elseif($action == "delete"){
	// Find
	$software_id_mysql = quote_smart($link, $software_id);
	$query = "SELECT software_id, software_title, software_version, software_used_for, software_description, software_report_text, software_image_path, software_image_file FROM $t_edb_software_index WHERE software_id=$software_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_software_id, $get_current_software_title, $get_current_software_version, $get_current_software_used_for, $get_current_software_description, $get_current_software_report_text, $get_current_software_image_path, $get_current_software_image_file) = $row;
	
	if($get_current_software_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{

	

		if($process == "1"){

			
			$result = mysqli_query($link, "DELETE FROM $t_edb_software_index WHERE software_id=$get_current_software_id") or die(mysqli_error($link));


			$url = "index.php?open=edb&page=$page&order_by=$order_by&order_method=$order_method&editor_language=$editor_language&l=$l&ft=success&fm=deleted";
			header("Location: $url");
			exit;
		}
		echo"
		<h1>$get_current_software_title</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=software_index&amp;editor_language=$editor_language&amp;l=$l\">Software</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;software_id=$get_current_software_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_software_title</a>
			</p>
		<!-- //Where am I? -->

		<!-- Tabs -->
			<div class=\"tabs\">
				<ul>
					<li><a href=\"index.php?open=edb&amp;page=$page&amp;action=edit&amp;software_id=$get_current_software_id&amp;editor_language=$editor_language&amp;l=$l\">General</a></li>
					<li><a href=\"index.php?open=edb&amp;page=$page&amp;action=edit_image&amp;software_id=$get_current_software_id&amp;editor_language=$editor_language&amp;l=$l\">Image</a></li>
					<li><a href=\"index.php?open=edb&amp;page=$page&amp;action=edit_report&amp;software_id=$get_current_software_id&amp;editor_language=$editor_language&amp;l=$l\">Report</a></li>
					<li><a href=\"index.php?open=edb&amp;page=$page&amp;action=delete&amp;software_id=$get_current_software_id&amp;editor_language=$editor_language&amp;l=$l\" class=\"active\">Delete</a></li>
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
					$fm = str_replace("_", " ", $fm);
					$fm = ucfirst($fm);
				}
				echo"<div class=\"$ft\"><span>$fm</span></div>";
			}
			echo"	
		<!-- //Feedback -->


		<!-- Delete -->
			
			<p>
			Are you sure you want to delete?
			</p>

			<p>
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;software_id=$get_current_software_id&amp;l=$l&amp;process=1\" class=\"btn_danger\">Confirm</a>
			</p>
	
		<!-- //Delete -->

		";
	} // found
} // delete
elseif($action == "new"){
	if($process == "1"){

		$inp_title = $_POST['inp_title'];
		$inp_title = output_html($inp_title);
		$inp_title_mysql = quote_smart($link, $inp_title);

		$inp_show_in_acquire_list = $_POST['inp_show_in_acquire_list'];
		$inp_show_in_acquire_list = output_html($inp_show_in_acquire_list);
		$inp_show_in_acquire_list_mysql = quote_smart($link, $inp_show_in_acquire_list);

		$datetime = date("Y-m-d H:i:s");

		mysqli_query($link, "INSERT INTO $t_edb_software_index
		(software_id, software_title, software_show_in_acquire_list, software_created_datetime) 
		VALUES 
		(NULL, $inp_title_mysql, $inp_show_in_acquire_list_mysql, '$datetime')")
		or die(mysqli_error($link));

		$url = "index.php?open=edb&page=$page&action=$action&editor_language=$editor_language&l=$l&ft=success&fm=saved";
		header("Location: $url");
		exit;
	}
	echo"
	<h1>New</h1>


	<!-- Where am I? -->
		<p><b>You are here:</b><br />
		<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
		&gt;
		<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Statuses</a>
		&gt;
		<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;editor_language=$editor_language&amp;l=$l\">New</a>
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

	<!-- New form -->
		<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

		<p>Title:<br />
		<input type=\"text\" name=\"inp_title\" value=\"\" size=\"25\" style=\"width: 99%;\" />
		</p>

		<p>Show in acquire list:<br />
		<select name=\"inp_show_in_acquire_list\">
			<option value=\"1\">Yes</option>
			<option value=\"0\">No</option>
		</select>
		</p>


		<p><input type=\"submit\" value=\"Create\" class=\"btn_default\" />
		</p>
	
		</form>
	<!-- //New form -->

	";
} // new
elseif($action == "copy"){
	// Find
	$software_id_mysql = quote_smart($link, $software_id);
	$query = "SELECT software_id, software_title, software_version, software_used_for, software_description, software_report_text, software_image_path, software_image_file, software_show_in_acquire_list FROM $t_edb_software_index WHERE software_id=$software_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_software_id, $get_current_software_title, $get_current_software_version, $get_current_software_used_for, $get_current_software_description, $get_current_software_report_text, $get_current_software_image_path, $get_current_software_image_file, $get_current_software_show_in_acquire_list) = $row;
	
	if($get_current_software_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{

		$inp_title_mysql = quote_smart($link, $get_current_software_title);

		$inp_version_mysql = quote_smart($link, $get_current_software_version);

		$inp_used_for_mysql = quote_smart($link, $get_current_software_used_for);

		$inp_description_mysql = quote_smart($link, $get_current_software_description);

		$inp_show_in_acquire_list_mysql = quote_smart($link, $get_current_software_show_in_acquire_list);

		$inp_image_path_mysql = quote_smart($link, $get_current_software_image_path);

		$inp_image_file_mysql = quote_smart($link, $get_current_software_image_file);

		

		$datetime = date("Y-m-d H:i:s");

		mysqli_query($link, "INSERT INTO $t_edb_software_index
		(software_id, software_title, software_version, software_used_for, software_description, software_image_path, software_image_file, software_show_in_acquire_list, software_created_datetime) 
		VALUES 
		(NULL, $inp_title_mysql, $inp_version_mysql, $inp_used_for_mysql, $inp_description_mysql, $inp_image_path_mysql, $inp_image_file_mysql, $inp_show_in_acquire_list_mysql, '$datetime')")
		or die(mysqli_error($link));
		
		// Get ID
		$query = "SELECT software_id FROM $t_edb_software_index WHERE software_created_datetime='$datetime'";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_software_id) = $row;
	
		$sql = "UPDATE $t_edb_software_index SET software_report_text=? WHERE software_id=$get_current_software_id";
		$stmt = $link->prepare($sql);
		$stmt->bind_param("s", $get_current_software_report_text);
		$stmt->execute();
		if ($stmt->errno) {
			echo "FAILURE!!! " . $stmt->error; die;
		}
		
		// Header
		echo"
		<h1><img src=\"_design/gfx/loading_22.gif\" alt=\"loading_22.gif\" /> Making copy</h1>
		<meta http-equiv=refresh content=\"0; url=index.php?open=$open&amp;page=$page&amp;action=edit&amp;software_id=$get_current_software_id&amp;l=$l&amp;ft=info&amp;fm=your_now_woring_on_a_copy\">
		";

	}
}
?>