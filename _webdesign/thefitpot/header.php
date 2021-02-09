<?php
/**
*
* File: _webdesign/thefitpot/header.php
* Version 3.1
* Date 17:55 07.02.2021
* Copyright (c) 2021 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/*- Web design start ------------------------------------------------------------------ */
if($process != "1") {
echo"<!DOCTYPE html>
<html lang=\"$l\">
<head>
	<title>$configWebsiteTitleSav";
	if(isset($website_title)){
		echo" - $website_title";
	}
	else{
		$website_title = $_SERVER['PHP_SELF'];
		$website_title = str_replace("/", " - ", $website_title);
		$website_title = str_replace(".php", "", $website_title);
		$website_title = str_replace("_", " ", $website_title);
		$website_title = ucwords($website_title);
		echo" - $website_title";
	}
	echo"</title>

	<!-- Site CSS-->
		<link rel=\"stylesheet\" type=\"text/css\" href=\"$root/_webdesign/$webdesignSav/master.css?rand="; $datetime = date("Y-m-d H:i:s"); echo"$datetime\" />
	<!-- //Site CSS -->

	<!-- Special CSS -->
		";
		if(isset($pageCSSFile)){
			if(file_exists("$pageCSSFile")){
				echo"<link rel=\"stylesheet\" type=\"text/css\" href=\"$pageCSSFile?rand=$datetime\" />";
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
	<meta name=\"viewport\" content=\"width=device-width; initial-scale=1.0;\"/>

	<!-- jQuery -->
		<script type=\"text/javascript\" src=\"$root/_scripts/javascripts/jquery/jquery-3.4.0.min.js\"></script>
	<!-- //jQuery -->

	";
	if($root == "." && file_exists("_uploads/slides/$l/slides.php")){
		echo"
		<!-- Carousel -->
		<script type=\"text/javascript\" src=\"$root/_scripts/javascripts/carousel/owl.carousel.min.js\"></script>
		<link rel=\"stylesheet\" href=\"$root/_scripts/javascripts/carousel/owl.carousel.css\" />
		<link rel=\"stylesheet\" href=\"$root/_scripts/javascripts/carousel/owl.theme.css\" />
		<link rel=\"stylesheet\" href=\"$root/_scripts/javascripts/carousel/owl.transitions.css\" />
		<link rel=\"stylesheet\" href=\"$root/_scripts/javascripts/carousel/custom.css\" />
		<script>
		\$(document).ready(function() {
 
			\$(\"#owl-example\").owlCarousel({
				navigation : false, 
      				slideSpeed : 300,
      				paginationSpeed : 400,
      				singleItem: true,
				pagination: true,
    				rewindSpeed: 500
			});
 
		});
		</script>
			
		<link rel=\"stylesheet\" type=\"text/css\" href=\"_uploads/slides/$l/slides.css\" />

		<!-- //Carousel -->
		";
	}
	echo"

</head>
<body>
<a id=\"top\"></a>


<div id=\"layout_wrapper\">
	<div id=\"layout_left\">

		<!-- Logo -->
			<div id=\"logo\">
				<a href=\"$root/index.php?l=$l\" title=\"$configWebsiteTitleSav\">The<span></span>Fit<span></span>Pot</a>
			</div>
		<!-- //Logo -->


		<!-- Left navigation -->
			<nav>
				<ul class=\"main_navigation\">\n";
				$navigation_language_mysql = quote_smart($link, $l);
				$query_nav_main = "SELECT navigation_id, navigation_parent_id, navigation_title, navigation_title_clean, navigation_url, navigation_url_path, navigation_url_query, navigation_language, navigation_internal_or_external, navigation_icon_path, navigation_icon_16x16_inactive, navigation_icon_16x16_hover, navigation_icon_16x16_active, navigation_icon_18x18_inactive, navigation_icon_18x18_hover, navigation_icon_18x18_active, navigation_weight, navigation_created_datetime, navigation_created_by_user_id, navigation_updated_datetime, navigation_updated_by_user_id FROM $t_pages_navigation WHERE navigation_parent_id='0' AND navigation_language=$navigation_language_mysql ORDER BY navigation_weight ASC";
				$result_nav_main = mysqli_query($link, $query_nav_main);
				$row_cnt_nav_main = mysqli_num_rows($result_nav_main);
				while($row_nav_main = mysqli_fetch_row($result_nav_main)) {
					list($get_parent_navigation_id, $get_parent_navigation_parent_id, $get_parent_navigation_title, $get_parent_navigation_title_clean, $get_parent_navigation_url, $get_parent_navigation_url_path, $get_parent_navigation_url_query, $get_parent_navigation_language, $get_parent_navigation_internal_or_external, $get_parent_navigation_icon_path, $get_parent_navigation_icon_16x16_inactive, $get_parent_navigation_icon_16x16_hover, $get_parent_navigation_icon_16x16_active, $get_parent_navigation_icon_18x18_inactive, $get_parent_navigation_icon_18x18_hover, $get_parent_navigation_icon_18x18_active, $get_parent_navigation_weight, $get_parent_navigation_created_datetime, $get_parent_navigation_created_by_user_id, $get_parent_navigation_updated_datetime, $get_parent_navigation_updated_by_user_id) = $row_nav_main;
					echo"				";
					echo"				<li><a href=\"$root/$get_parent_navigation_url_path$get_parent_navigation_url_query\" class=\"nav_$get_parent_navigation_title_clean\">$get_parent_navigation_title</a></li>\n";
				}
				echo"
				</ul>
			</nav>

		<!-- //Left navigation -->


		<!-- Left Bottom -->
			<div class=\"left_bottom\">
				<ul>
				";
				// Am I logged in?
				if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
					// Get my user alias, date format, profile image
					$my_user_id 	  = $_SESSION['user_id'];
					$my_user_id_mysql = quote_smart($link, $my_user_id);

					// User
					$query = "SELECT user_id, user_name, user_alias, user_date_format FROM $t_users WHERE user_id=$my_user_id_mysql";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_my_user_id, $get_my_user_name, $get_my_user_alias, $get_my_user_date_format) = $row;
					if($get_my_user_id == ""){
						echo"<p style=\"color:red\">Session error</p>";
						unset($_SESSION['user_id']);
					}

					// Image
					$query = "SELECT photo_id, photo_user_id, photo_profile_image, photo_title, photo_destination, photo_thumb_40, photo_thumb_50, photo_thumb_60 FROM $t_users_profile_photo WHERE photo_user_id=$get_my_user_id";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_my_photo_id, $get_my_photo_user_id, $get_my_photo_profile_image, $get_my_photo_title, $get_my_photo_destination, $get_my_photo_thumb_40, $get_my_photo_thumb_50, $get_my_photo_thumb_60) = $row;

					echo"
					<li><a href=\"$root/users/my_profile.php?l=$l\">";
					if(file_exists("$root/$get_my_photo_destination/$get_my_photo_thumb_40") && $get_my_photo_thumb_40 != ""){
						echo"<img src=\"$root/$get_my_photo_destination/$get_my_photo_thumb_40\" alt=\"$get_my_photo_thumb_40\" title=\"$get_my_user_alias\" />";
					}
					else{
						echo"<img src=\"$root/_webdesign/thefitpot/images/left/user_no_image_30.png\" alt=\"user_no_image_40.png\" />";
					}

					echo" $get_my_user_name</a></li>
					";
				}
				else{
					echo"
					<li><a href=\"$root/users/login.php?l=$l\" class=\"last\"><img src=\"$root/_webdesign/$webdesignSav/images/header/ic_login_24x24_333333.png\" alt=\"ic_login_24x24_333333.png\" title=\"$l_login\" /></a></li>
					";
				}
				echo"
				</ul>
			</div>
		<!-- //Left Bottom -->
	</div> <!-- //layout_left -->
	<div id=\"layout_center\">

	";
	

} // process != 1
?>