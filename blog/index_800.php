<?php
/**
*
* File: blog/index.php
* Version 2.0.0
* Date 21:57 04.02.2019
* Copyright (c) 2008-2019 Sindre Andre Ditlefsen
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


/*- Blog config -------------------------------------------------------------------- */
include("$root/_admin/_data/blog.php");


/*- Variables ------------------------------------------------------------------------- */
$l_mysql = quote_smart($link, $l);


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
}
else{
	$order_method = "";
}


/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_blog";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");



// Logged in?
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	
	// Get my user
	$my_user_id = $_SESSION['user_id'];
	$my_user_id = output_html($my_user_id);
	$my_user_id_mysql = quote_smart($link, $my_user_id);
	$query = "SELECT user_id, user_email, user_name, user_alias, user_rank FROM $t_users WHERE user_id=$my_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_my_user_id, $get_my_user_email, $get_my_user_name, $get_my_user_alias, $get_my_user_rank) = $row;
}


echo"
<!-- Headline and language -->
		<div style=\"float: right;padding-top: 10px;\">
			<p style=\"padding:0px 0px 0px px;margin:0px 0px 0px 0px;\">
			<a href=\"rss_generate_all_blogs.php?l=$l\"><img src=\"_gfx/icons_24/rss_24.png\" alt=\"icons_24\" /></a>
			</p>
		</div>
	<h1>$l_blog</h1>
<!-- //Headline and language -->


<!-- Blog Quick menu -->
	<div style=\"height:10px;\"></div>
	<p>
	<a href=\"$root/blog/my_blog.php?l=$l\" class=\"btn_default\">$l_my_blog</a>
	<a href=\"$root/blog/my_blog_new_post.php?l=$l\" class=\"btn_default\">$l_new_post</a>
	</p>
	<div style=\"clear:both;height:10px;\"></div>
<!-- //Blog Quick menu -->


