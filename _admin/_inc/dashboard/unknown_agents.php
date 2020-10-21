<?php
/**
*
* File: _admin/_inc/dashboard/unknown_agents.php
* Version 2.0
* Date 10:37 21.10.2020
* Copyright (c) 2008-2020 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}

/*- Tables ------------------------------------------------------------------------ */
$t_stats_user_agents_index = $mysqlPrefixSav . "stats_user_agents_index";


/*- Variables ------------------------------------------------------------------------ */
if(isset($_GET['stats_user_agent_id'])) {
	$stats_user_agent_id = $_GET['stats_user_agent_id'];
	$stats_user_agent_id = strip_tags(stripslashes($stats_user_agent_id));
}
else{
	$stats_user_agent_id = "";
}


if($action == ""){
	
}
elseif($action == "fix_agents"){
	if($process == 1){
		$inp_browser = $_POST['inp_browser'];
		$inp_browser = output_html($inp_browser);
		$inp_browser_mysql = quote_smart($link, $inp_browser);
		
		$inp_browser_icon = "";
		if($inp_browser != ""){
			$inp_browser_icon = strtolower($inp_browser);
			$inp_browser_icon = clean($inp_browser_icon);
			$inp_browser_icon = $inp_browser_icon . ".png";
		}
		$inp_browser_icon_mysql = quote_smart($link, $inp_browser_icon);
		
		$inp_browser_version = $_POST['inp_browser_version'];
		$inp_browser_version = output_html($inp_browser_version);
		$inp_browser_version_mysql = quote_smart($link, $inp_browser_version);

		$inp_os = $_POST['inp_os'];
		$inp_os = output_html($inp_os);
		$inp_os_mysql = quote_smart($link, $inp_os);
		
		$inp_os_icon = "";
		if($inp_os != ""){
			$inp_os_icon = strtolower($inp_os);
			$inp_os_icon = clean($inp_os_icon);
			$inp_os_icon = $inp_os_icon . ".png";
		}
		$inp_os_icon_mysql = quote_smart($link, $inp_os_icon);

		$inp_os_version = $_POST['inp_os_version'];
		$inp_os_version = output_html($inp_os_version);
		$inp_os_version_mysql = quote_smart($link, $inp_os_version);
		
		
		$inp_bot = $_POST['inp_bot'];
		$inp_bot = output_html($inp_bot);
		$inp_bot_mysql = quote_smart($link, $inp_bot);
		
		$inp_bot_icon = "";
		if($inp_bot != ""){
			$inp_bot_icon = strtolower($inp_bot);
			$inp_bot_icon = clean($inp_bot_icon);
			$inp_bot_icon = $inp_bot_icon . ".png";
		}
		$inp_bot_icon_mysql = quote_smart($link, $inp_bot_icon);
		
		$inp_url = $_POST['inp_url'];
		$inp_url = output_html($inp_url);
		$inp_url_mysql = quote_smart($link, $inp_url);
		
		$inp_type = $_POST['inp_type'];
		$inp_type = output_html($inp_type);
		$inp_type_mysql = quote_smart($link, $inp_type);
		
		if(isset($_POST['inp_banned'])){
			$inp_banned = $_POST['inp_banned'];
			
		}
		else{
			$inp_banned = 0;
		}
		$inp_banned = output_html($inp_banned);
		$inp_banned_mysql = quote_smart($link, $inp_banned);
		
		
		$stats_user_agent_id_mysql = quote_smart($link, $stats_user_agent_id);
		$result = mysqli_query($link, "UPDATE $t_stats_user_agents_index SET stats_user_agent_browser=$inp_browser_mysql, stats_user_agent_browser_version=$inp_browser_version_mysql, 
				stats_user_agent_os=$inp_os_mysql, stats_user_agent_os_version=$inp_os_version_mysql, stats_user_agent_bot=$inp_bot_mysql, 
				stats_user_agent_url=$inp_url_mysql, stats_user_agent_browser_icon=$inp_browser_icon_mysql, stats_user_agent_os_icon=$inp_os_icon_mysql, 
				stats_user_agent_bot_icon=$inp_bot_icon_mysql, stats_user_agent_type=$inp_type_mysql, stats_user_agent_banned=$inp_banned_mysql WHERE stats_user_agent_id=$stats_user_agent_id_mysql");

		// echo"UPDATE $t_stats_user_agents SET stats_user_agent_browser=$inp_browser_mysql, stats_user_agent_os=$inp_os_mysql, stats_user_agent_bot=$inp_bot_mysql, 
		// stats_user_agent_url=$inp_url_mysql, stats_user_agent_browser_icon=$inp_browser_icon_mysql, stats_user_agent_os_icon=$inp_os_icon_mysql, 
		// stats_user_agent_bot_icon=$inp_bot_icon_mysql, stats_user_agent_type=$inp_type_mysql, stats_user_agent_banned=$inp_banned_mysql WHERE stats_user_agent_id=$stats_user_agent_id_mysql";
		
		
		header("Location: index.php?open=dashboard&page=unknown_agents&action=fix_agents&editor_language=$editor_language&ft=success&fm=changes_saved");
		exit;
	}
	
	echo"
	<h1>$l_unknown_agents</h1>
	

	<!-- Feedback -->
	";
	if($ft != ""){
		if($fm == "changes_saved"){
			$fm = "$l_changes_saved";
		}
		else{
			$fm = ucfirst($ft);
		}
		echo"<div class=\"$ft\"><span>$fm</span></div>";
	}
	echo"	
	<!-- //Feedback -->

	
	";
	
	// Find problems
	$found_problem = 0;
	
	// 1: Unknown type
	$query = "SELECT stats_user_agent_id, stats_user_agent_string, stats_user_agent_type, stats_user_agent_browser, stats_user_agent_browser_version, stats_user_agent_browser_icon, stats_user_agent_os, stats_user_agent_os_version, stats_user_agent_os_icon, stats_user_agent_bot, stats_user_agent_bot_icon, stats_user_agent_bot_website, stats_user_agent_banned FROM $t_stats_user_agents_index WHERE stats_user_agent_type='' LIMIT 0,1";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_stats_user_agent_id, $get_stats_user_agent_string, $get_stats_user_agent_type, $get_stats_user_agent_browser, $get_stats_user_agent_browser_version, $get_stats_user_agent_browser_icon, $get_stats_user_agent_os, $get_stats_user_agent_os_version, $get_stats_user_agent_os_icon, $get_stats_user_agent_bot, $get_stats_user_agent_bot_icon, $get_stats_user_agent_bot_website, $get_stats_user_agent_banned) = $row;

	
	if($get_stats_user_agent_id != ""){
		$found_problem = 1;
	}
	else{
		// 2: Unknown browsers
		$query = "SELECT stats_user_agent_id, stats_user_agent_string, stats_user_agent_type, stats_user_agent_browser, stats_user_agent_browser_version, stats_user_agent_browser_icon, stats_user_agent_os, stats_user_agent_os_version, stats_user_agent_os_icon, stats_user_agent_bot, stats_user_agent_bot_icon, stats_user_agent_bot_website, stats_user_agent_banned FROM $t_stats_user_agents_index WHERE stats_user_agent_browser='' AND stats_user_agent_bot='' LIMIT 0,1";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_stats_user_agent_id, $get_stats_user_agent_string, $get_stats_user_agent_type, $get_stats_user_agent_browser, $get_stats_user_agent_browser_version, $get_stats_user_agent_browser_icon, $get_stats_user_agent_os, $get_stats_user_agent_os_version, $get_stats_user_agent_os_icon, $get_stats_user_agent_bot, $get_stats_user_agent_bot_icon, $get_stats_user_agent_bot_website, $get_stats_user_agent_banned) = $row;

		if($get_stats_user_agent_id != ""){
			$found_problem = 1;
		}
		else{
			// 3: Unknown os
			$query = "SELECT stats_user_agent_id, stats_user_agent_string, stats_user_agent_type, stats_user_agent_browser, stats_user_agent_browser_version, stats_user_agent_browser_icon, stats_user_agent_os, stats_user_agent_os_version, stats_user_agent_os_icon, stats_user_agent_bot, stats_user_agent_bot_icon, stats_user_agent_bot_website, stats_user_agent_banned FROM $t_stats_user_agents_index WHERE stats_user_agent_os='' AND stats_user_agent_bot='' LIMIT 0,1";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_stats_user_agent_id, $get_stats_user_agent_string, $get_stats_user_agent_type, $get_stats_user_agent_browser, $get_stats_user_agent_browser_version, $get_stats_user_agent_browser_icon, $get_stats_user_agent_os, $get_stats_user_agent_os_version, $get_stats_user_agent_os_icon, $get_stats_user_agent_bot, $get_stats_user_agent_bot_icon, $get_stats_user_agent_bot_website, $get_stats_user_agent_banned) = $row;

			
			if($get_stats_user_agent_id != ""){
				$found_problem = 1;
			}
			else{
				// 4: Unknown flag
				$query = "SELECT stats_user_agent_id, stats_user_agent_string, stats_user_agent_type, stats_user_agent_browser, stats_user_agent_browser_version, stats_user_agent_browser_icon, stats_user_agent_os, stats_user_agent_os_version, stats_user_agent_os_icon, stats_user_agent_bot, stats_user_agent_bot_icon, stats_user_agent_bot_website, stats_user_agent_banned FROM $t_stats_user_agents_index WHERE stats_user_agent_type='unknown' LIMIT 0,1";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_stats_user_agent_id, $get_stats_user_agent_string, $get_stats_user_agent_type, $get_stats_user_agent_browser, $get_stats_user_agent_browser_version, $get_stats_user_agent_browser_icon, $get_stats_user_agent_os, $get_stats_user_agent_os_version, $get_stats_user_agent_os_icon, $get_stats_user_agent_bot, $get_stats_user_agent_bot_icon, $get_stats_user_agent_bot_website, $get_stats_user_agent_banned) = $row;

				if($get_stats_user_agent_id != ""){
					$found_problem = 1;
				}
			}
		}
	
	}
	
	
	// Display problem form
	if($found_problem == 1){
		echo"
		<!-- Focus -->
			<script>
			\$(document).ready(function(){
				\$('[name=\"inp_browser\"]').focus();
			});
			</script>
		<!-- //Focus -->
	
		<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=fix_agents&amp;editor_language=$editor_language&amp;stats_user_agent_id=$get_stats_user_agent_id&amp;process=1\" enctype=\"multipart/form-data\">

		<p>
		<b>$l_id</b><br />
		$get_stats_user_agent_id</p>

		<p>
		<b>$l_agent</b><br />
		<a href=\"https://www.google.com/search?q=$get_stats_user_agent_string\">$get_stats_user_agent_string</a></p>
		
		<p><b>$l_browser</b><br />
		<input type=\"text\" name=\"inp_browser\" size=\"20\" value=\"$get_stats_user_agent_browser\" /></p>
		
		<p><b>$l_browser version</b><br />
		<input type=\"text\" name=\"inp_browser_version\" size=\"20\" value=\"$get_stats_user_agent_browser_version\" /></p>
		
		<p><b>$l_os</b><br />
		<input type=\"text\" name=\"inp_os\" size=\"20\" value=\"$get_stats_user_agent_os\" /></p>
		
		<p><b>$l_os version</b><br />
		<input type=\"text\" name=\"inp_os_version\" size=\"20\" value=\"$get_stats_user_agent_os_version\" /></p>
		<p><b>$l_bot</b><br />
		<input type=\"text\" name=\"inp_bot\" size=\"20\" value=\"$get_stats_user_agent_bot\" /></p>
		
		<p><b>$l_url</b><br />
		<input type=\"text\" name=\"inp_url\" size=\"20\" value=\"$get_stats_user_agent_url\" /></p>
		
		<p><b>$l_type</b><br />
		<select name=\"inp_type\">
			<option value=\"bot\""; if($get_stats_user_agent_type == "bot"){ echo" selected=\"selected\""; } echo">bot</option>
			<option value=\"desktop\""; if($get_stats_user_agent_type == "desktop"){ echo" selected=\"selected\""; } echo">desktop</option>
			<option value=\"mobile\""; if($get_stats_user_agent_type == "mobile"){ echo" selected=\"selected\""; } echo">mobile</option>
			<option value=\"unknown\""; if($get_stats_user_agent_type == "unknown"){ echo" selected=\"selected\""; } echo">unknown</option>
		</select>
		</p>
		
		<p><b>$l_banned</b><br />
		<input type=\"checkbox\" name=\"inp_banned\""; if($get_stats_user_agent_banned == "1"){ echo" checked=\"checked\""; } echo" value=\"1\" />
		</p>
		
		<p><input type=\"submit\" value=\"$l_save\" class=\"submit\" /></p>
		";
	}
	else{
		echo"
		<p>$l_no_more_problems_found.
		
		<p>
		<a href=\"index.php?open=$open&amp;editor_language=$editor_language\" class=\"btn\">$l_dashboard</a>
		<a href=\"index.php?open=$open&amp;page=$page&amp;action=export_agents&amp;editor_language=$editor_language\" class=\"btn\">$l_export_agents</a>
		</p>
		
		";

	}
	
	echo"
	
	";
}
elseif($action == "list"){
	echo"
	<h1>$l_unknown_agents</h1>

		
	<table class=\"hor-zebra\">
	 <thead>
	  <tr>
	   <th scope=\"col\">
		<span>$l_string</span>
	   </th>
	   <th scope=\"col\">
		<span>$l_browser</span>
	   </th>
	   <th scope=\"col\">
		<span>$l_os</span>
	   </th>
	   <th scope=\"col\">
		<span>$l_bot</span>
	   </th>
	   <th scope=\"col\">
		<span>$l_url</span>
	   </th>
	   <th scope=\"col\">
		<span>$l_type</span>
	   </th>
	   <th scope=\"col\">
		<span>$l_banned</span>
	   </th>
	   <th scope=\"col\">
		<span>$l_action</span>
	   </th>
	  </tr>
	</thead>
	 <tbody>\n";

	$query = "SELECT stats_user_agent_id, stats_user_agent_string, stats_user_agent_browser, stats_user_agent_os, stats_user_agent_bot, stats_user_agent_url, stats_user_agent_browser_icon, stats_user_agent_os_icon, stats_user_agent_bot_icon, stats_user_agent_type, stats_user_agent_banned FROM $t_stats_user_agents_index WHERE stats_user_agent_browser=''";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_stats_user_agent_id, $get_stats_user_agent_string, $get_stats_user_agent_browser, $get_stats_user_agent_os, $get_stats_user_agent_bot, $get_stats_user_agent_url, $get_stats_user_agent_browser_icon, $get_stats_user_agent_os_icon, $get_stats_user_agent_bot_icon, $get_stats_user_agent_type, $get_stats_user_agent_banned) = $row;

		if(isset($style) && $style == "odd"){
			$style = "";
		}
		else{
			$style = "odd";
		}

		echo"
		<tr>
		  <td class=\"$style\">
			<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;editor_language=$editor_language&amp;action=edit_agent&amp;stats_user_agent_id=$get_stats_user_agent_id&amp;process=1\" enctype=\"multipart/form-data\">


			<span>$get_stats_user_agent_string</span>
			</form>
		  </td>
		  <td class=\"$style\">
			<span><input type=\"text\" name=\"inp_browser\" size=\"20\" value=\"$get_stats_user_agent_browser\" /></span>
		  </td>
		  <td class=\"$style\">
			<span><input type=\"text\" name=\"inp_os\" size=\"20\" value=\"$get_stats_user_agent_os\" /></span>
		  </td>
		  <td class=\"$style\">
			<span><input type=\"text\" name=\"inp_bot\" size=\"20\" value=\"$get_stats_user_agent_bot\" /></span>
		  </td>
		  <td class=\"$style\">
			<span><input type=\"text\" name=\"inp_url\" size=\"20\" value=\"$get_stats_user_agent_url\" /></span>
		  </td>
		  <td class=\"$style\">
			<span>
			<select name=\"inp_type\">
				<option value=\"bot\""; if($get_stats_user_agent_type == "bot"){ echo" selected=\"selected\""; } echo">bot</option>
				<option value=\"desktop\""; if($get_stats_user_agent_type == "desktop"){ echo" selected=\"selected\""; } echo">desktop</option>
				<option value=\"mobile\""; if($get_stats_user_agent_type == "mobile"){ echo" selected=\"selected\""; } echo">mobile</option>
				<option value=\"unknown\""; if($get_stats_user_agent_type == "unknown"){ echo" selected=\"selected\""; } echo">unknown</option>
			</select>
		  </td>
		  <td class=\"$style\">
			<span><input type=\"checkbox\" name=\"inp_banned\""; if($get_stats_user_agent_banned == "1"){ echo" checked=\"checked\""; } echo" /></span>
		  </td>
		  <td class=\"$style\">
			<span><input type=\"submit\" value=\"$l_save\" class=\"submit\" /></span>
		  </td>
		</tr>
		";

	}
	echo"
	 <tbody>
	</table>
	";
}
elseif($action == "export_agents"){
	echo"
	<h1>$l_export_agents</h1>
	
	
	
	<span>// Agents<br /></span>
	";
	// Agents
	$x = 0;
	$query = "SELECT stats_user_agent_id, stats_user_agent_string, stats_user_agent_browser, stats_user_agent_os, stats_user_agent_bot, stats_user_agent_url, stats_user_agent_browser_icon, stats_user_agent_os_icon, stats_user_agent_bot_icon, stats_user_agent_type, stats_user_agent_banned FROM $t_stats_user_agents_index ORDER BY stats_user_agent_string";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_stats_user_agent_id, $get_stats_user_agent_string, $get_stats_user_agent_browser, $get_stats_user_agent_os, $get_stats_user_agent_bot, $get_stats_user_agent_url, $get_stats_user_agent_browser_icon, $get_stats_user_agent_os_icon, $get_stats_user_agent_bot_icon, $get_stats_user_agent_type, $get_stats_user_agent_banned) = $row;

		if($x == 0){
			echo"
			<p class=\"smal\">
			mysqli_query(\$link, &quot;INSERT INTO \$t_stats_user_agents<br />
			(stats_user_agent_id, stats_user_agent_string, stats_user_agent_browser, stats_user_agent_os, stats_user_agent_bot, stats_user_agent_url, stats_user_agent_browser_icon, stats_user_agent_os_icon, stats_user_agent_bot_icon, stats_user_agent_type, stats_user_agent_banned) <br />
			VALUES<br />
			";
			
		}
		echo"
			(NULL, '$get_stats_user_agent_string', '$get_stats_user_agent_browser', '$get_stats_user_agent_os', '$get_stats_user_agent_bot', '$get_stats_user_agent_url', '$get_stats_user_agent_browser_icon', '$get_stats_user_agent_os_icon', '$get_stats_user_agent_bot_icon', '$get_stats_user_agent_type', '$get_stats_user_agent_banned')
		";
		
		if($x < 10){
			echo",<br />";
		}
		
		if($x == 10){
			echo"
			&quot;) or die(mysqli_error(\$link));
			</p>
			";
			
			$x=-1;
		}
		$x++;
	}
	if($x != 10){
			echo"
			&quot;) or die(mysqli_error(\$link));
			</p>
			";
		
	}
	echo"
	</p>
	
	
	
	";
}


?>