<?php
/**
*
* File: _admin/_inc/webdesign/share_buttons.php
* Version 15:16 19.01.2021
* Copyright (c) 2021 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}


/*- Tables ---------------------------------------------------------------------------- */
$t_webdesign_share_buttons	= $mysqlPrefixSav . "webdesign_share_buttons";


if($action == ""){
	echo"
	<h1>Share buttons</h1>


	<p>
	<a href=\"index.php?open=$open&amp;page=$page&amp;action=new&amp;editor_language=$editor_language\" class=\"btn btn_default\">New</a>
	</p>

	<!-- Select language -->

		<script>
		\$(function(){
			// bind change event to select
			\$('#inp_l').on('change', function () {
				var url = \$(this).val(); // get selected value
				if (url) { // require a URL
 					window.location = url; // redirect
				}
				return false;
			});
		});
		</script>

		<form method=\"get\" enctype=\"multipart/form-data\">
		<p>
		$l_language:
		<select id=\"inp_l\">
			<option value=\"index.php?open=$open&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Editor language</option>
			<option value=\"index.php?open=$open&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">-</option>\n";


			$query = "SELECT language_active_id, language_active_name, language_active_iso_two, language_active_flag, language_active_default FROM $t_languages_active";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_language_active_id, $get_language_active_name, $get_language_active_iso_two, $get_language_active_flag, $get_language_active_default) = $row;

				$flag_path 	= "_design/gfx/flags/16x16/$get_language_active_flag" . "_16x16.png";

				// No language selected?
				if($editor_language == ""){
						$editor_language = "$get_language_active_iso_two";
				}
				
				
				echo"	<option value=\"index.php?open=$open&amp;page=$page&amp;editor_language=$get_language_active_iso_two&amp;l=$l\" style=\"background: url('$flag_path') no-repeat;padding-left: 20px;\"";if($editor_language == "$get_language_active_iso_two"){ echo" selected=\"selected\"";}echo">$get_language_active_name</option>\n";
			}
		echo"
		</select>
		</p>
		</form>
	<!-- //Select language -->

	<!-- List all share buttons -->
	<table class=\"hor-zebra\">
	 <thead>
	  <tr>
	   <th scope=\"col\">
		<span>Title</span>
	   </th>
	   <th scope=\"col\">
		<span>URL</span>
	   </th>
	   <th scope=\"col\">
		<span>Image</span>
	   </th>
	   <th scope=\"col\">
		<span>Actions</span>
	   </th>
	  </tr>
	</thead>
	<tbody>
	";
	$editor_language = output_html($editor_language);
	$editor_language_mysql = quote_smart($link, $editor_language);
	$query = "SELECT button_id, button_title, button_url, button_code_preload, button_code_plugin, button_language, button_image_path, button_image_18x18 FROM $t_webdesign_share_buttons WHERE button_language=$editor_language_mysql";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_button_id, $get_button_title, $get_button_url, $get_button_code_preload, $get_button_code_plugin, $get_button_language, $get_button_image_path, $get_button_image_18x18) = $row;


		echo"
		<tr>
		  <td>
			<span>$get_button_title</span>
		  </td>
		  <td>
			<span>$get_button_url</span>
		  </td>
		  <t>
			<span>";
			if($get_button_image_18x18 != ""){
				echo"<img src=\"$get_button_image_path/$get_button_image_18x18\" alt=\"$get_button_image_18x18\" />";
			}
			echo"</span>
		  </td>
		  <td>
			<span>
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=edit&amp;button_id=$get_button_id&amp;editor_language=$editor_language\">Edit</a>
			&middot;
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=delete&amp;button_id=$get_button_id&amp;editor_language=$editor_language\">Delete</a>
			</span>
		 </td>
		</tr>
		";
	}
	echo"
	 </tbody>
	</table>
	<!-- //List all buttons -->

	";
} // action == ""
?>