<!-- Show last posts -->
	";	
	$x = 0;
	$query_w = "SELECT blog_post_id, blog_post_user_id, blog_post_title, blog_post_category_id, blog_post_introduction, blog_post_privacy_level, blog_post_image_path, blog_post_image_thumb_small, blog_post_image_thumb_medium, blog_post_image_thumb_large, blog_post_image_file, blog_post_ad, blog_post_updated, blog_post_comments FROM $t_blog_posts WHERE blog_post_language=$l_mysql ORDER BY blog_post_id DESC";
	$result_w = mysqli_query($link, $query_w);
	while($row_w = mysqli_fetch_row($result_w)) {
		list($get_blog_post_id, $get_blog_post_user_id, $get_blog_post_title, $get_blog_post_category_id, $get_blog_post_introduction, $get_blog_post_privacy_level, $get_blog_post_image_path, $get_blog_post_image_thumb_small, $get_blog_post_image_thumb_medium, $get_blog_post_image_thumb_large, $get_blog_post_image_file, $get_blog_post_ad, $get_blog_post_updated, $get_blog_post_comments) = $row_w;


		// Intro
		if($get_blog_post_privacy_level == "everyone"){
			$show_post = "true";
		}
		else{
			if($get_blog_post_privacy_level == "private" && isset($my_user_id) && $my_user_id == "$get_blog_post_user_id"){
				$show_post = "true";
			}
			else{
				if($get_blog_post_privacy_level == "friends" && isset($my_user_id)){

					if($my_user_id == "$get_blog_post_user_id"){
						$show_post = "true";
					}
					else{
						// Are we friends? (me = a, post author = b)
						$query = "SELECT friend_id, friend_user_id_a, friend_user_id_b FROM $t_users_friends WHERE friend_user_id_a=$get_my_user_id AND friend_user_id_b=$get_blog_post_user_id";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_friend_id, $get_friend_user_id_a, $get_friend_user_id_b) = $row;

						if($get_friend_id == ""){
							$show_post = "false";

							// Are we friends? (me = b, post author = a)
							$query = "SELECT friend_id, friend_user_id_a, friend_user_id_b FROM $t_users_friends WHERE friend_user_id_a=$get_blog_post_user_id AND friend_user_id_b=$get_my_user_id";
							$result = mysqli_query($link, $query);
							$row = mysqli_fetch_row($result);
							list($get_friend_id, $get_friend_user_id_a, $get_friend_user_id_b) = $row;

							if($get_friend_id == ""){
								$show_post = "false";
							}
							else{
								$show_post = "true";
							}
						}
						else{
							$show_post = "true";
						}
					}
					
				}
				else{
					$show_post = "false";
				}
			}
		}
		
		if($show_post == "true" && $get_blog_post_image_file != "" && file_exists("$root/$get_blog_post_image_path/$get_blog_post_image_file")){
			// Owners user ID
			$query = "SELECT user_id, user_name, user_alias, user_rank FROM $t_users WHERE user_id=$get_blog_post_user_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_user_id, $get_user_name, $get_user_alias) = $row;
		

			// Date
			$year = substr($get_blog_post_updated, 0, 4);
			$month = substr($get_blog_post_updated, 5, 2);
			$day = substr($get_blog_post_updated, 8, 2);

			if($day < 10){
				$day = substr($day, 1, 1);
			}
		
			if($month == "01"){
				$month_saying = $l_january;
			}
			elseif($month == "02"){
				$month_saying = $l_february;
			}
			elseif($month == "03"){
				$month_saying = $l_march;
			}
			elseif($month == "04"){
				$month_saying = $l_april;
			}
			elseif($month == "05"){
				$month_saying = $l_may;
			}
			elseif($month == "06"){
				$month_saying = $l_june;
			}
			elseif($month == "07"){
				$month_saying = $l_july;
			}
			elseif($month == "08"){
				$month_saying = $l_august;
			}
			elseif($month == "09"){
				$month_saying = $l_september;
			}
			elseif($month == "10"){
				$month_saying = $l_october;
			}
			elseif($month == "11"){
				$month_saying = $l_november;
			}
			else{
				$month_saying = $l_december;
			}

			
			// Thumb small
			if(!(file_exists("../$get_blog_post_image_path/$get_blog_post_image_thumb_small")) OR $get_blog_post_image_thumb_small == ""){
				// Thumb name
				$extension = get_extension($get_blog_post_image_file);
				$extension = strtolower($extension);

				$thumb_name = $get_blog_post_id . "_thumb_" . $blogPostsThumbSmallSizeXSav . "x" . $blogPostsThumbSmallSizeYSav . "." . $extension;
				$thumb_name_mysql = quote_smart($link, $thumb_name);
				resize_crop_image($blogPostsThumbSmallSizeXSav, $blogPostsThumbSmallSizeYSav, "$root/$get_blog_post_image_path/$get_blog_post_image_file", "$root/$get_blog_post_image_path/$thumb_name");

				$result_update = mysqli_query($link, "UPDATE $t_blog_posts SET blog_post_image_thumb_small=$thumb_name_mysql WHERE blog_post_id=$get_blog_post_id") or die(mysqli_error($link));

			}

			// Thumb medium
			if(!(file_exists("../$get_blog_post_image_path/$get_blog_post_image_thumb_medium")) OR $get_blog_post_image_thumb_medium == ""){
				// Thumb name
				$extension = get_extension($get_blog_post_image_file);
				$extension = strtolower($extension);
				
				$thumb_name = $get_blog_post_id . "_thumb_" . $blogPostsThumbMediumSizeXSav . "x" . $blogPostsThumbMediumSizeYSav . "." . $extension;
				$thumb_name_mysql = quote_smart($link, $thumb_name);
				resize_crop_image($blogPostsThumbMediumSizeXSav, $blogPostsThumbMediumSizeYSav, "$root/$get_blog_post_image_path/$get_blog_post_image_file", "$root/$get_blog_post_image_path/$thumb_name");

				$result_update = mysqli_query($link, "UPDATE $t_blog_posts SET blog_post_image_thumb_medium=$thumb_name_mysql WHERE blog_post_id=$get_blog_post_id") or die(mysqli_error($link));

			}

			// Thumb large
			if(!(file_exists("../$get_blog_post_image_path/$get_blog_post_image_thumb_large")) OR $get_blog_post_image_thumb_large == ""){
				// Thumb name
				$extension = get_extension($get_blog_post_image_file);
				$extension = strtolower($extension);
				
				$thumb_name = $get_blog_post_id . "_thumb_" . $blogPostsThumbLargeSizeXSav . "x" . $blogPostsThumbLargeSizeYSav . "." . $extension;
				$thumb_name_mysql = quote_smart($link, $thumb_name);
				resize_crop_image($blogPostsThumbLargeSizeXSav, $blogPostsThumbLargeSizeYSav, "$root/$get_blog_post_image_path/$get_blog_post_image_file", "$root/$get_blog_post_image_path/$thumb_name");

				$result_update = mysqli_query($link, "UPDATE $t_blog_posts SET blog_post_image_thumb_large=$thumb_name_mysql WHERE blog_post_id=$get_blog_post_id") or die(mysqli_error($link));

			}


			if($x == 0){
				echo"
				<div class=\"blog_posts_row\">
					<div class=\"blog_posts_col_left\">
				";
			}
			elseif($x == 1){
				echo"
					<div class=\"blog_posts_col_right\">
				";
			}
	
			echo"
						<p style=\"padding-bottom:0;margin-bottom:0;\">
						<a href=\"view_post.php?post_id=$get_blog_post_id&amp;l=$l\"><img src=\"$root/$get_blog_post_image_path/$get_blog_post_image_thumb_medium\" alt=\"$get_blog_post_image_thumb_medium\" /></a><br />
						<a href=\"view_post.php?post_id=$get_blog_post_id&amp;l=$l\" class=\"h2\">$get_blog_post_title</a><br />
						</p>

						<div class=\"view_posts_author\">
							<p class=\"grey_small\" style=\"padding: 4px 0px 0px 0px;margin:0;\">
							$l_by 
							<a href=\"users/index.php?page=view_profile&amp;user_id=$get_blog_post_user_id&amp;l=$l\" class=\"small\">$get_user_alias</a>
							</p>
						</div>
						<div style=\"width: $blogPostsThumbMediumSizeXSav";echo"px;\">
							<div class=\"view_posts_date\">
								<p class=\"grey_small\" style=\"padding: 4px 0px 0px 0px;margin:0;\">
								$day
								$month_saying
								$year
								</p>
							</div>
							<div class=\"view_posts_comments\">
								<p class=\"grey_small\" style=\"padding: 4px 0px 0px 0px;margin:0;\">";
								if($get_blog_post_ad == "1"){
									echo"$l_ad &middot; ";
								}
								echo"
								<a href=\"view_post.php?post_id=$get_blog_post_id&amp;l=$l#comments\" class=\"small\">$get_blog_post_comments
								$l_comments</a>
								</p>
							</div>
						</div>
			";

				
			if($x == 0){
				echo"
						<hr class=\"view_posts\" />
					</div> <!-- //blog_posts_col_left -->
				";
			}
			if($x == 1){
				echo"
						<hr class=\"view_posts\" />
					</div> <!-- //blog_posts_col_right -->
				</div> <!-- //blog_posts_row -->
				";
				$x = -1;
			}
		
			$x++;
		}
	} // loop
	if($x == 1){
		echo"
					<div class=\"blog_posts_col_right\">
					</div> <!-- //blog_posts_col_right -->
				</div> <!-- //blog_posts_row -->
		";
	}
	
	echo"
<!-- //Show last posts -->

";


/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>