<?php
/**
*
* File: _admin/_inc/blog/_liquibase/info.php
* Version 1.0.0
* Date 21:19 28.08.2019
* Copyright (c) 2019 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}

/*- Tables ---------------------------------------------------------------------------- */



echo"
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


";
?>