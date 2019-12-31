<?php
/**
*
* File: en/_webdesign/howto/header.php
* Version 10:48 30.06.2019
* Copyright (c) 2019 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/


/*- Root dir -------------------------------------------------------------------------- */
if(!(isset($root))){
	if(file_exists("_scripts/index.html")){
		$root = ".";
	}
	elseif(file_exists("../_scripts/index.html")){
		$root = "..";
	}
	elseif(file_exists("../../_scripts/index.html")){
		$root = "../..";
	}
	elseif(file_exists("../../../_scripts/index.html")){
		$root = "../../..";
	}
	elseif(file_exists("../../../../_scripts/index.html")){
		$root = "../../../..";
	}
	else{
		$root = "../../..";
	}
}


/*- Website config -------------------------------------------------------------------- */
if(!(isset($server_name))){
	include("$root/_admin/website_config.php");
}



/*- Logged in? ----------------------------------------------------------------------- */
// This is used in the design (my user id)

				// Am I logged in?
				$t_users 	 		= $mysqlPrefixSav . "users";
				$t_users_profile		= $mysqlPrefixSav . "users_profile";
				$t_users_profile_photo 		= $mysqlPrefixSav . "users_profile_photo";
				if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
					// Get my user alias, date format, profile image
					$my_user_id = $_SESSION['user_id'];
					$my_user_id_mysql = quote_smart($link, $my_user_id);

					$query = "SELECT user_id, user_alias, user_date_format FROM $t_users WHERE user_id=$my_user_id_mysql";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_my_user_id, $get_my_user_alias, $get_my_user_date_format) = $row;

					if($get_my_user_id == ""){
						echo"<p style=\"color:red\">Session error</p>";
						unset($_SESSION['user_id']);
					}
					// Get my profile image
					$q = "SELECT photo_id, photo_destination FROM $t_users_profile_photo WHERE photo_user_id=$my_user_id_mysql AND photo_profile_image='1'";
					$r = mysqli_query($link, $q);
					$rowb = mysqli_fetch_row($r);
					list($get_my_photo_id, $get_my_photo_destination) = $rowb;
				}

/*- Variables -------------------------------------------------------------------------------- */
if (isset($_GET['space_id'])) {
	$space_id = $_GET['space_id'];
	$space_id = stripslashes(strip_tags($space_id));
}
else{
	$space_id = "";
}


