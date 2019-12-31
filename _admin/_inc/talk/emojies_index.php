<?php
/**
*
* File: _admin/_inc/talk/tables.php
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
$t_talk_liquidbase				= $mysqlPrefixSav . "talk_liquidbase";

$t_talk_channels_index		= $mysqlPrefixSav . "talk_channels_index";
$t_talk_channels_messages	= $mysqlPrefixSav . "talk_channels_messages";
$t_talk_channels_users_online	= $mysqlPrefixSav . "talk_channels_users_online";
$t_talk_users_starred_channels	= $mysqlPrefixSav . "talk_users_starred_channels";

$t_talk_dm_conversations = $mysqlPrefixSav . "talk_dm_conversations";
$t_talk_dm_messages	 = $mysqlPrefixSav . "talk_dm_messages";

$t_talk_total_unread = $mysqlPrefixSav . "talk_total_unread";
$t_talk_emojies_categories_main	= $mysqlPrefixSav . "talk_emojies_categories_main";
$t_talk_emojies_categories_sub	= $mysqlPrefixSav . "talk_emojies_categories_sub";
$t_talk_emojies_index 		= $mysqlPrefixSav . "talk_emojies_index";


/*- Variables -------------------------------------------------------------------------- */
if(isset($_GET['main_category_id'])) {
	$main_category_id = $_GET['main_category_id'];
	$main_category_id = strip_tags(stripslashes($main_category_id));
}
else{
	$main_category_id = "";
}

