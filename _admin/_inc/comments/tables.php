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
$t_comments 		= $mysqlPrefixSav . "comments";
$t_comments_users_block = $mysqlPrefixSav . "comments_users_block";

echo"
<h1>Tables</h1>


	<!-- comments -->
	";
	$query = "SELECT * FROM $t_comments";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_comments: $row_cnt</p>
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

		
		<meta http-equiv=\"refresh\" content=\"1;url=index.php?open=$open\">
		";


		mysqli_query($link, "CREATE TABLE $t_comments(
	  	 comment_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(comment_id), 
	  	   comment_user_id INT,
	  	   comment_language VARCHAR(50),
	  	   comment_object VARCHAR(250),
	  	   comment_object_id INT,
	  	   comment_parent_id INT,
	  	   comment_user_ip VARCHAR(250),
	  	   comment_user_hostname VARCHAR(250),
	  	   comment_user_name VARCHAR(250),
	  	   comment_user_avatar VARCHAR(250),
	  	   comment_user_email VARCHAR(250),
	  	   comment_user_subscribe INT,
	  	   comment_created DATETIME,
	  	   comment_updated DATETIME,
	  	   comment_text TEXT,
	  	   comment_likes INT,
	  	   comment_dislikes INT,
	  	   comment_reported INT,
	  	   comment_reported_by_user_id INT,
	  	   comment_reported_reason VARCHAR(200),
	  	   comment_report_checked VARCHAR(200),
	  	   comment_seen INT,
	  	   comment_approved INT,
	  	   comment_marked_as_spam INT)")
		   or die(mysqli_error());
	}
	echo"
	<!-- comments -->


	<!-- $t_comments_users_block -->
	";
	$query = "SELECT * FROM $t_comments_users_block";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_comments_users_block: $row_cnt</p>
		";
	}
	else{

		mysqli_query($link, "CREATE TABLE $t_comments_users_block(
	  	 block_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(block_id), 
	  	   block_user_id INT,
	  	   block_user_ip VARCHAR(250),
	  	   block_object VARCHAR(250),
	  	   block_object_id INT,
	  	   block_to_date INT
	  	   block_to_week INT)")
		   or die(mysqli_error());
	}
	echo"
	<!-- $t_comments_users_block -->
	";
?>