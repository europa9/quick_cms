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

		<!-- Header logo -->
			<div id=\"header_logo\">
				<a href=\"$root/index.php?l=$l\">$configWebsiteTitleSav</a>
			</div>
		<!-- //Header logo -->


		<!-- Header navigation -->
			<nav>
				<ul>";
				$count_parent = 0;
				$count_children = 0;
				$include_as_navigation_main_mode = 1; // We want to include navigation.php, in special navigation main mode

				$navigation_language_mysql = quote_smart($link, $l);
				$query_nav_main = "SELECT navigation_id, navigation_title, navigation_url_path, navigation_url_query FROM $t_navigation WHERE navigation_parent_id='0' AND navigation_language=$navigation_language_mysql ORDER BY navigation_weight ASC";
				$result_nav_main = mysqli_query($link, $query_nav_main);
						$row_cnt_nav_main = mysqli_num_rows($result_nav_main);
						while($row_nav_main = mysqli_fetch_row($result_nav_main)) {
							list($get_parent_navigation_id, $get_parent_navigation_title, $get_parent_navigation_url_path, $get_parent_navigation_url_query) = $row_nav_main;
					
							$query_children = "SELECT navigation_id, navigation_title, navigation_url_path, navigation_url_query FROM $t_navigation WHERE navigation_parent_id='$get_parent_navigation_id' AND navigation_language=$navigation_language_mysql ORDER BY navigation_weight ASC";
							$result_children = mysqli_query($link, $query_children);
							$row_cnt_children = mysqli_num_rows($result_children);
							$y = 1;
							while($row_children = mysqli_fetch_row($result_children)) {
								list($get_child_navigation_id, $get_child_navigation_title, $get_child_navigation_url_path, $get_child_navigation_url_query) = $row_children;


								if($count_children == 0){
									// Parent with children
									echo"				<li><a href=\"$root/$get_parent_navigation_url_path$get_parent_navigation_url_query\">$get_parent_navigation_title</a></li>\n";
								}


								echo"
								<!-- child here -->
								";
								$count_children++;
							}
							if($count_children == 0){
								if(file_exists("$root/$get_parent_navigation_url_path/navigation.php")){
									// Parent have children in php file
									echo"
									<li class=\"main_navigation_has_sub\"><a href=\"$root/$get_parent_navigation_url_path$get_parent_navigation_url_query\">$get_parent_navigation_title</a>  <img src=\"$root/_webdesign/$webdesignSav/images/main_navigation/main_navigation_has_sub_mobile.png\" alt=\"main_navigation_has_sub_mobile.png\" class=\"main_navigation_has_sub_mobile toggle\" data-divid=\"diplay_main_navigation_sub_$get_parent_navigation_id\" />
										<ul class=\"main_navigation_sub diplay_main_navigation_sub_$get_parent_navigation_id\">
									";
									include("$root/$get_parent_navigation_url_path/navigation.php");

									echo"
										</ul>
									</li>\n";
								}	
								else{
									// Parent doesnt have children
									echo"				<li><a href=\"$root/$get_parent_navigation_url_path$get_parent_navigation_url_query\">$get_parent_navigation_title</a></li>\n";
								}
							}
							$count_parent = 0;
							$count_children = 0;
						}
						$include_as_navigation_main_mode = 0; // We reset special navigation main mode
						echo"
						</ul>

			</nav>
		<!-- //Header navigation -->
	</div> <!-- //layout_left -->
	<div id=\"layout_center\">

	";
	

} // process != 1
?>