if($process != "1"){
echo"<!DOCTYPE html>
<html lang=\"en-US\">
<head>
	<title>$configWebsiteTitleSav";
	if(isset($website_title)){
		echo" - $website_title";
	}
	else{
		$title = $_SERVER['PHP_SELF'];
		$title = str_replace("/", " - ", $title);
		$title = str_replace(".php", "", $title);
		$title = str_replace("_", " ", $title);
		$title = ucwords($title);
		echo" $title";
	}
	echo"</title>

	<!-- Site CSS -->
		<link rel=\"stylesheet\" type=\"text/css\" href=\"$root/_webdesign/$webdesignSav/master.css\" />
	<!-- //Site CSS -->

	<!-- Comment CSS -->
		<link rel=\"stylesheet\" type=\"text/css\" href=\"$root/comments/_css/comments.css\" />
	<!-- //Comment CSS -->

	<!-- Special CSS -->
		";
		if(isset($pageCSSFile)){
			if(file_exists("$pageCSSFile")){
				echo"<link rel=\"stylesheet\" type=\"text/css\" href=\"$pageCSSFile\" />";
			}
			else{
				echo"<!-- <link rel=\"stylesheet\" type=\"text/css\" href=\"$pageCSSFile\" /> -->";
			}
		}
		echo"
	<!-- //Special CSS -->


	<!-- Favicon -->";
		if(file_exists("$root/_uploads/favicon/16x16.png")){
			echo"\n	<link rel=\"icon\" href=\"$root/_uploads/favicon/16x16.png\" type=\"image/png\" sizes=\"16x16\" />";
		}
		if(file_exists("$root/_uploads/favicon/32x32.png")){
			echo"\n	<link rel=\"icon\" href=\"$root/_uploads/favicon/32x32.png\" type=\"image/png\" sizes=\"32x32\" />";
		}
		if(file_exists("$root/_uploads/favicon/260x260.png")){
			echo"\n	<link rel=\"icon\" href=\"$root/_uploads/favicon/260x260.png\" type=\"image/png\" sizes=\"260x260\" />";
		}
		echo"	
	<!-- //Favicon -->

	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
	<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\"/>

	<!-- jQuery -->
		<script type=\"text/javascript\" src=\"$root/_scripts/javascripts/jquery/jquery-3.4.0.min.js\"></script>
		<!-- <script type=\"text/javascript\" src=\"$root/_admin/_javascripts/jquery/jquery-ui.js\"></script> -->
		<!-- <link rel=\"stylesheet\" type=\"text/css\" href=\"$root/_admin/_javascripts/jquery/jquery-ui.css\" /> -->
	<!-- //jQuery -->

	<!-- Hide show nav -->
		<script>
		\$(document).ready(function(){
			\$(\".toggle\").click(function () {
				var idname= \$(this).data('divid');
				\$(\".\"+idname).toggle();
			});
			\$(\".main_navigation_menu_icon\").click(function () {
				\$(\"#main_navigation\").toggle();
			});
		});
		</script>
	<!-- //Hide show nav -->

	<!-- Easter -->
	";
	$date_md = date("m-d");
	if($date_md == "12-24"){
		echo"		<script type=\"text/javascript\" src=\"$root/_webdesign/knowledge_webdesign/easter/snow/snow.js\"></script>\n";
	}
	echo"
	<!-- //Easter -->

</head>
<body>
<a id=\"top\"></a>
<!-- Test -->
	";
	if($configSiteIsTestSav == "1"){
		echo"<div class=\"topper_test\"><p>- $configWebsiteTitleSav Test ver $configWebsiteVersionSav -</p></div>\n";
	}
	echo"
<!-- //Test -->
	
<!-- Topper Notifications -->";
	if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
			
		// Me
		$my_user_id = $_SESSION['user_id'];
		$my_user_id = output_html($my_user_id);
		$my_user_id_mysql = quote_smart($link, $my_user_id);

		// Find notifications not seen
		$query = "SELECT notification_id, notification_user_id, notification_seen, notification_url, notification_text, notification_datetime, notification_emailed, notification_week FROM $t_users_notifications WHERE notification_user_id=$my_user_id_mysql AND notification_seen=0";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_notification_id, $get_current_notification_user_id, $get_current_notification_seen, $get_current_notification_url, $get_current_notification_text, $get_current_notification_datetime, $get_current_notification_emailed, $get_current_notification_week) = $row;
		
		if($get_current_notification_id != "" && isset($_GET['notification_id'])){
			$notification_id = $_GET['notification_id'];
			$notification_id = strip_tags(stripslashes($notification_id));
			if($notification_id == "$get_current_notification_id"){
				$result = mysqli_query($link, "UPDATE $t_users_notifications SET notification_seen=1 WHERE notification_id=$get_current_notification_id");
				$get_current_notification_id = "";
			}
		} 
		if($get_current_notification_id != ""){
			echo"
			<div class=\"topper_notifications\">
				<p><a href=\"$root/users/notifications.php?action=visit&notification_id=$get_current_notification_id&amp;l=$l&amp;process=1\"><img src=\"$root/users/_gfx/dialog-information_16x16.png\" alt=\"dialog-information.png\" /> $get_current_notification_text</a></p>
			</div>
			";
		} // notifcation != ""
	}
echo"
<!-- //Topper Notifications -->

