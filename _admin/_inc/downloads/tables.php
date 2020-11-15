<?php
/**
*
* File: _admin/_inc/downloads/tables.php
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
$t_downloads_index 				= $mysqlPrefixSav . "downloads_index";
$t_downloads_comments				= $mysqlPrefixSav . "downloads_comments";

$t_downloads_main_categories 			= $mysqlPrefixSav . "downloads_main_categories";
$t_downloads_main_categories_translations 	= $mysqlPrefixSav . "downloads_main_categories_translations";

$t_downloads_sub_categories 			= $mysqlPrefixSav . "downloads_sub_categories";
$t_downloads_sub_categories_translations 	= $mysqlPrefixSav . "downloads_sub_categories_translations";



echo"
<h1>Tables</h1>



	<!-- downloads_main_categories -->
	";
	$query = "SELECT * FROM $t_downloads_main_categories";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_downloads_main_categories: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_downloads_main_categories(
	  	 main_category_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(main_category_id), 
	  	   main_category_title VARCHAR(200),
	  	   main_category_title_clean VARCHAR(200),
	  	   main_category_icon_path VARCHAR(100),
	  	   main_category_icon_file VARCHAR(100),
	  	   main_category_created DATETIME)");


		$datetime = date("Y-m-d H:i:s");
		mysqli_query($link, "INSERT INTO $t_downloads_main_categories
		(`main_category_id`, `main_category_title`, `main_category_title_clean`, `main_category_icon_path`, `main_category_icon_file`, `main_category_created`)
		VALUES
		(NULL, 'Downloads', 'downloads', '_uploads/downloads/_icons', '1.png', '$datetime')");
	}
	echo"
	<!-- //downloads_main_categories -->

	<!-- downloads_main_categories_translations -->
	";
	$query = "SELECT * FROM $t_downloads_main_categories_translations";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_downloads_main_categories_translations: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_downloads_main_categories_translations(
	  	 main_category_translation_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(main_category_translation_id), 
	  	   main_category_id INT,
	  	   main_category_translation_language VARCHAR(20),
	  	   main_category_translation_value VARCHAR(200))");
	}
	echo"
	<!-- //downloads_main_categories_translations -->


	<!-- downloads_sub_categories -->
	";
	$query = "SELECT * FROM $t_downloads_sub_categories";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_downloads_sub_categories: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_downloads_sub_categories(
	  	 sub_category_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(sub_category_id), 
	  	   sub_category_parent_id INT,
	  	   sub_category_title VARCHAR(200),
	  	   sub_category_title_clean VARCHAR(200),
	  	   sub_category_icon_path VARCHAR(100),
	  	   sub_category_icon_file VARCHAR(100),
	  	   sub_category_created DATETIME)");

		$datetime = date("Y-m-d H:i:s");

	}
	echo"
	<!-- //downloads_sub_categories -->

	<!-- downloads_sub_categories_translations -->
	";
	$query = "SELECT * FROM $t_downloads_sub_categories_translations";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_downloads_sub_categories_translations: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_downloads_sub_categories_translations(
	  	 sub_category_translation_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(sub_category_translation_id), 
	  	   sub_category_id INT,
	  	   sub_category_translation_language VARCHAR(20),
	  	   sub_category_translation_value VARCHAR(200))");
	}
	echo"
	<!-- //downloads_sub_categories_translations -->

	<!-- downloads_index -->
	";
	$query = "SELECT * FROM $t_downloads_index";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_downloads_index: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_downloads_index(
	  	 download_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(download_id), 
	  	   download_title VARCHAR(200),
	  	   download_title_short VARCHAR(200),
	  	   download_title_length INT,
	  	   download_language VARCHAR(200),
	  	   download_introduction VARCHAR(200),
	  	   download_description TEXT,
	  	   download_video VARCHAR(200),
	  	   download_image_path VARCHAR(200),
	  	   download_image_store VARCHAR(200),
	  	   download_image_store_thumb VARCHAR(200),
	  	   download_image_thumb_a VARCHAR(200),
	  	   download_image_thumb_b VARCHAR(200),
	  	   download_image_thumb_c VARCHAR(200),
	  	   download_image_thumb_d VARCHAR(200),
	  	   download_image_file_a VARCHAR(200),
	  	   download_image_file_b VARCHAR(200),
	  	   download_image_file_c VARCHAR(200),
	  	   download_image_file_d VARCHAR(200),
	  	   download_read_more_url VARCHAR(200),
	  	   download_main_category_id INT,
	  	   download_sub_category_id INT,
	  	   download_dir VARCHAR(50),
	  	   download_file VARCHAR(250),
	  	   download_type VARCHAR(4),
	  	   download_version VARCHAR(20),
	  	   download_file_size VARCHAR(50),
	  	   download_file_date DATE,
	  	   download_file_date_print VARCHAR(50),
	  	   download_last_download DATE,
	  	   download_hits INT,
	  	   download_unique_hits INT,
	  	   download_ip_block TEXT,
	  	   download_tag_a VARCHAR(100),
	  	   download_tag_b VARCHAR(100),
	  	   download_tag_c VARCHAR(100),
	  	   download_created_datetime DATETIME,
	  	   download_updated_datetime DATETIME,
	  	   download_updated_print VARCHAR(50),
	  	   download_have_to_be_logged_in_to_download INT)");
	}
	echo"
	<!-- //downloads_index -->

	
	<!-- downloads_comments -->
	";
	$query = "SELECT * FROM $t_downloads_comments";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_downloads_comments: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_downloads_comments(
	  	 comment_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(comment_id), 
	  	   comment_download_id INT,
	  	   comment_text TEXT,
	  	   comment_by_user_id INT,
	  	   comment_by_user_name VARCHAR(50),
	  	   comment_by_user_image_path VARCHAR(250),
	  	   comment_by_user_image_file VARCHAR(50),
	  	   comment_by_user_image_thumb_60 VARCHAR(50),
	  	   comment_by_user_ip VARCHAR(200),
	  	   comment_created DATETIME,
	  	   comment_created_saying VARCHAR(50),
	  	   comment_created_timestamp VARCHAR(50),
	  	   comment_updated DATETIME,
	  	   comment_updated_saying VARCHAR(50),
	  	   comment_likes INT,
	  	   comment_dislikes INT,
	  	   comment_number_of_replies INT,
	  	   comment_read_blog_owner INT,
	  	   comment_reported INT,
	  	   comment_reported_by_user_id INT,
	  	   comment_reported_reason TEXT,
	  	   comment_reported_checked INT)")
		   or die(mysqli_error());
	}
	echo"
	<!-- //downloads_comments -->
	";
?>