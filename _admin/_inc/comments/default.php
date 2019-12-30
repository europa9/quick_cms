<?php
/**
*
* File: _admin/_inc/comments/default.php
* Version 
* Date 20:17 30.10.2017
* Copyright (c) 2008-2017 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}
/*- Variables ------------------------------------------------------------------------ */
$tabindex = 0;

if(isset($_GET['where'])){
	$where = $_GET['where'];
	$where = output_html($where);
}
else {
	$where = "comment_approved != '-1'";
}

if($action == ""){
	echo"
	<h1>Comments</h1>
				

	<!-- Feedback -->
	";
	if($ft != ""){
		if($fm == "changes_saved"){
			$fm = "$l_changes_saved";
		}
		else{
			$fm = ucfirst($fm);
		}
		echo"<div class=\"$ft\"><span>$fm</span></div>";
	}
	echo"	
	<!-- //Feedback -->



	<!-- Filter -->
		<div class=\"tabs\">
			<ul>
				<li><a href=\"index.php?open=comments&amp;editor_language=$editor_language&amp;l=$l\" class=\"active\">Show all</a></li>
			</ul>
		</div>
		<div class=\"clear\" style=\"height: 20px;\"></div>
	<!-- //Filter -->

	<!-- List all comments -->
		
        	
		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\">
			<span>Author</span>
		   </th>
		   <th scope=\"col\">
			<span>Comment</span>
		   </th>
		   <th scope=\"col\">
			<span>Approved</span>
		   </th>
		   <th scope=\"col\">
			<span>In response to</span>
		   </th>
		   <th scope=\"col\">
			<span>IP</span>
		   </th>
		   <th scope=\"col\">
			<span>Actions</span>
		   </th>
		  </tr>
		</thead>
		<tbody>
		";
	


		$editor_language_mysql = quote_smart($link, $editor_language);
		$query = "SELECT comment_id, comment_user_id, comment_language, comment_object, comment_object_id, comment_parent_id, comment_user_ip, comment_user_hostname, comment_user_name, comment_user_avatar, comment_user_email, comment_user_subscribe, comment_created, comment_updated, comment_text, comment_likes, comment_dislikes, comment_reported, comment_reported_by_user_id, comment_reported_reason, comment_report_checked, comment_seen, comment_approved FROM $t_comments";
		
		if($where == "comment_approved != '-1'"){
			$query = $query  . " WHERE $where";
		}
		$query = $query  . " ORDER BY comment_id DESC";
		$result = mysqli_query($link, $query);
		if($result === FALSE){
			echo"	$query";
			echo"<div class=\"info\"><h1><img src=\"_design/gfx/loading_22.gif\" alt=\"Loading\" /> S E T U P</h1></div><meta http-equiv=\"refresh\" content=\"2;url=index.php?open=$open&amp;page=tables\">";
		}
		while($row = mysqli_fetch_row($result)) {
			list($get_comment_id, $get_comment_user_id, $get_comment_language, $get_comment_object, $get_comment_object_id, $get_comment_parent_id, $get_comment_user_ip, $get_comment_user_hostname, $get_comment_user_name, $get_comment_user_avatar, $get_comment_user_email, $get_comment_user_subscribe, $get_comment_created, $get_comment_updated, $get_comment_text, $get_comment_likes, $get_comment_dislikes, $get_comment_reported, $get_comment_reported_by_user_id, $get_comment_reported_reason, $get_comment_report_checked, $get_comment_seen, $get_comment_approved) = $row;

			if(isset($odd) && $odd == false){
				$odd = true;
			}
			else{
				$odd = false;
			}

			echo"
			<tr>
			  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
				<a id=\"comment$get_comment_id\"></a>
				";

				if($get_comment_user_avatar != "" && file_exists("../_uploads/users/images/$get_comment_user_id/$get_comment_user_avatar")){

					$inp_new_x = 35; // 950
					$inp_new_y = 35; // 640
					$thumb = "user_" . $get_comment_user_avatar . "-" . $inp_new_x . "x" . $inp_new_y . ".png";
					if(!(file_exists("../_cache/$thumb"))){
						resize_crop_image($inp_new_x, $inp_new_y, "../_uploads/users/images/$get_comment_user_id/$get_comment_user_avatar", "../_cache/$thumb");
					}

					echo"<a href=\"index.php?open=users&amp;page=users_edit_user&amp;user_id=$get_comment_user_id&amp;editor_language=$editor_language&amp;l=$l\"><img src=\"../_cache/$thumb\" alt=\"$get_comment_user_avatar\" class=\"image\" /></a><br />";
				

				}
				else{
					echo"<a href=\"index.php?open=users&amp;page=users_edit_user&amp;user_id=$get_comment_user_id&amp;editor_language=$editor_language&amp;l=$l\"><img src=\"_design/gfx/avatar_blank_35.png\" alt=\"avatar_blank_35.png\" /></a><br />";
				}

				echo"
				<a href=\"index.php?open=users&amp;page=users_edit_user&amp;user_id=$get_comment_user_id&amp;editor_language=$editor_language&amp;l=$l\">$get_comment_user_name</a>
			  </td>
			  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
				<span>
				$get_comment_text
				</span>
			  </td>
			  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
				<span>";
				if($get_comment_approved == 1){
					echo"Yes";
				}	
				else{
					echo"<a href=\"index.php?open=comments&amp;editor_language=$editor_language&amp;l=$l&amp;action=approve_comment&amp;comment_id=$get_comment_id&amp;process=1\">Approve</a>
					&middot; <a href=\"index.php?open=comments&amp;editor_language=$editor_language&amp;l=$l&amp;action=approve_comment_and_user&amp;comment_id=$get_comment_id&amp;process=1\">Approve and approve user</a><br />
					<a href=\"index.php?open=comments&amp;editor_language=$editor_language&amp;l=$l&amp;action=disapprove_comment&amp;comment_id=$get_comment_id&amp;process=1\">Disapprove</a>
					&middot;
					<a href=\"index.php?open=comments&amp;editor_language=$editor_language&amp;l=$l&amp;action=disapprove_comment_and_delete_user&amp;comment_id=$get_comment_id&amp;process=1\">Disapprove and delete user</a><br />
					<a href=\"index.php?open=comments&amp;editor_language=$editor_language&amp;l=$l&amp;action=mark_as_spam&amp;comment_id=$get_comment_id&amp;process=1\">Mark as spam</a>";
				}
				echo"</span>
			  </td>
			  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
				<span>
				";
				if($get_comment_object == "blog_post"){
					// Get blog post 
					$query_o = "SELECT blog_post_id, blog_post_title FROM $t_blog_posts WHERE blog_post_id=$get_comment_object_id";
					$result_o = mysqli_query($link, $query_o);
					$row_o = mysqli_fetch_row($result_o);
					list($get_blog_post_id, $get_blog_post_title) = $row_o;

					echo"
					<a href=\"../blog/view_post.php?post_id=$get_blog_post_id\">$get_blog_post_title</a>
					";
				}
				else{
					echo $get_comment_object;
				}
				echo"
				</span>
			  </td>
			  <td"; if($odd == true){ echo" class=\"odd\""; } echo" style=\"text-align:center;\">
				<span>$get_comment_user_ip<br />
				$get_comment_user_hostname</span>
			  </td>
			  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
				<span>
				<a href=\"index.php?open=$open&amp;page=edit_comment&amp;comment_id=$get_comment_id&amp;editor_language=$editor_language\">Edit</a>
				&middot;
				<a href=\"index.php?open=$open&amp;page=delete_comment&amp;comment_id=$get_comment_id&amp;editor_language=$editor_language\">Delete</a>
				</span>
			 </td>
			</tr>
			";
		}
		echo"
		 </tbody>
		</table>
	<!-- //List all comments -->
	";
}
elseif($action == "approve_comment" && $process == 1){
	if(isset($_GET['comment_id'])){
		$comment_id = $_GET['comment_id'];
		$comment_id = output_html($comment_id);
		$comment_id_mysql = quote_smart($link, $comment_id);


		$query = "SELECT comment_id, comment_user_id, comment_language, comment_object, comment_object_id, comment_parent_id, comment_user_ip, comment_user_name, comment_user_avatar, comment_user_email, comment_user_subscribe, comment_created, comment_updated, comment_text, comment_likes, comment_dislikes, comment_reported, comment_reported_by_user_id, comment_reported_reason, comment_report_checked, comment_seen, comment_approved FROM $t_comments WHERE comment_id=$comment_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_comment_id, $get_comment_user_id, $get_comment_language, $get_comment_object, $get_comment_object_id, $get_comment_parent_id, $get_comment_user_ip, $get_comment_user_name, $get_comment_user_avatar, $get_comment_user_email, $get_comment_user_subscribe, $get_comment_created, $get_comment_updated, $get_comment_text, $get_comment_likes, $get_comment_dislikes, $get_comment_reported, $get_comment_reported_by_user_id, $get_comment_reported_reason, $get_comment_report_checked, $get_comment_seen, $get_comment_approved) = $row;

		if($get_comment_id == ""){
			echo"
			<p>Comment not found.</p>
			";
		} // comment not found
		else{
			// Update
			$result = mysqli_query($link, "UPDATE $t_comments SET comment_approved='1' WHERE comment_id=$comment_id_mysql");

			header("Location: index.php?open=comments&editor_language=$editor_language&l=$l&ft=success&fm=comment_approved#comment$get_comment_id");
			exit;
		} // Comment found	

	} // isset comment id
	else{
		echo"<p>Missing comment id</p>";
	}
} // approve_comment
elseif($action == "approve_comment_and_user" && $process == 1){
	if(isset($_GET['comment_id'])){
		$comment_id = $_GET['comment_id'];
		$comment_id = output_html($comment_id);
		$comment_id_mysql = quote_smart($link, $comment_id);


		$query = "SELECT comment_id, comment_user_id, comment_language, comment_object, comment_object_id, comment_parent_id, comment_user_ip, comment_user_name, comment_user_avatar, comment_user_email, comment_user_subscribe, comment_created, comment_updated, comment_text, comment_likes, comment_dislikes, comment_reported, comment_reported_by_user_id, comment_reported_reason, comment_report_checked, comment_seen, comment_approved FROM $t_comments WHERE comment_id=$comment_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_comment_id, $get_comment_user_id, $get_comment_language, $get_comment_object, $get_comment_object_id, $get_comment_parent_id, $get_comment_user_ip, $get_comment_user_name, $get_comment_user_avatar, $get_comment_user_email, $get_comment_user_subscribe, $get_comment_created, $get_comment_updated, $get_comment_text, $get_comment_likes, $get_comment_dislikes, $get_comment_reported, $get_comment_reported_by_user_id, $get_comment_reported_reason, $get_comment_report_checked, $get_comment_seen, $get_comment_approved) = $row;

		if($get_comment_id == ""){
			echo"
			<p>Comment not found.</p>
			";
		} // comment not found
		else{
			// Update
			$result = mysqli_query($link, "UPDATE $t_comments SET comment_approved='1' WHERE comment_id=$comment_id_mysql");

			// Find author
			$query = "SELECT user_id, user_email, user_name, user_alias, user_password, user_password_replacement, user_password_date, user_salt, user_security, user_language, user_gender, user_height, user_measurement, user_dob, user_date_format, user_registered, user_registered_time, user_last_online, user_last_online_time, user_rank, user_points, user_points_rank, user_likes, user_dislikes, user_status, user_login_tries, user_last_ip, user_synchronized, user_verified_by_moderator, user_notes, user_marked_as_spammer FROM $t_users WHERE user_id=$get_comment_user_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_user_id, $get_user_email, $get_user_name, $get_user_alias, $get_user_password, $get_user_password_replacement, $get_user_password_date, $get_user_salt, $get_user_security, $get_user_language, $get_user_gender, $get_user_height, $get_user_measurement, $get_user_dob, $get_user_date_format, $get_user_registered, $get_user_registered_time, $get_user_last_online, $get_user_last_online_time, $get_user_rank, $get_user_points, $get_user_points_rank, $get_user_likes, $get_user_dislikes, $get_user_status, $get_user_login_tries, $get_user_last_ip, $get_user_synchronized, $get_user_verified_by_moderator, $get_user_notes, $get_user_marked_as_spammer) = $row;

			if($get_user_id != ""){
				$result = mysqli_query($link, "UPDATE $t_users SET user_verified_by_moderator='1' WHERE user_id=$get_user_id");
			}

			header("Location: index.php?open=comments&editor_language=$editor_language&l=$l&ft=success&fm=comment_nad_user_approved#comment$get_comment_id");
			exit;
		} // Comment found	

	} // isset comment id
	else{
		echo"<p>Missing comment id</p>";
	}
} // approve_comment_and_user
elseif($action == "disapprove_comment" && $process == 1){
	if(isset($_GET['comment_id'])){
		$comment_id = $_GET['comment_id'];
		$comment_id = output_html($comment_id);
		$comment_id_mysql = quote_smart($link, $comment_id);


		$query = "SELECT comment_id, comment_user_id, comment_language, comment_object, comment_object_id, comment_parent_id, comment_user_ip, comment_user_name, comment_user_avatar, comment_user_email, comment_user_subscribe, comment_created, comment_updated, comment_text, comment_likes, comment_dislikes, comment_reported, comment_reported_by_user_id, comment_reported_reason, comment_report_checked, comment_seen, comment_approved FROM $t_comments WHERE comment_id=$comment_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_comment_id, $get_comment_user_id, $get_comment_language, $get_comment_object, $get_comment_object_id, $get_comment_parent_id, $get_comment_user_ip, $get_comment_user_name, $get_comment_user_avatar, $get_comment_user_email, $get_comment_user_subscribe, $get_comment_created, $get_comment_updated, $get_comment_text, $get_comment_likes, $get_comment_dislikes, $get_comment_reported, $get_comment_reported_by_user_id, $get_comment_reported_reason, $get_comment_report_checked, $get_comment_seen, $get_comment_approved) = $row;

		if($get_comment_id == ""){
			echo"
			<p>Comment not found.</p>
			";
		} // comment not found
		else{
			// Update
			$result = mysqli_query($link, "UPDATE $t_comments SET comment_approved='-1' WHERE comment_id=$comment_id_mysql");

			header("Location: index.php?open=comments&editor_language=$editor_language&l=$l&ft=success&fm=comment_disapprove#comment$get_comment_id");
			exit;
		} // Comment found	

	} // isset comment id
	else{
		echo"<p>Missing comment id</p>";
	}
} // disapprove_comment
elseif($action == "disapprove_comment_and_delete_user" && $process == 1){
	if(isset($_GET['comment_id'])){
		$comment_id = $_GET['comment_id'];
		$comment_id = output_html($comment_id);
		$comment_id_mysql = quote_smart($link, $comment_id);


		$query = "SELECT comment_id, comment_user_id, comment_language, comment_object, comment_object_id, comment_parent_id, comment_user_ip, comment_user_name, comment_user_avatar, comment_user_email, comment_user_subscribe, comment_created, comment_updated, comment_text, comment_likes, comment_dislikes, comment_reported, comment_reported_by_user_id, comment_reported_reason, comment_report_checked, comment_seen, comment_approved FROM $t_comments WHERE comment_id=$comment_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_comment_id, $get_comment_user_id, $get_comment_language, $get_comment_object, $get_comment_object_id, $get_comment_parent_id, $get_comment_user_ip, $get_comment_user_name, $get_comment_user_avatar, $get_comment_user_email, $get_comment_user_subscribe, $get_comment_created, $get_comment_updated, $get_comment_text, $get_comment_likes, $get_comment_dislikes, $get_comment_reported, $get_comment_reported_by_user_id, $get_comment_reported_reason, $get_comment_report_checked, $get_comment_seen, $get_comment_approved) = $row;

		if($get_comment_id == ""){
			echo"
			<p>Comment not found.</p>
			";
		} // comment not found
		else{
			// Update
			$result = mysqli_query($link, "UPDATE $t_comments SET comment_approved='-1' WHERE comment_id=$comment_id_mysql");

			// Find author
			$query = "SELECT user_id, user_email, user_name, user_alias, user_password, user_password_replacement, user_password_date, user_salt, user_security, user_language, user_gender, user_height, user_measurement, user_dob, user_date_format, user_registered, user_registered_time, user_last_online, user_last_online_time, user_rank, user_points, user_points_rank, user_likes, user_dislikes, user_status, user_login_tries, user_last_ip, user_synchronized, user_verified_by_moderator, user_notes, user_marked_as_spammer FROM $t_users WHERE user_id=$get_comment_user_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_user_id, $get_user_email, $get_user_name, $get_user_alias, $get_user_password, $get_user_password_replacement, $get_user_password_date, $get_user_salt, $get_user_security, $get_user_language, $get_user_gender, $get_user_height, $get_user_measurement, $get_user_dob, $get_user_date_format, $get_user_registered, $get_user_registered_time, $get_user_last_online, $get_user_last_online_time, $get_user_rank, $get_user_points, $get_user_points_rank, $get_user_likes, $get_user_dislikes, $get_user_status, $get_user_login_tries, $get_user_last_ip, $get_user_synchronized, $get_user_verified_by_moderator, $get_user_notes, $get_user_marked_as_spammer) = $row;

			if($get_user_id != ""){
				$result = mysqli_query($link, "DELETE FROM $t_users WHERE user_id=$get_user_id");
			}

			header("Location: index.php?open=comments&editor_language=$editor_language&l=$l&ft=success&fm=comment_dissaproved_and_user_deleted#comment$get_comment_id");
			exit;
		} // Comment found	

	} // isset comment id
	else{
		echo"<p>Missing comment id</p>";
	}
} // disapprove_comment_and_delete_user
elseif($action == "mark_as_spam" && $process == 1){
	if(isset($_GET['comment_id'])){
		$comment_id = $_GET['comment_id'];
		$comment_id = output_html($comment_id);
		$comment_id_mysql = quote_smart($link, $comment_id);


		$query = "SELECT comment_id, comment_user_id, comment_language, comment_object, comment_object_id, comment_parent_id, comment_user_ip, comment_user_name, comment_user_avatar, comment_user_email, comment_user_subscribe, comment_created, comment_updated, comment_text, comment_likes, comment_dislikes, comment_reported, comment_reported_by_user_id, comment_reported_reason, comment_report_checked, comment_seen, comment_approved FROM $t_comments WHERE comment_id=$comment_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_comment_id, $get_comment_user_id, $get_comment_language, $get_comment_object, $get_comment_object_id, $get_comment_parent_id, $get_comment_user_ip, $get_comment_user_name, $get_comment_user_avatar, $get_comment_user_email, $get_comment_user_subscribe, $get_comment_created, $get_comment_updated, $get_comment_text, $get_comment_likes, $get_comment_dislikes, $get_comment_reported, $get_comment_reported_by_user_id, $get_comment_reported_reason, $get_comment_report_checked, $get_comment_seen, $get_comment_approved) = $row;

		if($get_comment_id == ""){
			echo"
			<p>Comment not found.</p>
			";
		} // comment not found
		else{
			// Update
			$result = mysqli_query($link, "UPDATE $t_comments SET comment_approved='-1', comment_marked_as_spam='1' WHERE comment_id=$comment_id_mysql");

			// Find author
			$query = "SELECT user_id, user_email, user_name, user_alias, user_password, user_password_replacement, user_password_date, user_salt, user_security, user_language, user_gender, user_height, user_measurement, user_dob, user_date_format, user_registered, user_registered_time, user_last_online, user_last_online_time, user_rank, user_points, user_points_rank, user_likes, user_dislikes, user_status, user_login_tries, user_last_ip, user_synchronized, user_verified_by_moderator, user_notes, user_marked_as_spammer FROM $t_users WHERE user_id=$get_comment_user_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_user_id, $get_user_email, $get_user_name, $get_user_alias, $get_user_password, $get_user_password_replacement, $get_user_password_date, $get_user_salt, $get_user_security, $get_user_language, $get_user_gender, $get_user_height, $get_user_measurement, $get_user_dob, $get_user_date_format, $get_user_registered, $get_user_registered_time, $get_user_last_online, $get_user_last_online_time, $get_user_rank, $get_user_points, $get_user_points_rank, $get_user_likes, $get_user_dislikes, $get_user_status, $get_user_login_tries, $get_user_last_ip, $get_user_synchronized, $get_user_verified_by_moderator, $get_user_notes, $get_user_marked_as_spammer) = $row;

			if($get_user_id != ""){
				$result = mysqli_query($link, "UPDATE $t_users SET user_verified_by_moderator='-1', user_marked_as_spammer='1' WHERE user_id=$get_user_id");
			}


			header("Location: index.php?open=comments&editor_language=$editor_language&l=$l&ft=success&fm=comment_and_user_mared_as_spam#comment$get_comment_id");
			exit;
		} // Comment found	

	} // isset comment id
	else{
		echo"<p>Missing comment id</p>";
	}
} // mark_as_spam
?>