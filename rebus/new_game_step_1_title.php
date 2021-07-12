<?php
/**
*
* File: rebus/new_game_step_1_name.php
* Version 1.0.0.
* Date 09:50 01.07.2021
* Copyright (c) 2021 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Configuration --------------------------------------------------------------------- */
$pageIdSav            = "2";
$pageNoColumnSav      = "2";
$pageAllowCommentsSav = "0";

/*- Root dir -------------------------------------------------------------------------- */
// This determine where we are
if(file_exists("favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
elseif(file_exists("../../../../favicon.ico")){ $root = "../../../.."; }
else{ $root = "../../.."; }

/*- Website config -------------------------------------------------------------------- */
include("$root/_admin/website_config.php");

/*- Tables ---------------------------------------------------------------------------- */
include("_tables_rebus.php");


/*- Variables ------------------------------------------------------------------------- */
$l_mysql = quote_smart($link, $l);
$tabindex = 0;

/*- Translation ------------------------------------------------------------------------ */


/*- Headers ---------------------------------------------------------------------------- */
$website_title = "$l_new_game";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");


// Logged in?
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	$my_user_id = $_SESSION['user_id'];
	$my_user_id = output_html($my_user_id);
	$my_user_id_mysql = quote_smart($link, $my_user_id);


	if($process == "1"){
		$inp_title = $_POST['inp_title'];
		$inp_title = output_html($inp_title);
		$inp_title_mysql = quote_smart($link, $inp_title);
		if($inp_title == ""){
			$url = "new_game_step_1_name.php?l=$l&ft=error&fm=missing_name";
			header("Location: $url");
			exit;
		}
			
		$l_mysql = quote_smart($link, $l);

		$inp_privacy = $_POST['inp_privacy'];
		$inp_privacy = output_html($inp_privacy);
		$inp_privacy_mysql = quote_smart($link, $inp_privacy);

		// Group
		$inp_group_id = $_POST['inp_group_id'];
		$inp_group_id = output_html($inp_group_id);
		$inp_group_id_mysql = quote_smart($link, $inp_group_id);

		$inp_group_name = "";

		if($inp_group_id != "0"){
			// Find group
			$query = "SELECT group_id, group_name FROM $t_rebus_groups_index WHERE group_id=$inp_group_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_group_id, $get_group_name) = $row;
			
			// Check that I am a member of that group
			$query = "SELECT member_id FROM $t_rebus_groups_members WHERE member_group_id=$get_group_id AND member_user_id=$my_user_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_member_id) = $row;

			if($get_member_id != ""){
				$inp_group_id = "$get_group_id";
				$inp_group_id = output_html($inp_group_id);
				$inp_group_id_mysql = quote_smart($link, $inp_group_id);

				$inp_group_name = output_html($get_group_name);
			}
		}
		$inp_group_name_mysql = quote_smart($link, $inp_group_name);

		// Country
		$inp_country = $_POST['inp_country'];
		$inp_country = output_html($inp_country);
		$inp_country_mysql = quote_smart($link, $inp_country);

		$query = "SELECT country_id, country_name FROM $t_languages_countries WHERE country_name=$inp_country_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_country_id, $get_country_name) = $row;


		// Me
		$query = "SELECT user_id, user_email, user_name, user_language, user_rank FROM $t_users WHERE user_id=$my_user_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_my_user_id, $get_my_user_email, $get_my_user_name, $get_my_user_language, $get_my_user_rank) = $row;
		
		$inp_my_user_name_mysql = quote_smart($link, $get_my_user_name);
		$inp_my_user_email_mysql = quote_smart($link, $get_my_user_email);

		// Profile photo
		$query = "SELECT photo_id, photo_destination, photo_thumb_50 FROM $t_users_profile_photo WHERE photo_user_id='$get_my_user_id' AND photo_profile_image='1'";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_my_photo_id, $get_my_photo_destination, $get_my_photo_thumb_50) = $row;

		$inp_my_photo_destination_mysql = quote_smart($link, $get_my_photo_destination);
		$inp_my_photo_thumb_50_mysql = quote_smart($link, $get_my_photo_thumb_50);

		// Ip 
		$my_ip = $_SERVER['REMOTE_ADDR'];
		$my_ip = output_html($my_ip);
		$my_ip_mysql = quote_smart($link, $my_ip);

		$my_hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		$my_hostname = output_html($my_hostname);
		$my_hostname_mysql = quote_smart($link, $my_hostname);

		$my_user_agent = $_SERVER['HTTP_USER_AGENT'];
		$my_user_agent = output_html($my_user_agent);
		$my_user_agent_mysql = quote_smart($link, $my_user_agent);

		// Dates
		$datetime = date("Y-m-d H:i:s");
		$date_saying = date("j M Y");

		// Check if game exists
		$query = "SELECT game_id FROM $t_rebus_games_index WHERE game_title=$inp_title_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_game_id) = $row;
		if($get_game_id!= ""){
			$url = "new_game_step_1_title.php?privacy=$inp_privacy&group_id=$inp_group_id&l=$l&ft=error&fm=there_is_already_a_game_with_that_title_(" . $inp_title . ")";
			header("Location: $url");
			exit;
		}


		// Create game
		mysqli_query($link, "INSERT INTO $t_rebus_games_index
		(game_id, game_title, game_language, game_description, game_privacy, 
		game_published, game_group_id, game_group_name, game_country_id, game_country_name, 
		game_times_played, game_created_by_user_id, game_created_by_user_name, 
		game_created_by_user_email, game_created_by_ip, game_created_by_hostname, game_created_by_user_agent, game_created_datetime, 
		game_created_date_saying) 
		VALUES 
		(NULL, $inp_title_mysql, $l_mysql, '', $inp_privacy_mysql, 
		0, $inp_group_id_mysql, $inp_group_name_mysql, $get_country_id, $inp_country_mysql, 0, $get_my_user_id, $inp_my_user_name_mysql, 
		$inp_my_user_email_mysql, $my_ip_mysql, $my_hostname_mysql, $my_user_agent_mysql, '$datetime', 
		'$date_saying')")
		or die(mysqli_error($link));

		// Get id
		$query = "SELECT game_id FROM $t_rebus_games_index WHERE game_created_by_user_id=$get_my_user_id AND game_created_datetime='$datetime'";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_game_id) = $row;

		// Add me as owner
		mysqli_query($link, "INSERT INTO $t_rebus_games_owners
		(owner_id, owner_game_id, owner_user_id, owner_user_name, owner_user_email) 
		VALUES 
		(NULL, $get_current_game_id, $get_my_user_id, $inp_my_user_name_mysql, $inp_my_user_email_mysql)")
		or die(mysqli_error($link));

		// Open team
		$url = "new_game_step_2_county.php?game_id=$get_current_game_id&l=$l&ft=success&fm=game_created";
		header("Location: $url");
		exit;


	} // process

	echo"
	<!-- Headline -->
		<h1>$l_new_game</h1>
	<!-- //Headline -->

	<!-- Where am I ? -->
		<p><b>$l_you_are_here:</b><br />
		<a href=\"index.php?l=$l\">$l_rebus</a>
		&gt;
		<a href=\"new_game.php?l=$l\">$l_new_game</a>
		</p>
	<!-- //Where am I ? -->

	<!-- Feedback -->
		";
		if($ft != "" && $fm != ""){
			$fm = ucfirst($fm);
			$fm = str_replace("_", " ", $fm);
			echo"<div class=\"$ft\"><p>$fm</p></div>";
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

	<!-- New game form -->
		<form method=\"post\" action=\"new_game_step_1_title.php?l=$l&amp;process=1\" enctype=\"multipart/form-data\">

		<p><b>$l_game_title:</b><br />
		<input type=\"text\" name=\"inp_title\" value=\"\" size=\"25\" style=\"width: 99%;\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" />
		</p>

		<p><b>$l_privacy:</b><br />";
		if(isset($_GET['privacy'])) {
			$privacy = $_GET['privacy'];
			$privacy = output_html($privacy);
		}
		else{
			$privacy = "public";
		}
		echo"
		<input type=\"radio\" name=\"inp_privacy\" value=\"public\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\""; if($privacy == "public"){ echo" checked=\"checked\""; } echo" /> $l_public &nbsp;
		<input type=\"radio\" name=\"inp_privacy\" value=\"private\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\""; if($privacy == "private"){ echo" checked=\"checked\""; } echo" /> $l_private
		</p>


		<p><b>$l_game_belongs_to_group:</b>";
		if(isset($_GET['group_id'])) {
			$group_id = $_GET['group_id'];
			$group_id = output_html($group_id);
			if(!(is_numeric($group_id))){
				echo"Group id not numeric";
				die;
			}
		}
		else{
			$group_id = "0";
		}
		echo"
		(<a href=\"new_group.php?l=$l\">$l_create_group</a>)<br />
		<select name=\"inp_group_id\">
			<option value=\"0\""; if($group_id == "0"){ echo" selected=\"selected\""; } echo">$l_none</selected>";
			$query = "SELECT member_id, member_group_id, group_name FROM $t_rebus_groups_members JOIN $t_rebus_groups_index ON $t_rebus_groups_members.member_group_id=$t_rebus_groups_index.group_id WHERE member_user_id=$my_user_id_mysql ORDER BY $t_rebus_groups_index.group_name ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_member_id, $get_member_group_id, $get_group_name) = $row;
				echo"			<option value=\"$get_member_group_id\""; if($group_id == "$get_member_group_id"){ echo" selected=\"selected\""; } echo">$get_group_name</selected>\n";
			}
			echo"
		</select></p>


		<p><b>$l_game_can_be_played_in_country:</b><br />
		<select name=\"inp_country\">";
		if(!(isset($inp_country))){
			// Find the country the last person registrered used
			$query = "SELECT profile_country FROM $t_users_profile WHERE profile_user_id=$my_user_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($inp_country) = $row;
		}
		$query = "SELECT country_id, country_name FROM $t_languages_countries ORDER BY country_name ASC";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_country_id, $get_country_name) = $row;
			echo"			";
			echo"<option value=\"$get_country_name\""; if(isset($inp_country) && $inp_country == "$get_country_name"){ echo" selected=\"selected\""; } echo">$get_country_name</option>\n";
		}
		echo"
		</select>
		</p>

		<p><input type=\"submit\" value=\"$l_create_game\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" /></p>
		
		</form>
	<!-- //New game form -->
	";
}
else{
	echo"
	<h1>
	<img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" />
	Loading...</h1>
	<meta http-equiv=\"refresh\" content=\"1;url=$root/users/login.php?l=$l&amp;referer=$root/rebus/team_new.php\">

	<p>Please log in...</p>
	";
}

/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>