if($action == ""){
	echo"
	<h1>Emojies index</h1>


	<!-- Where am I? -->
		<p><b>You are here:</b><br />
		<a href=\"index.php?open=talk&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Talk</a>
		&gt;
		<a href=\"index.php?open=talk&amp;page=emojies_index&amp;editor_language=$editor_language&amp;l=$l\">Emojies index</a>
		</p>
	<!-- //Where am I? -->

	<!-- Left and right -->
		<table>
		 <tr>
		  <td style=\"vertical-align: top;padding-right: 20px;\">
		
			<!-- Left side categories -->
				<table class=\"hor-zebra\">
				 <tbody>
				  <tr>
				   <td style=\"width: 240px;\">
					<p>";
					$query = "SELECT main_category_id, main_category_title, main_category_code, main_category_char, main_category_source_path, main_main_category_source_file, main_category_source_ext, main_category_weight, main_category_is_active, main_category_language FROM $t_talk_emojies_categories_main";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_main_category_id, $get_main_category_title, $get_main_category_code, $get_main_category_char, $get_main_category_source_path, $get_main_main_category_source_file, $get_main_category_source_ext, $get_main_category_weight, $get_main_category_is_active, $get_main_category_language) = $row;
						echo"
						<a href=\"index.php?open=talk&amp;page=emojies_index&amp;action=open_main_category&amp;main_category_id=$get_main_category_id&amp;editor_language=$editor_language&amp;l=$l\">$get_main_category_char $get_main_category_title</a><br />
						";
					}
					echo"
					</p>
				   </td>
				  </tr>
				 </tbody>
				</table>
			<!-- //Left side categories -->
		  </td>
		  <td style=\"vertical-align: top;\">
			<!-- Right side Emojies index -->
				<table class=\"hor-zebra\">
				 <thead>
				  <tr>
				   <th scope=\"col\">
					<span>ID</span>
				   </th>
				   <th scope=\"col\">
					<span>Title</span>
				   </th>
				   <th scope=\"col\">
					<span>Code</span>
				   </th>
				   <th scope=\"col\">
					<span>Char</span>
				   </th>
				   <th scope=\"col\">
					<span>Skin tone</span>
				   </th>
				   <th scope=\"col\">
					<span>Actions</span>
				   </th>
				  </tr>
				</thead>
				<tbody>
				";

				$query = "SELECT emoji_id, emoji_main_category_id, emoji_sub_category_id, emoji_title, emoji_code, emoji_char, emoji_source_path, emoji_source_file, emoji_source_ext, emoji_skin_tone, emoji_created_by_user_id, emoji_created_datetime, emoji_updated_by_user_id, emoji_updated_datetime, emoji_used_count, emoji_last_used_datetime FROM $t_talk_emojies_index";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_emoji_id, $get_emoji_main_category_id, $get_emoji_sub_category_id, $get_emoji_title, $get_emoji_code, $get_emoji_char, $get_emoji_source_path, $get_emoji_source_file, $get_emoji_source_ext, $get_emoji_skin_tone, $get_emoji_created_by_user_id, $get_emoji_created_datetime, $get_emoji_updated_by_user_id, $get_emoji_updated_datetime, $get_emoji_used_count, $get_emoji_last_used_datetime) = $row;

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
						<span>$get_emoji_id</span>
					  </td>
					  <td class=\"$style\">
						<span>$get_emoji_title</span>
					  </td>
					  <td class=\"$style\">
						<span>$get_emoji_code</span>
					  </td>
					  <td class=\"$style\">
						<span style=\"font-size: 130%;\">
						$get_emoji_char
						</span>
					  </td>
					  <td class=\"$style\">
						<span>$get_emoji_skin_tone</span>
					  </td>
					  <td class=\"$style\">
						
					  </td>
					 </tr>
					";

				}
				echo"
					 </tbody>
					</table>
			<!-- //Right side Emojies index -->

		  </td>
		 </tr>
		</table>
	<!-- //Left and right -->
	";
}
elseif($action == "open_main_category"){
	// find main category
	$main_category_id_mysql = quote_smart($link, $main_category_id);
	$query = "SELECT main_category_id, main_category_title, main_category_code, main_category_char, main_category_source_path, main_main_category_source_file, main_category_source_ext, main_category_weight, main_category_is_active, main_category_language FROM $t_talk_emojies_categories_main WHERE main_category_id=$main_category_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_main_category_id, $get_current_main_category_title, $get_current_main_category_code, $get_current_main_category_char, $get_current_main_category_source_path, $get_current_main_main_category_source_file, $get_current_main_category_source_ext, $get_current_main_category_weight, $get_current_main_category_is_active, $get_current_main_category_language) = $row;
	
	if($get_current_main_category_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{



		echo"
		<h1>Emojies index</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=talk&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Talk</a>
			&gt;
			<a href=\"index.php?open=talk&amp;page=emojies_index&amp;editor_language=$editor_language&amp;l=$l\">Emojies index</a>
			&gt;
			<a href=\"index.php?open=talk&amp;page=emojies_index&amp;action=$action&amp;main_category_id=$get_current_main_category_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_main_category_title</a>
			</p>
		<!-- //Where am I? -->

		<!-- Left and right -->
		<table>
		 <tr>
		  <td style=\"vertical-align: top;padding-right: 20px;\">
		
			<!-- Left side categories -->
				<table class=\"hor-zebra\">
				 <tbody>
				  <tr>
				   <td style=\"width: 240px;\">
					<p>";
					$query = "SELECT main_category_id, main_category_title, main_category_code, main_category_char, main_category_source_path, main_main_category_source_file, main_category_source_ext, main_category_weight, main_category_is_active, main_category_language FROM $t_talk_emojies_categories_main";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_main_category_id, $get_main_category_title, $get_main_category_code, $get_main_category_char, $get_main_category_source_path, $get_main_main_category_source_file, $get_main_category_source_ext, $get_main_category_weight, $get_main_category_is_active, $get_main_category_language) = $row;
						echo"
						<a href=\"index.php?open=talk&amp;page=emojies_index&amp;action=open_main_category&amp;main_category_id=$get_main_category_id&amp;editor_language=$editor_language&amp;l=$l\"";
						if($get_main_category_id == "$get_current_main_category_id"){ echo" style=\"font-weight: bold;\""; } 
						echo">$get_main_category_char $get_main_category_title</a><br />
						";
					}
					echo"
					</p>
				   </td>
				  </tr>
				 </tbody>
				</table>
			<!-- //Left side categories -->
		  </td>
		  <td style=\"vertical-align: top;\">
			<!-- Right side Emojies index -->
				<table class=\"hor-zebra\">
				 <thead>
				  <tr>
				   <th scope=\"col\">
					<span>ID</span>
				   </th>
				   <th scope=\"col\">
					<span>Title</span>
				   </th>
				   <th scope=\"col\">
					<span>Code</span>
				   </th>
				   <th scope=\"col\">
					<span>Char</span>
				   </th>
				   <th scope=\"col\">
					<span>Skin tone</span>
				   </th>
				   <th scope=\"col\">
					<span>Actions</span>
				   </th>
				  </tr>
				</thead>
				<tbody>
				";

				$query = "SELECT emoji_id, emoji_main_category_id, emoji_sub_category_id, emoji_title, emoji_code, emoji_char, emoji_source_path, emoji_source_file, emoji_source_ext, emoji_skin_tone, emoji_created_by_user_id, emoji_created_datetime, emoji_updated_by_user_id, emoji_updated_datetime, emoji_used_count, emoji_last_used_datetime FROM $t_talk_emojies_index WHERE emoji_main_category_id=$get_current_main_category_id";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_emoji_id, $get_emoji_main_category_id, $get_emoji_sub_category_id, $get_emoji_title, $get_emoji_code, $get_emoji_char, $get_emoji_source_path, $get_emoji_source_file, $get_emoji_source_ext, $get_emoji_skin_tone, $get_emoji_created_by_user_id, $get_emoji_created_datetime, $get_emoji_updated_by_user_id, $get_emoji_updated_datetime, $get_emoji_used_count, $get_emoji_last_used_datetime) = $row;

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
						<span>$get_emoji_id</span>
					  </td>
					  <td class=\"$style\">
						<span>$get_emoji_title</span>
					  </td>
					  <td class=\"$style\">
						<span>$get_emoji_code</span>
					  </td>
					  <td class=\"$style\">
						<span style=\"font-size: 130%;\">
						$get_emoji_char
						</span>
					  </td>
					  <td class=\"$style\">
						<span>$get_emoji_skin_tone</span>
					  </td>
					  <td class=\"$style\">
						
					  </td>
					 </tr>
					";

				}
				echo"
					 </tbody>
					</table>
			<!-- //Right side Emojies index -->

		  </td>
		 </tr>
		</table>
		<!-- //Left and right -->
		";
	} // main category found
} // action == "open_main_category"

?>