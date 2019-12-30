<?php
/**
*
* File: _admin/_inc/blog/tables.php
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

/*- Functions ------------------------------------------------------------------------ */
function fix_utf($value){
	$value = str_replace("Ã¸", "�", $value);
	$value = str_replace("Ã¥", "�", $value);

        return $value;
}
function fix_local($value){
	$value = htmlentities($value);

        return $value;
}
/*- Tables ---------------------------------------------------------------------------- */
$t_blog_info 		= $mysqlPrefixSav . "blog_info";
$t_blog_categories	= $mysqlPrefixSav . "blog_categories";
$t_blog_posts 		= $mysqlPrefixSav . "blog_posts";
$t_blog_posts_tags 	= $mysqlPrefixSav . "blog_posts_tags";
$t_blog_images 		= $mysqlPrefixSav . "blog_images";
$t_blog_logos		= $mysqlPrefixSav . "blog_logos";

$t_blog_links_index		= $mysqlPrefixSav . "blog_links_index";
$t_blog_links_categories	= $mysqlPrefixSav . "blog_links_categories";

$t_blog_ping_list_per_blog	= $mysqlPrefixSav . "blog_ping_list_per_blog";

echo"
<h1>Tables</h1>


	<!-- blog_info -->
	";

	
	$query = "SELECT * FROM $t_blog_info";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_blog_info: $row_cnt</p>
		";
	}
	else{
		echo"
		<table>
		 <tr> 
		  <td style=\"padding-right: 6px;\">
			<p>
			<img src=\"_design/gfx/loading_22.gif\" alt=\"Loading\" />
			</p>
		  </td>
		  <td>
			<h1>Loading...</h1>
		  </td>
		 </tr>
		</table>

		
		<meta http-equiv=\"refresh\" content=\"2;url=index.php?open=$open&amp;page=tables\">
		";


		mysqli_query($link, "CREATE TABLE $t_blog_info(
	  	 blog_info_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(blog_info_id), 
	  	   blog_user_id INT,
	  	   blog_language VARCHAR(50),
	  	   blog_title VARCHAR(250),
	  	   blog_description TEXT,
	  	   blog_created DATETIME,
	  	   blog_updated DATETIME,
	  	   blog_updated_rss VARCHAR(250),
	  	   blog_posts INT,
	  	   blog_comments INT,
	  	   blog_views INT,
	  	   blog_views_ipblock VARCHAR(250),
	  	   blog_user_ip VARCHAR(250))")
		   or die(mysqli_error());

	}
	echo"
	<!-- //blog_info -->

	
	<!-- blog_categories -->
	";

	
	$query = "SELECT * FROM $t_blog_categories";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_blog_categories: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_blog_categories(
	  	 blog_category_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(blog_category_id), 
	  	   blog_category_user_id INT,
	  	   blog_category_language VARCHAR(50),
	  	   blog_category_title VARCHAR(250), 
	  	   blog_category_posts INT)")
		   or die(mysqli_error());

	}
	echo"
	<!-- //blog_categories -->

	<!-- blog_posts -->
	";
	$query = "SELECT * FROM $t_blog_posts";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_blog_posts: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_blog_posts(
	  	 blog_post_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(blog_post_id), 
	  	   blog_post_user_id INT,
	  	   blog_post_title VARCHAR(250), 
	  	   blog_post_language VARCHAR(50),
	  	   blog_post_category_id INT,
	  	   blog_post_introduction TEXT, 
	  	   blog_post_privacy_level VARCHAR(25),
	  	   blog_post_text TEXT,  
	  	   blog_post_image_path VARCHAR(250),
	  	   blog_post_image_thumb_small VARCHAR(250),
	  	   blog_post_image_thumb_medium VARCHAR(250),
	  	   blog_post_image_thumb_large VARCHAR(250),
	  	   blog_post_image_file VARCHAR(250),
	  	   blog_post_image_text TEXT,
	  	   blog_post_ad INT,
	  	   blog_post_created DATETIME,
	  	   blog_post_created_rss VARCHAR(200),
	  	   blog_post_updated DATETIME,
	  	   blog_post_updated_rss VARCHAR(200),
	  	   blog_post_allow_comments INT,
	  	   blog_post_comments INT, 
	  	   blog_post_views INT, 
	  	   blog_post_views_ipblock VARCHAR(250),
	  	   blog_post_user_ip VARCHAR(250))")
		   or die(mysqli_error());

	}
	echo"
	<!-- //blog_posts -->

	<!-- blog_posts_tags -->
	";
	$query = "SELECT * FROM $t_blog_posts_tags";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_blog_posts_tags: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_blog_posts_tags(
	  	 blog_post_tag_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(blog_post_tag_id), 
	  	   blog_post_id INT,
	  	   blog_post_tag_language VARCHAR(50),
	  	   blog_post_tag_title VARCHAR(250))")
		   or die(mysqli_error());

	}
	echo"
	<!-- //blog_posts_tags -->

	<!-- blog_images -->
	";
	$query = "SELECT * FROM $t_blog_images";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_blog_images: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_blog_images(
	  	 image_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(image_id), 
	  	   image_user_id INT,
	  	   image_title VARCHAR(200),
	  	   image_path VARCHAR(200),
	  	   image_thumb VARCHAR(200),
	  	   image_file VARCHAR(200),
	  	   image_uploaded_datetime DATETIME,
	  	   image_uploaded_ip VARCHAR(200),
	  	   image_unique_views INT,
	  	   image_ip_block TEXT,
	  	   image_reported INT,
	  	   image_reported_checked VARCHAR(200),
	  	   image_likes INT,
	  	   image_dislikes INT,
	  	   image_likes_dislikes_ipblock TEXT,
	  	   image_comments INT)")
		   or die(mysqli_error());

	}
	echo"
	<!-- //blog_images -->



	<!-- blog_logos -->
	";
	$query = "SELECT * FROM $t_blog_logos";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_blog_logos: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_blog_logos(
	  	 logo_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(logo_id), 
	  	   logo_blog_info_id INT,
	  	   logo_user_id INT,
	  	   logo_path VARCHAR(200),
	  	   logo_thumb VARCHAR(200),
	  	   logo_file VARCHAR(200),
	  	   logo_uploaded_datetime DATETIME,
	  	   logo_uploaded_ip VARCHAR(200),
	  	   logo_reported INT,
	  	   logo_reported_checked VARCHAR(200))")
		   or die(mysqli_error());

	}
	echo"
	<!-- //blog_logos -->



	<!-- blog_links_categories -->
	";
	$query = "SELECT * FROM $t_blog_links_categories";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_blog_links_categories: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_blog_links_categories(
	  	 category_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(category_id), 
	  	   category_blog_info_id INT,
	  	   category_user_id INT,
	  	   category_title VARCHAR(200))")
		   or die(mysqli_error());

	}
	echo"
	<!-- //blog_links_categories -->


	<!-- blog_links_index -->
	";
	$query = "SELECT * FROM $t_blog_links_index";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_blog_links_index: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_blog_links_index(
	  	 link_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(link_id), 
	  	   link_blog_info_id INT,
	  	   link_user_id INT,
	  	   link_category_id INT,
	  	   link_title VARCHAR(200),
	  	   link_url_real VARCHAR(200),
	  	   link_url_display VARCHAR(200),
	  	   link_description VARCHAR(200),
	  	   link_is_ad INT,
	  	   link_img_path VARCHAR(200),
	  	   link_img_file VARCHAR(200),
	  	   link_clicks_unique INT,
	  	   link_clicks_unique_ipblock TEXT,
	  	   link_added DATETIME,
	  	   link_edited DATETIME)")
		   or die(mysqli_error());
	}
	echo"
	<!-- //blog_links_index -->

	<!-- blog_ping_list_per_bog -->
	";
	$query = "SELECT * FROM $t_blog_ping_list_per_blog";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_blog_ping_list_per_blog: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_blog_ping_list_per_blog(
	  	 ping_list_per_blog_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(ping_list_per_blog_id), 
	  	   ping_list_per_blog_blog_info_id INT,
	  	   ping_list_per_blog_user_id INT,
	  	   ping_list_per_blog_title VARCHAR(200),
	  	   ping_list_per_blog_url VARCHAR(200),
	  	   ping_list_per_blog_last_pinged_year INT,
	  	   ping_list_per_blog_last_pinged_month INT,
	  	   ping_list_per_blog_last_pinged_day INT,
	  	   ping_list_per_blog_last_pinged_datetime_print VARCHAR(200),
	  	   ping_list_per_blog_added DATETIME,
	  	   ping_list_per_blog_edited DATETIME)")
		   or die(mysqli_error());
	}
	echo"
	<!-- //blog_ping_list_per_bog -->

	 
	";
?>