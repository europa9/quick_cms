<?php
/**
*
* File: _admin/_inc/settings/languages.php
* Version 02:10 28.12.2011
* Copyright (c) 2008-2012 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}




$tabindex = 0;

if($action == ""){
	echo"
	<h2>$l_languages</h2>

	<!-- Feedback -->
	";
	if($ft != ""){
		if($fm == "changes_saved"){
			$fm = "$l_changes_saved";
		}
		elseif($fm == "language_added_to_the_list"){
			$fm = "$l_language_added_to_the_list";
		}
		elseif($fm == "language_is_alreaddy_active"){
			$fm = "$l_language_is_alreaddy_active";
		}
		elseif($fm == "language_removed"){
			$fm = "$l_language_removed";
		}
		else{
			$fm = ucfirst($ft);
		}
		echo"<div class=\"$ft\"><span>$fm</span></div>";
	}
	echo"	
	<!-- //Feedback -->


	<!-- Predefined language -->
		<form method=\"post\" action=\"?open=settings&amp;page=languages&amp;action=edit_predefined_language&amp;process=1\" enctype=\"multipart/form-data\" name=\"nameform\">
		<table>
		 <tr>
		  <td style=\"padding-right: 4px;\">
			<p>
			$l_main_language:
			</p>
		  </td>
		  <td>
			<p>
			<select name=\"inp_language\">
				<option value=\"\">-</option>\n";

			$query = "SELECT language_active_id, language_active_name, language_active_iso_two, language_active_flag, language_active_default FROM $t_languages_active";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_language_active_id, $get_language_active_name, $get_language_active_iso_two, $get_language_active_flag, $get_language_active_default) = $row;
				echo"	<option value=\"$get_language_active_id\" style=\"background: url('$flag_path') no-repeat;padding-left: 20px;\"";if($get_language_active_default == "1"){ echo" selected=\"selected\"";}echo">$get_language_active_name</option>\n";
			}
			echo"
			</select>
			</p>
		  </td>
		  <td style=\"padding-right: 4px;\">
			<p>
			<input type=\"submit\" value=\"$l_save\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" class=\"submit\" />
			</p>
		  </td>
		 </tr>
		</table>
		</form>
	<!-- //Predefined language -->


	<!-- Languages added and that can be addded -->
		<table>
		  <tr>
		   <td style=\"padding-right: 20px;vertical-align:top;\">

			<!-- Languages that can be added -->
				
				<table class=\"hor-zebra\">
				 <thead>
				  <tr>
				   <th scope=\"col\">
					<span>$l_inactive</span>
					<span style=\"float: right;\">$l_click_to_activate</span>
				   </th>
				  </tr>
			 	 </thead>
				<tbody>
				";
				$query = "SELECT language_id, language_name, language_iso_two, language_flag FROM $t_languages";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_language_id, $get_language_name, $get_language_iso_two, $get_language_flag) = $row;
	
					if(isset($odd) && $odd == false){
						$odd = true;
					}
					else{
						$odd = false;
					}			


					echo"
					<tr>
					  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
						<table>
						 <tr>
       						  <td style=\"padding-right:4px;\">
							";
							$flag_path = "_design/gfx/flags/16x16/$get_language_flag.png";
							/*
							*/


							// 32
							$ico_a = "_design/gfx/flags/32x32/$get_language_iso_two.png";
							$ico_b = "_design/gfx/flags/32x32/$get_language_flag.png";
							if(file_exists("$ico_a")){
								copy($ico_a, $ico_b);
								// unlink($ico_a);
							}

							echo"<span><a href=\"?open=settings&amp;page=languages&amp;action=add_language&amp;process=1&amp;language_id=$get_language_id\" style=\"color:#000;\"><img src=\"$flag_path\" alt=\"$flag_path\" /></a></span>";
							
							echo"<a href=\"$ico_a\">$ico_a</a>
						  </td>
       						  <td>
          						<span><a href=\"?open=settings&amp;page=languages&amp;action=add_language&amp;process=1&amp;language_id=$get_language_id\" style=\"color:#000;\">$get_language_name</a></span>
						  </td>
     						 </tr>
						</table>
					  </td>
     					 </tr>
					";
				}
				echo"
				 </tbody>
				</table>
			<!-- //Languages that can be added -->

		  </td>
		  <td style=\"vertical-align: top;\">

			<!-- Land list -->
				<table class=\"hor-zebra\">
				 <thead>
				  <tr>
				   <th scope=\"col\">
					<span>$l_active</span>
					<span style=\"float: right;\">$l_click_to_deactivate</span>
				   </th>
				  </tr>
			 	 </thead>
				<tbody>";

				$query = "SELECT language_active_id, language_active_name, language_active_iso_two, language_active_flag, language_active_default FROM $t_languages_active";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_language_active_id, $get_language_active_name, $get_language_active_iso_two, $get_language_active_flag, $get_language_active_default) = $row;


					
					if(isset($odd) && $odd == false){
						$odd = true;
					}
					else{
						$odd = false;
					}			


					echo"
					<tr>
					  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
						<table>
						 <tr>
       						  <td style=\"padding-right:4px;\">
							";
							$flag_path = "_design/gfx/flags/16x16/$get_language_active_flag.png";
							echo"<span><a href=\"?open=settings&amp;page=languages&amp;action=remove_language&amp;process=1&amp;language_id=$get_language_active_id\" style=\"color:#000;\"><img src=\"$flag_path\" alt=\"$flag_path\" /></a></span>";
						
							echo"
						  </td>
       						  <td>
          						<span><a href=\"?open=settings&amp;page=languages&amp;action=remove_language&amp;process=1&amp;language_id=$get_language_active_id\" style=\"color:#000;\">$get_language_active_name</a></span>
						  </td>
     						 </tr>
						</table>
					  </td>
     					 </tr>
					";
				}
				echo"
					</table>
				  </td>
     				 </tr>
				</table>
			<!-- //Navigation list -->

		  </td>
		 </tr>
		</table>
	<!-- //Languages added and that can be addded -->
	";
}
elseif($action == "add_language"){
	if($process == "1"){
		if(isset($_GET['language_id'])) {
			$inp_language = $_GET['language_id'];
			$inp_language = strip_tags(stripslashes($inp_language));
		}
		else{
			if(isset($_POST['inp_language'])) {
				$inp_language = $_POST['inp_language'];
				$inp_language = strip_tags(stripslashes($inp_language));
			}
			else{
				$inp_language = "";
				header('Location: ?open=settings&page=languages&ft=warning&fm=Ingen språk oppgitt.');
				exit;
			}

		}
		


		// Get
		$inp_language_mysql = quote_smart($link, $inp_language);
		$query = "SELECT language_id, language_name, language_slug, language_native_name, language_iso_two, language_iso_three, language_flag, language_charset FROM $t_languages WHERE language_id=$inp_language_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_language_id, $get_language_name, $get_language_slug, $get_language_native_name, $get_language_iso_two, $get_language_iso_three, $get_language_flag, $get_language_charset) = $row;

		if($get_language_id == ""){
			header("Location: ?open=settings&page=languages&ft=error&fm=language_not_found");
			exit;
				
		}
		else{
			// Does it alreaddy exsists in active list?
			$inp_iso_two_mysql = quote_smart($link, $get_language_iso_two);
			$query = "SELECT language_active_id FROM $t_languages_active WHERE language_active_iso_two=$inp_iso_two_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_language_active_id) = $row;

			if($get_language_active_id == ""){
				// Insert

				$inp_name_mysql = quote_smart($link, $get_language_name);
				$inp_slug_mysql = quote_smart($link, $get_language_slug);
				$inp_native_name_mysql = quote_smart($link, $get_language_native_name);
				$inp_iso_two_mysql = quote_smart($link, $get_language_iso_two);
				$inp_iso_three_mysql = quote_smart($link, $get_language_iso_three);
				$inp_active_flag_mysql = quote_smart($link, $get_language_flag);
				$inp_active_charset_mysql = quote_smart($link, $get_language_charset);

				mysqli_query($link, "INSERT INTO $t_languages_active
				(language_active_id, language_active_name, language_active_slug, language_active_native_name, language_active_iso_two, language_active_iso_three, language_active_flag, language_active_charset) 
				VALUES 
				(NULL, $inp_name_mysql, $inp_slug_mysql, $inp_native_name_mysql, $inp_iso_two_mysql, $inp_iso_three_mysql, $inp_active_flag_mysql, $inp_active_charset_mysql)")
				or die(mysqli_error($link));
				header("Location: ?open=settings&page=languages&ft=success&fm=language_added_to_the_list");
				exit;
				
			}
			else{
				header("Location: ?open=settings&page=languages&ft=success&fm=language_already_exist");
				exit;
				
			}
		}
	}

}
elseif($action == "remove_language"){
	if($process == "1"){
		if(isset($_GET['language_id'])) {
			$language_id = $_GET['language_id'];
			$language_id = strip_tags(stripslashes($language_id));
		}
		else{
			header('Location: ?open=settings&page=languages&ft=warning&fm=Ingen språk oppgitt.');
			exit;

		}
		
		// Locate this language
		$inp_language_id_mysql = quote_smart($link, $language_id);
		$query = "SELECT language_active_id FROM $t_languages_active WHERE language_active_id=$inp_language_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_language_active_id) = $row;

		if($get_language_active_id == ""){
			
			header("Location: ?open=settings&page=languages&ft=error&fm=language_not_found");
			exit;
		}
		else{
			$result = mysqli_query($link, "DELETE FROM $t_languages_active WHERE language_active_id=$inp_language_id_mysql");
			header("Location: ?open=settings&page=languages&ft=success&fm=language_removed");
			exit;
		}
	}
}
elseif($action == "edit_predefined_language"){
	if($process == "1"){

		
		if(isset($_POST['inp_language'])) {
			$inp_language = $_POST['inp_language'];
			$inp_language = strip_tags(stripslashes($inp_language));
		}
		else{
			header("Location: ?open=settings&page=languages&ft=warning&fm=Ingen språk valgt.");
			exit;
		}
		
		// Locate this language
		$inp_language_id_mysql = quote_smart($link, $inp_language);
		$query = "SELECT language_active_id FROM $t_languages_active WHERE language_active_id=$inp_language_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_language_active_id) = $row;


		if($get_language_active_id == ""){
			
			header("Location: ?open=settings&page=languages&ft=error&fm=language_not_found");
			exit;
		}
		else{
			$result = mysqli_query($link, "UPDATE $t_languages_active SET language_active_default='0'");
			$result = mysqli_query($link, "UPDATE $t_languages_active SET language_active_default='1' WHERE language_active_id=$inp_language_id_mysql");

			
			header("Location: ?open=settings&page=languages&ft=success&fm=changes_saved");
			exit;
		}
	}
}
?>