<?php
/**
*
* File: _admin/_inc/edb/item_types.php
* Version 15:01 10.08.2019
* Copyright (c) 2019 Sindre Andre Ditlefsen
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

$t_edb_item_types		= $mysqlPrefixSav . "edb_item_types";

$t_edb_software_index	= $mysqlPrefixSav . "edb_software_index";

/*- Variables -------------------------------------------------------------------------- */
if(isset($_GET['item_type_id'])) {
	$item_type_id = $_GET['item_type_id'];
	$item_type_id = strip_tags(stripslashes($item_type_id));
}
else{
	$item_type_id = "";
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
	<h1>Item types</h1>


	<!-- Where am I? -->
		<p><b>You are here:</b><br />
		<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
		&gt;
		<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Item types</a>
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
			
		  </td>
		 </tr>
		</table>
	<!-- //Navigation + Search -->


	<!-- Case codes -->

		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\">";

			if($order_by == ""){
				$order_by = "item_type_title";
			}
			if($order_by == "item_type_title" && $order_method == "asc"){
				$order_method_link = "desc";
			}
			else{
				$order_method_link = "asc";
			}

			echo"
			<span><a href=\"index.php?open=edb&amp;page=$page&amp;order_by=item_type_title&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>Title</b></a>";
			if($order_by == "item_type_title" && $order_method == "asc"){
				echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
			}
			if($order_by == "item_type_title" && $order_method == "desc"){
				echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
			}
	
			echo"</span>
		   </th>
		   <th scope=\"col\">";

			if($order_by == "item_type_has_hard_disk" && $order_method == "asc"){
				$order_method_link = "desc";
			}
			else{
				$order_method_link = "asc";
			}

			echo"
			<span><a href=\"index.php?open=edb&amp;page=$page&amp;order_by=item_type_has_hard_disks&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>Harddisk</b></a>";
			if($order_by == "item_type_has_hard_disks" && $order_method == "asc"){
				echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
			}
			if($order_by == "item_type_has_hard_disks" && $order_method == "desc"){
				echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
			}
	
			echo"</span>
		   </th>
		   <th scope=\"col\">";

			if($order_by == "item_type_has_sim_cards" && $order_method == "asc"){
				$order_method_link = "desc";
			}
			else{
				$order_method_link = "asc";
			}

			echo"
			<span><a href=\"index.php?open=edb&amp;page=$page&amp;order_by=item_type_has_sim_cards&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>Sim card</b></a>";
			if($order_by == "item_type_has_sim_cards" && $order_method == "asc"){
				echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
			}
			if($order_by == "item_type_has_sim_cards" && $order_method == "desc"){
				echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
			}
	
			echo"</span>
		   </th>
		   <th scope=\"col\">";

			if($order_by == "item_type_has_sd_cards" && $order_method == "asc"){
				$order_method_link = "desc";
			}
			else{
				$order_method_link = "asc";
			}

			echo"
			<span><a href=\"index.php?open=edb&amp;page=$page&amp;order_by=item_type_has_sd_cards&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>SD card</b></a>";
			if($order_by == "item_type_has_sd_cards" && $order_method == "asc"){
				echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
			}
			if($order_by == "item_type_has_sd_cards" && $order_method == "desc"){
				echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
			}
	
			echo"</span>
		   </th>
		   <th scope=\"col\">";

			if($order_by == "item_type_has_networks" && $order_method == "asc"){
				$order_method_link = "desc";
			}
			else{
				$order_method_link = "asc";
			}

			echo"
			<span><a href=\"index.php?open=edb&amp;page=$page&amp;order_by=item_type_has_networks&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>Networks</b></a>";
			if($order_by == "item_type_has_networks" && $order_method == "asc"){
				echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
			}
			if($order_by == "item_type_has_networks" && $order_method == "desc"){
				echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
			}
	
			echo"</span>
		   </th>
		   <th scope=\"col\">";

			if($order_by == "item_type_terms" && $order_method == "asc"){
				$order_method_link = "desc";
			}
			else{
				$order_method_link = "asc";
			}

			echo"
			<span><a href=\"index.php?open=edb&amp;page=$page&amp;order_by=item_type_terms&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>Terms</b></a>";
			if($order_by == "item_type_terms" && $order_method == "asc"){
				echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
			}
			if($order_by == "item_type_terms" && $order_method == "desc"){
				echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
			}
	
			echo"</span>
		   </th>
		  </tr>
		 </thead>
		 <tbody id=\"autosearch_search_results_hide\">

		";
		$query = "SELECT item_type_id, item_type_title, item_type_image_path, item_type_image_file, item_type_has_hard_disks, item_type_has_sim_cards, item_type_has_sd_cards, item_type_has_networks, item_type_terms FROM $t_edb_item_types";
		if($order_by == "item_type_title" OR $order_by == "item_type_has_hard_disks" OR $order_by == "item_type_has_sim_cards" OR $order_by == "item_type_has_sd_cards" OR $order_by == "item_type_has_networks" OR $order_by == "item_type_terms"){
			if($order_method  == "asc" OR $order_method == "desc"){
				$query = $query  . " ORDER BY $order_by $order_method";
			}
		}



		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_item_type_id, $get_item_type_title, $get_item_type_image_path, $get_item_type_image_file, $get_item_type_has_hard_disks, $get_item_type_has_sim_cards, $get_item_type_has_sd_cards, $get_item_type_has_networks, $get_item_type_terms) = $row;
			
			// Style
			if(isset($style) && $style == ""){
				$style = "odd";
			}
			else{
				$style = "";
			}
			
			// Terms 
			$get_item_type_terms = str_replace("<p>", "", $get_item_type_terms);
			$get_item_type_terms = str_replace("</p>", "", $get_item_type_terms);
			$get_item_type_terms = str_replace("<b>", "", $get_item_type_terms);
			$get_item_type_terms = str_replace("</b>", "", $get_item_type_terms);
			$get_item_type_terms = str_replace("<strong>", "", $get_item_type_terms);
			$get_item_type_terms = str_replace("</strong>", "", $get_item_type_terms);
			$get_item_type_terms = str_replace("<br />", " ", $get_item_type_terms);
			$get_item_type_terms_len = strlen($get_item_type_terms);
			if($get_item_type_terms_len > 40){
				$get_item_type_terms = substr($get_item_type_terms, 0, 40);
				$get_item_type_terms = htmlentities($get_item_type_terms);
				$get_item_type_terms = $get_item_type_terms . "...";
			}

			echo"
			 <tr>
			  <td class=\"$style\">
				<span>
				<a href=\"index.php?open=$open&amp;page=$page&amp;action=open&amp;item_type_id=$get_item_type_id&amp;l=$l&amp;editor_language=$editor_language\">$get_item_type_title</a>
				</span>
			  </td>
			  <td class=\"$style\">
				<span>";
				if($get_item_type_has_hard_disks == "0"){
					echo"No";
				}
				else{
					echo"Yes";
				}
				echo"
				</span>
			  </td>
			  <td class=\"$style\">
				<span>";
				if($get_item_type_has_sim_cards == "0"){
					echo"No";
				}
				else{
					echo"Yes";
				}
				echo"
				</span>
			  </td>
			  <td class=\"$style\">
				<span>";
				if($get_item_type_has_sd_cards == "0"){
					echo"No";
				}
				else{
					echo"Yes";
				}
				echo"
				</span>
			  </td>
			  <td class=\"$style\">
				<span>";
				if($get_item_type_has_networks == "0"){
					echo"No";
				}
				else{
					echo"Yes";
				}
				echo"
				</span>
			  </td>
			  <td class=\"$style\">
				<span>$get_item_type_terms</span>
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

		$inp_has_hard_disk = $_POST['inp_has_hard_disk'];
		$inp_has_hard_disk = output_html($inp_has_hard_disk);
		$inp_has_hard_disk_mysql = quote_smart($link, $inp_has_hard_disk);

		$inp_has_sim_card = $_POST['inp_has_sim_card'];
		$inp_has_sim_card = output_html($inp_has_sim_card);
		$inp_has_sim_card_mysql = quote_smart($link, $inp_has_sim_card);

		$inp_has_sd_card = $_POST['inp_has_sd_card'];
		$inp_has_sd_card = output_html($inp_has_sd_card);
		$inp_has_sd_card_mysql = quote_smart($link, $inp_has_sd_card);

		$inp_has_wifi_card = $_POST['inp_has_wifi_card'];
		$inp_has_wifi_card = output_html($inp_has_wifi_card);
		$inp_has_wifi_card_mysql = quote_smart($link, $inp_has_wifi_card);

		mysqli_query($link, "INSERT INTO $t_edb_item_types
		(item_type_id, item_type_title, item_type_image_path, item_type_image_file, item_type_has_hard_disks, item_type_has_sim_cards, item_type_has_sd_cards, item_type_has_networks) 
		VALUES 
		(NULL, $inp_title_mysql, '', '', $inp_has_hard_disk_mysql, $inp_has_sim_card_mysql, $inp_has_sd_card_mysql, $inp_has_wifi_card_mysql)
		") or die(mysqli_error($link));

		// Get ID
		$query = "SELECT item_type_id FROM $t_edb_item_types WHERE item_type_title=$inp_title_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_item_type_id) = $row;
	

		// Terms
		$inp_terms = $_POST['inp_terms'];
		$sql = "UPDATE $t_edb_item_types SET item_type_terms=? WHERE item_type_id='$get_current_item_type_id'";
		$stmt = $link->prepare($sql);
		$stmt->bind_param("s", $inp_terms);
		$stmt->execute();
		if ($stmt->errno) {
			echo "FAILURE!!! " . $stmt->error; die;
		}



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
		<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Item types</a>
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
		<!-- TinyMCE -->
			<script type=\"text/javascript\" src=\"_javascripts/tinymce/tinymce.min.js\"></script>
				<script>
				tinymce.init({
					selector: 'textarea.editor',
					plugins: 'print preview searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern help',
					toolbar: 'formatselect | bold italic strikethrough forecolor backcolor permanentpen formatpainter | link image media pageembed | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent | removeformat | addcomment',
					image_advtab: true,
					content_css: [
						'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
						'//www.tiny.cloud/css/codepen.min.css'
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

	<!-- New form -->";
		
		echo"
		<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

		<p>Title:<br />
		<input type=\"text\" name=\"inp_title\" value=\"\" size=\"25\" />
		</p>

		<p>Has hard disk:<br />
		<input type=\"radio\" name=\"inp_has_hard_disk\" value=\"1\" /> Yes
		&nbsp;
		<input type=\"radio\" name=\"inp_has_hard_disk\" value=\"0\" checked=\"checked\" /> No
		</p>

		<p>Has sim card:<br />
		<input type=\"radio\" name=\"inp_has_sim_card\" value=\"1\" /> Yes
		&nbsp;
		<input type=\"radio\" name=\"inp_has_sim_card\" value=\"0\" checked=\"checked\" /> No
		</p>

		<p>Has sd card:<br />
		<input type=\"radio\" name=\"inp_has_sd_card\" value=\"1\" /> Yes
		&nbsp;
		<input type=\"radio\" name=\"inp_has_sd_card\" value=\"0\" checked=\"checked\" /> No
		</p>

		<p>Has networks:<br />
		<input type=\"radio\" name=\"inp_has_wifi_card\" value=\"1\" /> Yes
		&nbsp;
		<input type=\"radio\" name=\"inp_has_wifi_card\" value=\"0\" checked=\"checked\" /> No
		</p>

		<p>Terms:<br />
		<textarea name=\"inp_terms\" rows=\"10\" cols=\"70\" class=\"editor\"></textarea>
		</p>


		<p><input type=\"submit\" value=\"Create\" class=\"btn_default\" /></p>

		</form>
	<!-- //New form -->

	";

} // new
elseif($action == "open"){
	// Find item type
	$item_type_id_mysql = quote_smart($link, $item_type_id);
	$query = "SELECT item_type_id, item_type_title, item_type_image_path, item_type_image_file, item_type_has_hard_disks, item_type_has_sim_cards, item_type_has_sd_cards, item_type_has_networks, item_type_terms FROM $t_edb_item_types WHERE item_type_id=$item_type_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_item_type_id, $get_current_item_type_title, $get_current_item_type_image_path, $get_current_item_type_image_file, $get_current_item_type_has_hard_disks, $get_current_item_type_has_sim_cards, $get_current_item_type_has_sd_cards, $get_current_item_type_has_networks, $get_current_item_type_terms) = $row;
	
	if($get_current_item_type_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{

	

		if($process == "1"){
			$inp_title = $_POST['inp_title'];
			$inp_title = output_html($inp_title);
			$inp_title_mysql = quote_smart($link, $inp_title);

			$inp_has_hard_disk = $_POST['inp_has_hard_disk'];
			$inp_has_hard_disk = output_html($inp_has_hard_disk);
			$inp_has_hard_disk_mysql = quote_smart($link, $inp_has_hard_disk);

			$inp_has_sim_card = $_POST['inp_has_sim_card'];
			$inp_has_sim_card = output_html($inp_has_sim_card);
			$inp_has_sim_card_mysql = quote_smart($link, $inp_has_sim_card);

			$inp_has_sd_card = $_POST['inp_has_sd_card'];
			$inp_has_sd_card = output_html($inp_has_sd_card);
			$inp_has_sd_card_mysql = quote_smart($link, $inp_has_sd_card);

			$inp_has_wifi_card = $_POST['inp_has_wifi_card'];
			$inp_has_wifi_card = output_html($inp_has_wifi_card);
			$inp_has_wifi_card_mysql = quote_smart($link, $inp_has_wifi_card);

			$result = mysqli_query($link, "UPDATE $t_edb_item_types SET 
					item_type_title=$inp_title_mysql, 
					item_type_has_hard_disks=$inp_has_hard_disk_mysql, 
					item_type_has_sim_cards=$inp_has_sim_card_mysql, 
					item_type_has_sd_cards=$inp_has_sd_card_mysql, 
					item_type_has_networks=$inp_has_wifi_card_mysql 
					 WHERE item_type_id=$get_current_item_type_id") or die(mysqli_error($link));


			// Terms
			$inp_terms = $_POST['inp_terms'];
			$sql = "UPDATE $t_edb_item_types SET item_type_terms=? WHERE item_type_id='$get_current_item_type_id'";
			$stmt = $link->prepare($sql);
			$stmt->bind_param("s", $inp_terms);
			$stmt->execute();
			if ($stmt->errno) {
				echo "FAILURE!!! " . $stmt->error; die;
			}


			$url = "index.php?open=edb&page=$page&action=$action&item_type_id=$get_current_item_type_id&order_by=$order_by&order_method=$order_method&editor_language=$editor_language&l=$l&ft=success&fm=changes_saved";
			header("Location: $url");
			exit;
		}
		echo"
		<h1>$get_current_item_type_title</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Item types</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;item_type_id=$get_current_item_type_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_item_type_title</a>
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

		<!-- TinyMCE -->
			<script type=\"text/javascript\" src=\"_javascripts/tinymce/tinymce.min.js\"></script>
				<script>
				tinymce.init({
					selector: 'textarea.editor',
					plugins: 'print preview searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern help',
					toolbar: 'formatselect | bold italic strikethrough forecolor backcolor permanentpen formatpainter | link image media pageembed | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent | removeformat | addcomment',
					image_advtab: true,
					content_css: [
						'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
						'//www.tiny.cloud/css/codepen.min.css'
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


		<!-- Edit form -->";
		
			echo"
			<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;item_type_id=$get_current_item_type_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
		

			<p>Title:<br />
			<input type=\"text\" name=\"inp_title\" value=\"$get_current_item_type_title\" size=\"25\" />
			</p>

			<p>Has hard disk:<br />
			<input type=\"radio\" name=\"inp_has_hard_disk\" value=\"1\""; if($get_current_item_type_has_hard_disks == "1"){ echo" checked=\"checked\""; } echo" /> Yes
			&nbsp;
			<input type=\"radio\" name=\"inp_has_hard_disk\" value=\"0\""; if($get_current_item_type_has_hard_disks == "0"){ echo" checked=\"checked\""; } echo" /> Yes
			</p>

			<p>Has sim card:<br />
			<input type=\"radio\" name=\"inp_has_sim_card\" value=\"1\""; if($get_current_item_type_has_sim_cards == "1"){ echo" checked=\"checked\""; } echo" /> Yes
			&nbsp;
			<input type=\"radio\" name=\"inp_has_sim_card\" value=\"0\""; if($get_current_item_type_has_sim_cards == "0"){ echo" checked=\"checked\""; } echo" /> No
			</p>

			<p>Has sd card:<br />
			<input type=\"radio\" name=\"inp_has_sd_card\" value=\"1\""; if($get_current_item_type_has_sd_cards == "1"){ echo" checked=\"checked\""; } echo" /> Yes
			&nbsp;
			<input type=\"radio\" name=\"inp_has_sd_card\" value=\"0\""; if($get_current_item_type_has_sd_cards == "0"){ echo" checked=\"checked\""; } echo" /> No
			</p>

			<p>Has networks:<br />
			<input type=\"radio\" name=\"inp_has_wifi_card\" value=\"1\""; if($get_current_item_type_has_networks == "1"){ echo" checked=\"checked\""; } echo" /> Yes
			&nbsp;
			<input type=\"radio\" name=\"inp_has_wifi_card\" value=\"0\""; if($get_current_item_type_has_networks == "0"){ echo" checked=\"checked\""; } echo" /> No
			</p>


			<p>Terms:<br />
			<textarea name=\"inp_terms\" rows=\"10\" cols=\"70\" class=\"editor\">$get_current_item_type_terms</textarea>
			</p>


			<p><input type=\"submit\" value=\"Save changes\" class=\"btn_default\" />
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=delete&amp;item_type_id=$get_current_item_type_id&amp;l=$l\" class=\"btn_warning\">Delete</a></p>
	
			</form>
		<!-- //New form -->

		";
	} // district found
} // open_district
elseif($action == "delete"){
	// Find item type
	$item_type_id_mysql = quote_smart($link, $item_type_id);
	$query = "SELECT item_type_id, item_type_title, item_type_image_path, item_type_image_file, item_type_has_sim_cards, item_type_has_sd_cards, item_type_has_networks FROM $t_edb_item_types WHERE item_type_id=$item_type_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_item_type_id, $get_current_item_type_title, $get_current_item_type_image_path, $get_current_item_type_image_file, $get_current_item_type_has_sim_cards, $get_current_item_type_has_sd_cards, $get_current_item_type_has_networks) = $row;
	
	if($get_current_item_type_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{


	

		if($process == "1"){



			$result = mysqli_query($link, "DELETE FROM $t_edb_item_types WHERE item_type_id=$get_current_item_type_id") or die(mysqli_error($link));



			$url = "index.php?open=edb&page=$page&order_by=$order_by&order_method=$order_method&editor_language=$editor_language&l=$l&ft=success&fm=deleted";
			header("Location: $url");
			exit;
		}
		echo"
		<h1>$get_current_item_type_title</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Item types</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=open_location&amp;item_type_id=$get_current_item_type_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_item_type_title</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;item_type_id=$get_current_item_type_id&amp;editor_language=$editor_language&amp;l=$l\">Delete</a>
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
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;item_type_id=$get_current_item_type_id&amp;l=$l&amp;process=1\" class=\"btn_danger\">Confirm</a>
			</p>
		<!-- //Delete form -->

		";
	} // item_type found
} // delete
?>