<!-- Header -->
	<header>
		<div id=\"header_left\">
			<a href=\"$root\"><img src=\"$root/_webdesign/$webdesignSav/images/header/logo_icon_white_24dp.png\" alt=\"logo_icon_white.png\" /> <span>$configWebsiteTitleSav</span></a>
		</div>
		<div id=\"header_center\">
			<div id=\"main_navigation\">
				<ul>";
					// Translation
					include("$root/_admin/_translations/site/$l/knowledge/ts_header.php");
					include("$root/_admin/_translations/site/$l/edb/ts_header.php");
					include("$root/_admin/_translations/site/$l/office_calendar/ts_header.php");
					include("$root/_admin/_translations/site/$l/talk/ts_header.php");
					echo"
					<li><a href=\"$root/discuss/index.php?l=$l\">Forum</a></li>";

					// Total unread messages
					$t_talk_total_unread = $mysqlPrefixSav . "talk_total_unread";
					$get_total_unread_count = "";
					if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
						$my_user_id = $_SESSION['user_id'];
						$my_user_id = output_html($my_user_id);
						$my_user_id_mysql = quote_smart($link, $my_user_id);
						$query = "SELECT total_unread_id, total_unread_user_id, total_unread_count, total_unread_message FROM $t_talk_total_unread WHERE total_unread_user_id=$my_user_id_mysql";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_total_unread_id, $get_total_unread_user_id, $get_total_unread_count, $get_total_unread_message) = $row;
						if($get_total_unread_count == "" OR $get_total_unread_count == "0"){
							$get_total_unread_count = "";
						}
						else{
							$get_total_unread_count = " ($get_total_unread_count)";
						}
					}
					echo"
					<li><a href=\"$root/talk/index.php?l=$l\">$l_talk<b id=\"talk_total_unread_count\">$get_total_unread_count</b></a></li>
				</ul>
				<!-- Talk total unread messages count script -->
						<script language=\"javascript\" type=\"text/javascript\">
						\$(document).ready(function () {
							function talk_total_unread_count_look(){

								var data = 'l=$l';
            							\$.ajax({
                							type: \"POST\",
               								url: \"$root/talk/talk_total_unread_count.php\",
                							data: data,
									beforeSend: function(html) { // this happens before actual call
									},
               								success: function(html){
                    								\$(\"#talk_total_unread_count\").html(html);
              								}
       									
								});
							}
							setInterval(talk_total_unread_count_look,7000);
         					});
						</script>
				<!-- //Talk total unread messages count script -->
			</div> <!-- //main_navigation -->
		</div>
		<div id=\"header_right\">
			
			<div id=\"navigation_right\">
				<ul>
				";
				if(isset($_SESSION['user_id'])){
					echo"
					<li><a href=\"$root/users/view_profile.php?user_id=$get_my_user_id&amp;l=en\">$get_my_user_alias</a></li>
					<li><a href=\"$root/users/logout.php?process=1&amp;l=en\">$l_log_out</a></li>
					";
				}
				else{
					echo"
					<li><a href=\"$root/users/login.php?l=en\">$l_log_in</a></li>
					<li><a href=\"$root/users/create_free_account.php?l=en\">$l_registrer</a></li>
					";
				}
				echo"
					<li><a href=\"$root/knowledge/search.php?l=en\" class=\"sub_header_right_search\">$l_search</a></li>
				</ul>
			</div> <!-- //navigation_right -->



			<!-- Mobile navigation -->
				";
				echo"
				<div class=\"mobile_nav\">
					<ul>
						<li><a href=\"#\"><img src=\"$root/_webdesign/$webdesignSav/images/header/main_navigation_menu_icon_black.png\" alt=\"main_navigation_menu_icon.png\" class=\"main_navigation_menu_icon\" /></a></li>
						<li><a href=\"$root/search/index.php?l=$l\" id=\"mobile_bar_left_search\"><img src=\"$root/_webdesign/$webdesignSav/images/header/main_navigation_search_black.png\" alt=\"Search\" /></a></li>
						<li><a href=\"#\" id=\"ic_more_vert_link_img\"><img src=\"$root/_webdesign/$webdesignSav/images/header/ic_more_vert_black.png\" alt=\"ic_more_vert.png\" /></a></li>
					</ul>

					<script>
					\$(document).ready(function(){
						\$(\"#ic_more_vert_link_img\").click(function () {
							\$(\"#ic_more_vert_div\").toggle();
						});
					});
					</script>

					<!-- Mobile user menu -->
						<div id=\"ic_more_vert_div\">
							<ul>
							";
							if(isset($my_user_id)){
								echo"
								<li><a href=\"$root/users/my_profile.php?l=$l\">$get_my_user_alias</a></li>
								<li class=\"last\"><a href=\"$root/users/logout.php?process=1&amp;l=$l\">$l_logout</a></li>
								";
							}
							else{
								echo"
								<li><a href=\"$root/users/login.php?l=$l\">$l_login</a></li>
								<li class=\"last\"><a href=\"$root/users/create_free_account.php?l=$l\">$l_registrer</a></li>
								";
							}
							echo"
							</ul>
						</div>
					<!-- //Mobile user -->
				</div>
			<!-- //Mobile navigation -->

		</div> <!-- //header_right -->
	</header>
<!-- //Header -->





<!-- Main -->
	<div id=\"main_wrapper\">

	";
	// Find sub navigation
	$nav = "";
	if($root != "."){
		if(file_exists("navigation.php")){
			$nav = "navigation.php";
		}
		else{
			if(file_exists("../navigation.php")){
				$nav = "../navigation.php";
			}
			else{
				if(file_exists("../../navigation.php")){
					$nav = "../../navigation.php";
				}
			}
		}
	}

	if($nav != ""){
		echo"
		<div id=\"main_left\" class=\"main_left\">
		<!-- Menu -->
			<div id=\"div_toc\">";
				// Menu
				include("$nav");
				echo"
			</div>
		<!-- //Menu -->
		</div>
		<div id=\"main_center\">
		";
	}
	else{
		echo"
		<div id=\"main_center_single_colum\">";
	}
	echo"
			<div id=\"main_center_inner\">
	";


} // process != 1

?>