<?php
/**
*
* File: _admin/_inc/blog/_liquibase/posts_comments_likes_dislikes.php
* Version 1.0.0
* Date 21:47 31.10.2020
* Copyright (c) 2020 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}

/*- Tables ---------------------------------------------------------------------------- */

$result = mysqli_query($link, "DROP TABLE IF EXISTS $t_blog_posts_comments_likes_dislikes");

echo"
<!-- posts_comments_likes_dislikes -->
	";

	
	$query = "SELECT * FROM $t_blog_posts_comments_likes_dislikes";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_blog_posts_comments_likes_dislikes: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_blog_posts_comments_likes_dislikes(
	  	 likes_dislike_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(likes_dislike_id), 
	  	   likes_dislike_post_id INT,
	  	   likes_dislike_info_id INT,
	  	   likes_dislike_comment_id INT,
	  	   likes_dislike_user_id INT,
	  	   likes_dislike_direction VARCHAR(10))")
		   or die(mysqli_error());

	}
	echo"
<!-- //posts_comments_likes_dislikes -->

";
?>