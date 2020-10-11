<?php
/**
*
* File: _admin/_inc/dashboard/navigation.php
* Version 2
* Date 15.18 03.03.2017
* Copyright (c) 2008-2017 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/*- Access check --------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}


/*- Variables ------------------------------------------------------------------------ */
if(isset($_GET['id'])) {
	$id = $_GET['id'];
	$id = strip_tags(stripslashes($id));
}
else{
	$id = "";
}
$tabindex = 0;

if($action == ""){
	echo"
	<h2>$l_navigation</h2>

	<!-- Feedback -->
	";
	if($ft != ""){
		if($fm == "changes_saved"){
			$fm = "$l_changes_saved";
		}
		elseif($fm == "navgation_item_deleted"){
			$fm = "$l_navgation_item_deleted";
		}
		
		echo"<div class=\"$ft\"><span>$fm</span></div>";
	}
	echo"	
	<!-- //Feedback -->

		
	<!-- Menu: Editor language, Actions -->
		<script>
		\$(function(){
			\$('#inp_l').on('change', function () {
				var url = \$(this).val(); // get selected value
				if (url) { // require a URL
 					window.location = url; // redirect
				}
				return false;
			});
		});
		</script>

		<div style=\"float: left\">
			<table>
			 <tr>
			  <td style=\"padding-right: 4px;\">
				<p>
				<a href=\"index.php?open=$open&amp;page=navigation&amp;action=new&amp;editor_language=$editor_language\"><img src=\"_design/gfx/icons/16x16/list-add.png\" alt=\"\" /></a>
				</p>
			  </td>
			  <td>
				<p>
				<a href=\"index.php?open=$open&amp;page=navigation&amp;action=new&amp;editor_language=$editor_language\">$l_new_menu_item</a>
				</p>
			  </td>
			 </tr>
			</table>
		</div>
		<div style=\"float: right;\">
			<p>
			<select id=\"inp_l\">\n";
			$query = "SELECT language_active_id, language_active_name, language_active_iso_two, language_active_flag, language_active_default FROM $t_languages_active";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_language_active_id, $get_language_active_name, $get_language_active_iso_two, $get_language_active_flag, $get_language_active_default) = $row;

	
				// No language selected?
				if($editor_language == ""){
						$editor_language = "$get_language_active_iso_two";
				}
				
				echo"	<option value=\"index.php?open=$open&amp;page=navigation&amp;editor_language=$get_language_active_iso_two&amp;l=$l\""; if($editor_language == "$get_language_active_iso_two"){ echo" selected=\"selected\"";}echo">$get_language_active_name</option>\n";
			}
			echo"
			</select>
			</p>
		</div>
		<div class=\"clear\"></div>
	<!-- //Menu -->
		
	<!-- Navigation list -->

		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\">
			<span>$l_title</span>
		   </th>
		   <th scope=\"col\">
			<span>$l_url</span>
		   </th>
		   <th scope=\"col\">
			<span>$l_actions</span>
		   </th>
		  </tr>
		</thead>
		<tbody>";



		// Select
		$editor_language_mysql = quote_smart($link, $editor_language);
		$query = "SELECT navigation_id, navigation_parent_id, navigation_title, navigation_url, navigation_weight FROM $t_navigation WHERE navigation_parent_id='0' AND navigation_language=$editor_language_mysql ORDER BY navigation_weight ASC";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_navigation_id, $get_navigation_parent_id, $get_navigation_title, $get_navigation_url, $get_navigation_weight) = $row;

			// Style
			if(isset($odd) && $odd == false){
				$odd = true;
			}
			else{
				$odd = false;
			}	

			echo"
			 <tr>
       			  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
          			<span>$get_navigation_title</span>
			  </td>
       			  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
				<span><a href=\"../$get_navigation_url\">$get_navigation_url</a></span>
			  </td>
       			  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
				<script type=\"text/javascript\">
				function confirmDelete$get_navigation_id() {
					if (confirm(\"$l_are_your_sure_you_want_to_delete_the_item\")) {
						return true;
					}
					else {
						return false;
					}
				}
			</script>

				<span>
				";
				if($get_navigation_weight == "0"){
					echo"<img src=\"_design/gfx/icons/16x16/go-up-transparent.png\" alt=\"Flytt opp\" />\n";
				}
				else{
					echo"<a href=\"index.php?open=$open&amp;page=navigation&amp;action=move_up&amp;id=$get_navigation_id&amp;editor_language=$editor_language&amp;process=1\"><img src=\"_design/gfx/icons/16x16/go-up.png\" alt=\"$l_up\" /></a>\n";
				}
				echo"<a href=\"index.php?open=$open&amp;page=navigation&amp;action=move_down&amp;id=$get_navigation_id&amp;editor_language=$editor_language&amp;process=1\"><img src=\"_design/gfx/icons/16x16/go-down.png\" alt=\"$l_down\" /></a>\n";
				echo"	
				<a href=\"index.php?open=$open&amp;page=navigation&amp;action=edit&amp;id=$get_navigation_id&amp;editor_language=$editor_language\"><img src=\"_design/gfx/icons/16x16/format-justify-left.png\" alt=\"$l_edit\" /></a>
				<a href=\"index.php?open=$open&amp;page=navigation&amp;action=delete&amp;id=$get_navigation_id&amp;editor_language=$editor_language&amp;process=1\" onClick=\"return confirmDelete$get_navigation_id();\"><img src=\"_design/gfx/icons/16x16/close_small_normal_hover.png\" alt=\"$l_delete\" /></a>
			</span>
		  </td>
     		 </tr>";

		// Children lvel 1
		$query_b = "SELECT navigation_id, navigation_parent_id, navigation_title, navigation_url, navigation_weight FROM $t_navigation WHERE navigation_parent_id=$get_navigation_id AND navigation_language=$editor_language_mysql ORDER BY navigation_weight ASC";
		$result_b = mysqli_query($link, $query_b);
		while($row_b = mysqli_fetch_row($result_b)) {
			list($get_b_navigation_id, $get_b_navigation_parent_id, $get_b_navigation_title, $get_b_navigation_url, $get_b_navigation_weight) = $row_b;

			// Style
			if(isset($odd) && $odd == false){
				$odd = true;
			}
			else{
				$odd = false;
			}

			echo"
			 <tr>
       			  <td "; if($odd == true){ echo" class=\"odd\""; } echo" style=\"padding-left: 10px;\">
				<span>$get_b_navigation_id</span>
       			  </td>
       			  <td "; if($odd == true){ echo" class=\"odd\""; } echo" style=\"padding-left: 10px;\">
          			<span>$get_b_navigation_title</span>
			  </td>
       			  <td "; if($odd == true){ echo" class=\"odd\""; } echo" style=\"padding-left: 10px;\">
				<span><a href=\"../$get_b_navigation_url\">$get_b_navigation_url</a></span>
			  </td>
       			  <td "; if($odd == true){ echo" class=\"odd\""; } echo" style=\"padding-left: 10px;\">
				<script type=\"text/javascript\">
				function confirmDelete$get_b_navigation_id() {
					if (confirm(\"$l_are_your_sure_you_want_to_delete_the_item\")) {
						return true;
					}
					else {
						return false;
					}
				}
				</script>
				<span>
				";
				if($get_b_navigation_weight == "0"){
					echo"<img src=\"_design/gfx/icons/16x16/go-up-transparent.png\" alt=\"Flytt opp\" />\n";
				}
				else{
					echo"<a href=\"index.php?open=$open&amp;page=navigation&amp;action=move_up&amp;id=$get_b_navigation_id&amp;editor_language=$editor_language&amp;process=1\"><img src=\"_design/gfx/icons/16x16/go-up.png\" alt=\"$l_up\" /></a>\n";
				}
				echo"<a href=\"index.php?open=$open&amp;page=navigation&amp;action=move_down&amp;id=$get_b_navigation_id&amp;editor_language=$editor_language&amp;process=1\"><img src=\"_design/gfx/icons/16x16/go-down.png\" alt=\"$l_down\" /></a>\n";
				echo"	
				<a href=\"index.php?open=$open&amp;page=navigation&amp;action=edit&amp;id=$get_b_navigation_id&amp;editor_language=$editor_language\"><img src=\"_design/gfx/icons/16x16/format-justify-left.png\" alt=\"$l_edit\" /></a>
				<a href=\"index.php?open=$open&amp;page=navigation&amp;action=delete&amp;id=$get_b_navigation_id&amp;editor_language=$editor_language&amp;process=1\" onClick=\"return confirmDelete$get_navigation_id();\"><img src=\"_design/gfx/icons/16x16/close_small_normal_hover.png\" alt=\"$l_delete\" /></a>
				</span>
			  </td>
     			 </tr>";

			// Children level 2
			$query_c = "SELECT navigation_id, navigation_parent_id, navigation_title, navigation_url, navigation_weight FROM $t_navigation WHERE navigation_parent_id=$get_b_navigation_id AND navigation_language=$editor_language_mysql ORDER BY navigation_weight ASC";
			$result_c = mysqli_query($link, $query_c);
			while($row_c = mysqli_fetch_row($result_c)) {
				list($get_c_navigation_id, $get_c_navigation_parent_id, $get_c_navigation_title, $get_c_navigation_url, $get_c_navigation_weight) = $row_c;

				// Style
				if(isset($odd) && $odd == false){
					$odd = true;
				}
				else{
					$odd = false;
				}

				echo"
				 <tr>
       				  <td "; if($odd == true){ echo" class=\"odd\""; } echo" style=\"padding-left: 20px;\">
					<span>$get_c_navigation_id</span>
       				  </td>
       				  <td "; if($odd == true){ echo" class=\"odd\""; } echo" style=\"padding-left: 20px;\">
          				<span>$get_c_navigation_title</span>
				  </td>
       				  <td "; if($odd == true){ echo" class=\"odd\""; } echo" style=\"padding-left: 20px;\">
					<span><a href=\"../$get_c_navigation_url\">$get_c_navigation_url</a></span>
			   	 </td>
       				  <td "; if($odd == true){ echo" class=\"odd\""; } echo" style=\"padding-left: 20px;\">
					<script type=\"text/javascript\">
					function confirmDelete$get_c_navigation_id() {
						if (confirm(\"$l_are_your_sure_you_want_to_delete_the_item\")) {
							return true;
						}
						else {
							return false;
						}
					}
					</script>

					<span>
					";
					if($get_c_navigation_weight == "0"){
						echo"<img src=\"_design/gfx/icons/16x16/go-up-transparent.png\" alt=\"Flytt opp\" />\n";
					}
					else{
						echo"<a href=\"index.php?open=$open&amp;page=navigation&amp;action=move_up&amp;id=$get_c_navigation_id&amp;editor_language=$editor_language&amp;process=1\"><img src=\"_design/gfx/icons/16x16/go-up.png\" alt=\"$l_up\" /></a>\n";
					}
					echo"<a href=\"index.php?open=$open&amp;page=navigation&amp;action=move_down&amp;id=$get_c_navigation_id&amp;editor_language=$editor_language&amp;process=1\"><img src=\"_design/gfx/icons/16x16/go-down.png\" alt=\"$l_down\" /></a>\n";
					echo"	
					<a href=\"index.php?open=$open&amp;page=navigation&amp;action=edit&amp;id=$get_c_navigation_id&amp;editor_language=$editor_language\"><img src=\"_design/gfx/icons/16x16/format-justify-left.png\" alt=\"$l_edit\" /></a>
					<a href=\"index.php?open=$open&amp;page=navigation&amp;action=delete&amp;id=$get_c_navigation_id&amp;editor_language=$editor_language&amp;process=1\" onClick=\"return confirmDelete$get_navigation_id();\"><img src=\"_design/gfx/icons/16x16/close_small_normal_hover.png\" alt=\"$l_delete\" /></a>
					</span>
				  </td>
     				 </tr>";
				} // select children level 2
			} // select children level 1

		} // Select
			echo"
		 </tbody>
		</table>
	<!-- //Navigation list -->
	";
}
elseif($action == "new"){
	if($process == "1"){

		$inp_language = $_POST['inp_language'];
		$inp_language = output_html($inp_language);
		$inp_language_mysql = quote_smart($link, $inp_language);
		$editor_language = $inp_language;
		
		// Transfer language 
		$language = "$inp_language";

		$inp_title = $_POST['inp_title'];
		$inp_title = output_html($inp_title);
		$inp_title_mysql = quote_smart($link, $inp_title);

		if($inp_title == ""){
			header("Location: index.php?open=$open&page=navigation&action=new&focus=inp_name&ft=warning&fm=please_enter_a_title&editor_language=$editor_language");
			exit;
		}

		$inp_slug = clean($inp_title);
		$inp_slug = output_html($inp_slug);
		$inp_slug_mysql = quote_smart($link, $inp_slug);


		$inp_url = $_POST['inp_url'];
		$inp_url = output_html($inp_url);
		$inp_url_mysql = quote_smart($link, $inp_url);

		$inp_url_parsed = parse_url($inp_url);
		$inp_url_scheme = "";
		$inp_url_host = "";
		if(isset($inp_url_parsed['scheme']) && isset($inp_url_parsed['host'])){
			$inp_url_scheme = $inp_url_parsed['scheme'];
			$inp_url_host = $inp_url_parsed['host'];
		}
		$inp_url_path = $inp_url_parsed['path'];
		$inp_url_query = $inp_url_parsed['query'];
		
		if($inp_url_query != ""){
			$inp_url_query = "?" . $inp_url_query;
		}
		
		if($inp_url_scheme == "http" OR $inp_url_scheme == "https"){
			$inp_url_path = "$inp_url_scheme://$inp_url_host$inp_url_path";
			$inp_url_query = "$inp_url_query";
			$inp_internal_or_external = "external";
		}
		else{
			$inp_internal_or_external = "internal";
		}
		$inp_url_path = output_html($inp_url_path);
		$inp_url_path_mysql = quote_smart($link, $inp_url_path);

		$inp_url_query = output_html($inp_url_query);
		$inp_url_query_mysql = quote_smart($link, $inp_url_query);

		$inp_parent = $_POST['inp_parent'];
		$inp_parent = output_html($inp_parent);
		$inp_parent_mysql = quote_smart($link, $inp_parent);

		$inp_created = date("Y-m-d");
		$inp_created_mysql = quote_smart($link, $inp_created);


		$inp_created_by_user_id = $_SESSION['admin_user_id'];
		$inp_created_by_user_id = output_html($inp_created_by_user_id);
		$inp_created_by_user_id_mysql = quote_smart($link, $inp_created_by_user_id);

		// Get weight
		$query = "SELECT count(*) FROM $t_navigation WHERE navigation_parent_id=$inp_parent_mysql AND navigation_language=$inp_language_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_count_rows) = $row;

		// Insert
		mysqli_query($link, "INSERT INTO $t_navigation 
		(navigation_id, navigation_parent_id, navigation_title, navigation_title_clean, navigation_url, navigation_url_path, navigation_url_query, navigation_language, navigation_internal_or_external,  navigation_weight, navigation_created, navigation_created_by_user_id) 
		VALUES 
		(NULL, $inp_parent_mysql, $inp_title_mysql, $inp_slug_mysql, $inp_url_mysql, $inp_url_path_mysql, $inp_url_query_mysql, $inp_language_mysql, '$inp_internal_or_external', '$get_count_rows', $inp_created_mysql, $inp_created_by_user_id_mysql)")
		or die(mysqli_error($link));


		header("Location: index.php?open=$open&page=navigation&action=new&focus=inp_name&ft=success&fm=menu_item_created&editor_language=$editor_language");
		exit;
	}
	echo"
	<h1>$l_new_menu_item</h1>
	<form method=\"post\" action=\"?open=$open&amp;page=navigation&amp;action=new&amp;process=1&amp;editor_language=$editor_language\" enctype=\"multipart/form-data\">
				
	
	<!-- Feedback -->
	";
	if($ft != ""){
		if($fm == "please_enter_a_title"){
			$fm = "$l_please_enter_a_title";
		}
		elseif($fm == "please_enter_url"){
			$fm = "$l_please_enter_url";
		}
		elseif($fm == "menu_item_created"){
			$fm = "$l_menu_item_created";
		}
		else{

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


	<p><b>$l_language</b>*<br />
	<select name=\"inp_language\" tabindex=\"";$tabindex=0; $tabindex=$tabindex+1;echo"$tabindex\" />";
		
	$query = "SELECT language_active_id, language_active_name, language_active_iso_two, language_active_flag, language_active_default FROM $t_languages_active";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_language_active_id, $get_language_active_name, $get_language_active_iso_two, $get_language_active_flag, $get_language_active_default) = $row;

		$flag_path 	= "_design/gfx/flags/16x16/$get_language_active_flag" . "_16x16.png";


		echo"	<option value=\"$get_language_active_iso_two\" style=\"background: url('$flag_path') no-repeat;padding-left: 20px;\"";if($editor_language == "$get_language_active_iso_two"){ echo" selected=\"selected\"";}echo">$get_language_active_name</option>\n";
		
	}
	echo"
	</select>
	</p>

	<p><b>$l_title</b>*<br />
	<input type=\"text\" name=\"inp_title\" value=\"\" size=\"60\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
	</p>
	
	<p><b>$l_url</b>*:<br />
	<input type=\"text\" name=\"inp_url\" value=\"\" size=\"60\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
	</p>

	<p><b>$l_parent</b>*<br />
	<select name=\"inp_parent\">
		<option value=\"0\" selected=\"selected\">$l_this_is_parent</option>
		<option value=\"0\">-</option>";
		
		$editor_language_mysql = quote_smart($link, $editor_language);
		$query = "SELECT navigation_id, navigation_title FROM $t_navigation WHERE navigation_parent_id='0' AND navigation_language=$editor_language_mysql";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_navigation_id, $get_navigation_title) = $row;

			echo"		<option value=\"$get_navigation_id\">$get_navigation_title</option>\n";

			// Sub
			$query_b = "SELECT navigation_id, navigation_title FROM $t_navigation WHERE navigation_parent_id='$get_navigation_id' AND navigation_editor_language=$editor_language_mysql";
			$result_b = mysqli_query($link, $query_b);
			while($row_b = mysqli_fetch_row($result_b)) {
				list($get_b_navigation_id, $get_b_navigation_title) = $row_b;
				echo"		<option value=\"$get_b_navigation_id\">&nbsp; $get_b_navigation_title</option>\n";

			}
		}
		echo"
	</select>
	</p>
	<p><input type=\"submit\" value=\"$l_create\" class=\"btn btn-success btn-sm\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
	 
	</form>


	<!-- Back -->
		<table>
		 <tr>
		  <td style=\"padding-right: 4px;\">
			<p>
			<a href=\"index.php?open=$open&amp;page=navigation\"><img src=\"_design/gfx/icons/16x16/go-previous.png\" alt=\"\" /></a>
			</p>
		  </td>
		  <td>
			<p>
			<a href=\"index.php?open=$open&amp;page=navigation&amp;editor_language=$editor_language\">$l_go_back</a>
			</p>
		  </td>
		 </tr>
		</table>
	<!-- //Back -->
	";

}
elseif($action == "edit"){
	$id_mysql = quote_smart($link, $id);

	$query = "SELECT navigation_id, navigation_parent_id, navigation_title, navigation_url, navigation_url_path, navigation_url_query, navigation_language FROM $t_navigation WHERE navigation_id=$id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_navigation_id, $get_navigation_parent_id, $get_navigation_title, $get_navigation_url, $get_navigation_url_path, $get_navigation_url_query, $get_navigation_language) = $row;

	if($get_navigation_id == ""){
		echo"
		<h1>Server error 404</h1>

		<p>
		Navigation item not found.
		</p>

		<p>
		<a href=\"index.php?open=$open&amp;page=navigation\">Home</a>
		</p>
		";
	}
	else{

		// Process
		if($process == "1"){

			$inp_language = $_POST['inp_language'];
			$inp_language = output_html($inp_language);
			$inp_language_mysql = quote_smart($link, $inp_language);
		
			// Transfer language 
			$editor_language = "$inp_language";

			$inp_title = $_POST['inp_title'];
			$inp_title = output_html($inp_title);
			$inp_title_mysql = quote_smart($link, $inp_title);

			if($inp_title == ""){
				header("Location: index.php?open=$open&page=navigation&action=edit&id=$id&ft=warning&fm=please_enter_a_title&editor_language=$editor_language");
				exit;
			}

			$inp_title_clean = clean($inp_title);
			$inp_title_clean = output_html($inp_title_clean);
			$inp_title_clean_mysql = quote_smart($link, $inp_title_clean);


			$inp_url = $_POST['inp_url'];
			$inp_url = output_html($inp_url);
			$inp_url_mysql = quote_smart($link, $inp_url);

			$inp_url_parsed = parse_url($inp_url);
			$inp_url_scheme = "";
			$inp_url_host = "";
			if(isset($inp_url_parsed['scheme']) && isset($inp_url_parsed['host'])){
				$inp_url_scheme = $inp_url_parsed['scheme'];
				$inp_url_host = $inp_url_parsed['host'];
			}
			$inp_url_path = $inp_url_parsed['path'];
			$inp_url_query = $inp_url_parsed['query'];
		
			if($inp_url_query != ""){
				$inp_url_query = "?" . $inp_url_query;
			}
		
			if($inp_url_scheme == "http" OR $inp_url_scheme == "https"){
				$inp_url_path = "$inp_url_scheme://$inp_url_host$inp_url_path";
				$inp_url_query = "$inp_url_query";
				$inp_internal_or_external = "external";
			}
			else{
				$inp_internal_or_external = "internal";
			}
			$inp_url_path = output_html($inp_url_path);
			$inp_url_path_mysql = quote_smart($link, $inp_url_path);

			$inp_url_query = output_html($inp_url_query);
			$inp_url_query_mysql = quote_smart($link, $inp_url_query);

			$inp_parent = $_POST['inp_parent'];
			$inp_parent = output_html($inp_parent);
			$inp_parent_mysql = quote_smart($link, $inp_parent);

			$inp_navigation_updated = date("Y-m-d");
			$inp_navigation_updated_mysql = quote_smart($link, $inp_navigation_updated);

			$inp_updated_by_user_id = $_SESSION['admin_user_id'];
			$inp_updated_by_user_id = output_html($inp_updated_by_user_id);
			$inp_updated_by_user_id_mysql = quote_smart($link, $inp_updated_by_user_id);
			
			// Update
			$result = mysqli_query($link, "UPDATE $t_navigation SET 
							navigation_parent_id=$inp_parent_mysql, 
							navigation_title=$inp_title_mysql, 
							navigation_title_clean=$inp_title_clean_mysql, 
							navigation_url=$inp_url_mysql, 
							navigation_url_path=$inp_url_path_mysql, 
							navigation_url_query=$inp_url_query_mysql, 
							navigation_language=$inp_language_mysql,
							navigation_internal_or_external='$inp_internal_or_external', 
							navigation_updated=$inp_navigation_updated_mysql, 	
							navigation_updated_by_user_id=$inp_updated_by_user_id_mysql 
							WHERE navigation_id=$id_mysql") or die(mysqli_error($link));
			
			
			// Move to index
			header("Location: index.php?open=$open&page=navigation&editor_language=$editor_language&ft=success&fm=changes_saved");
			exit;
		} // end process
			

		
		echo"
		<h1>$l_edit_menu_item</h1>
		<form method=\"post\" action=\"?open=$open&amp;page=navigation&amp;action=edit&amp;id=$id&amp;editor_language=$editor_language&amp;process=1\" enctype=\"multipart/form-data\">
				
	
		<!-- Feedback -->
			";
			if($ft != ""){
				if($fm == "please_enter_a_name"){
					$fm = "$l_please_enter_a_name";
				}
				elseif($fm == "changes_saved"){
					$fm = "$l_changes_saved";
				}
				else{
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



		<p><b>$l_language</b>*<br />
		<select name=\"inp_language\" tabindex=\"";$tabindex=0; $tabindex=$tabindex+1;echo"$tabindex\" />";
		$query = "SELECT language_active_id, language_active_name, language_active_iso_two, language_active_flag, language_active_default FROM $t_languages_active";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_language_active_id, $get_language_active_name, $get_language_active_iso_two, $get_language_active_flag, $get_language_active_default) = $row;

			$flag_path 	= "_design/gfx/flags/16x16/$get_language_active_flag" . "_16x16.png";
			echo"	<option value=\"$get_language_active_iso_two\" style=\"background: url('$flag_path') no-repeat;padding-left: 20px;\"";if($get_navigation_language == "$get_language_active_iso_two"){ echo" selected=\"selected\"";}echo">$get_language_active_name</option>\n";
		}
		echo"
		</select>
		</p>

		<p><b>$l_title</b>*<br />
		<input type=\"text\" name=\"inp_title\" value=\"$get_navigation_title\" size=\"60\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
		</p>
	
		<p><b>$l_url</b>*:<br />
		<input type=\"text\" name=\"inp_url\" value=\"$get_navigation_url\" size=\"60\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
		</p>

		<p><b>$l_parent</b>*<br />
		<select name=\"inp_parent\">
			<option value=\"0\""; if($get_navigation_parent_id == 0){ echo" selected=\"selected\""; } echo">$l_this_is_parent</option>
			<option value=\"0\">-</option>";
		
			$language_mysql = quote_smart($link, $editor_language);
			$query = "SELECT navigation_id, navigation_title FROM $t_navigation WHERE navigation_parent_id='0' AND navigation_language=$editor_language_mysql";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_navigation_id, $get_navigation_title) = $row;

				echo"			<option value=\"$get_navigation_id\""; if($get_navigation_parent_id == $get_navigation_id){ echo" selected=\"selected\""; } echo">$get_navigation_title</option>\n";

				// Sub
				$query_b = "SELECT navigation_id, navigation_title FROM $t_navigation WHERE navigation_parent_id='$get_navigation_id' AND navigation_language=$editor_language_mysql";
				$result_b = mysqli_query($link, $query_b);
				while($row_b = mysqli_fetch_row($result_b)) {
					list($get_b_navigation_id, $get_b_navigation_title) = $row_b;


					echo"			<option value=\"$get_b_navigation_id\""; if($get_navigation_parent_id == $get_b_navigation_id){ echo" selected=\"selected\""; } echo">&nbsp; $get_b_navigation_title</option>\n";

				}
			}
		echo"
		</select>
		</p>
	
		<p><input type=\"submit\" value=\"$l_edit\" class=\"btn btn-success btn-sm\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
			 
		</form>

		<!-- Back -->
			<table>
			 <tr>
			  <td style=\"padding-right: 4px;\">
				<p>
				<a href=\"index.php?open=$open&amp;page=navigation&amp;editor_language=$editor_language\"><img src=\"_design/gfx/icons/16x16/go-previous.png\" alt=\"\" /></a>
				</p>
			  </td>
			  <td>
				<p>
				<a href=\"index.php?open=$open&amp;page=navigation&amp;editor_language=$editor_language\">$l_go_back</a>
				</p>
			  </td>
			 </tr>
			</table>
		<!-- //Back -->
		";
	} // found
} // edit
elseif($action == "delete"){

	$id_mysql = quote_smart($link, $id);

	$query = "SELECT navigation_id, navigation_parent_id, navigation_title, navigation_url_path, navigation_url_query, navigation_language FROM $t_navigation WHERE navigation_id=$id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_navigation_id, $get_navigation_parent_id, $get_navigation_title, $get_navigation_url_path, $get_navigation_url_query, $get_navigation_language) = $row;

	if($get_navigation_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{
		$result = mysqli_query($link, "DELETE FROM $t_navigation WHERE navigation_id=$id_mysql");


		// Move to index
		header("Location: index.php?open=$open&page=navigation&editor_language=$editor_language&ft=success&fm=navgation_item_deleted");
		exit;
	} // file exists
}
elseif($action == "move_up"){

	$id_mysql = quote_smart($link, $id);

	$query = "SELECT navigation_id, navigation_parent_id, navigation_title, navigation_url_path, navigation_url_query, navigation_language, navigation_weight FROM $t_navigation WHERE navigation_id=$id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_navigation_id, $get_navigation_parent_id, $get_navigation_title, $get_navigation_url_path, $get_navigation_url_query, $get_navigation_language, $get_navigation_weight) = $row;

	if($get_navigation_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{
		
		$inp_navigation_weight = $get_navigation_weight-2;
		$result = mysqli_query($link, "UPDATE $t_navigation SET navigation_weight=$inp_navigation_weight WHERE navigation_id=$id_mysql");
			

		// Go trough entire menu, and order everything
		$count_a = 0;
		$count_b = 0;
		$count_c = 0;
		$editor_language_mysql = quote_smart($link, $editor_language);
		$query = "SELECT navigation_id, navigation_parent_id, navigation_title, navigation_url_path, navigation_url_query, navigation_weight FROM $t_navigation WHERE navigation_parent_id='0' AND navigation_language=$editor_language_mysql ORDER BY navigation_weight ASC";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_navigation_id, $get_navigation_parent_id, $get_navigation_title, $get_navigation_url_path, $get_navigation_url_query, $get_navigation_weight) = $row;


			if($get_navigation_weight != $count_a){
				$res = mysqli_query($link, "UPDATE $t_navigation SET navigation_weight=$count_a WHERE navigation_id=$get_navigation_id");
			}

			$query_b = "SELECT navigation_id, navigation_parent_id, navigation_title, navigation_url_path, navigation_url_query, navigation_weight FROM $t_navigation WHERE navigation_parent_id=$get_navigation_id AND navigation_language=$editor_language_mysql ORDER BY navigation_weight ASC";
			$result_b = mysqli_query($link, $query_b);
			while($row_b = mysqli_fetch_row($result_b)) {
				list($get_b_navigation_id, $get_b_navigation_parent_id, $get_b_navigation_title, $get_b_navigation_url_path, $get_b_navigation_url_query, $get_b_navigation_weight) = $row_b;


				if($get_b_navigation_weight != $count_b){
					$res = mysqli_query($link, "UPDATE $t_navigation SET navigation_weight=$count_b WHERE navigation_id=$get_b_navigation_id");
				}

				// Children level 2
				$query_c = "SELECT navigation_id, navigation_parent_id, navigation_title, navigation_url_path, navigation_url_query, navigation_weight FROM $t_navigation WHERE navigation_parent_id=$get_b_navigation_id AND navigation_language=$editor_language_mysql ORDER BY navigation_weight ASC";
				$result_c = mysqli_query($link, $query_c);
				while($row_c = mysqli_fetch_row($result_c)) {
					list($get_c_navigation_id, $get_c_navigation_parent_id, $get_c_navigation_title, $get_c_navigation_url_path, $get_c_navigation_url_query, $get_c_navigation_weight) = $row_c;


					if($get_c_navigation_weight != $count_c){
						$res = mysqli_query($link, "UPDATE $t_navigation SET navigation_weight=$count_c WHERE navigation_id=$get_c_navigation_id");
					}

					$count_c++;
				}

				$count_b++;
			}


			$count_a++;
		}


		// Move to index
		header("Location: index.php?open=$open&page=navigation&editor_language=$editor_language");
		exit;
	} // file exists
}
elseif($action == "move_down"){


	$id_mysql = quote_smart($link, $id);

	$query = "SELECT navigation_id, navigation_parent_id, navigation_title, navigation_url_path, navigation_url_query, navigation_language, navigation_weight FROM $t_navigation WHERE navigation_id=$id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_navigation_id, $get_navigation_parent_id, $get_navigation_title, $get_navigation_url_path, $get_navigation_url_query, $get_navigation_language, $get_navigation_weight) = $row;

	if($get_navigation_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{
		
		$inp_navigation_weight = $get_navigation_weight+2;
		$result = mysqli_query($link, "UPDATE $t_navigation SET navigation_weight=$inp_navigation_weight WHERE navigation_id=$id_mysql");
			

		// Go trough entire menu, and order everything
		$count_a = 0;
		$count_b = 0;
		$count_c = 0;
		$editor_language_mysql = quote_smart($link, $editor_language);
		$query = "SELECT navigation_id, navigation_parent_id, navigation_title, navigation_url_path, navigation_url_query, navigation_weight FROM $t_navigation WHERE navigation_parent_id='0' AND navigation_language=$editor_language_mysql ORDER BY navigation_weight ASC";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_navigation_id, $get_navigation_parent_id, $get_navigation_title, $get_navigation_url_path, $get_navigation_url_query, $get_navigation_weight) = $row;


			if($get_navigation_weight != $count_a){
				$res = mysqli_query($link, "UPDATE $t_navigation SET navigation_weight=$count_a WHERE navigation_id=$get_navigation_id");
			}

			$query_b = "SELECT navigation_id, navigation_parent_id, navigation_title, navigation_url_path, navigation_url_query, navigation_weight FROM $t_navigation WHERE navigation_parent_id=$get_navigation_id AND navigation_language=$editor_language_mysql ORDER BY navigation_weight ASC";
			$result_b = mysqli_query($link, $query_b);
			while($row_b = mysqli_fetch_row($result_b)) {
				list($get_b_navigation_id, $get_b_navigation_parent_id, $get_b_navigation_title, $get_b_navigation_url_path, $get_b_navigation_url_query,, $get_b_navigation_weight) = $row_b;


				if($get_b_navigation_weight != $count_b){
					$res = mysqli_query($link, "UPDATE $t_navigation SET navigation_weight=$count_b WHERE navigation_id=$get_b_navigation_id");
				}

				// Children level 2
				$query_c = "SELECT navigation_id, navigation_parent_id, navigation_title, navigation_url_path, navigation_url_query, navigation_weight FROM $t_navigation WHERE navigation_parent_id=$get_b_navigation_id AND navigation_language=$editor_language_mysql ORDER BY navigation_weight ASC";
				$result_c = mysqli_query($link, $query_c);
				while($row_c = mysqli_fetch_row($result_c)) {
					list($get_c_navigation_id, $get_c_navigation_parent_id, $get_c_navigation_title, $get_c_navigation_url_path, $get_c_navigation_url_query, $get_c_navigation_weight) = $row_c;


					if($get_c_navigation_weight != $count_c){
						$res = mysqli_query($link, "UPDATE $t_navigation SET navigation_weight=$count_c WHERE navigation_id=$get_c_navigation_id");
					}

					$count_c++;
				}

				$count_b++;
			}


			$count_a++;
		}


		// Move to index
		header("Location: index.php?open=$open&page=navigation&editor_language=$editor_language");
		exit;
	} // file exists
}
?>