<?php 
/**
*
* File: food/view_food_include_fetch_comments.php
* Version 1.0.0
* Date 12:05 10.02.2018
* Copyright (c) 2011-2018 S. A. Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if(!(isset($get_current_food_id))){
	echo"error";
	die;
}




$count_ratings = 0;
$query = "SELECT rating_id, rating_food_id, rating_text, rating_by_user_id, rating_by_user_name, rating_by_user_image_path, rating_by_user_image_file, rating_by_user_image_thumb_60, rating_by_user_ip, rating_starts, rating_created, rating_created_saying, rating_created_timestamp, rating_updated, rating_updated_saying, rating_likes, rating_dislikes, rating_number_of_replies, rating_read_blog_owner, rating_reported, rating_reported_by_user_id, rating_reported_reason, rating_reported_checked FROM $t_food_index_ratings WHERE rating_food_id=$get_current_food_id";
$result = mysqli_query($link, $query);
while($row = mysqli_fetch_row($result)) {
	list($get_rating_id, $get_rating_food_id, $get_rating_text, $get_rating_by_user_id, $get_rating_by_user_name, $get_rating_by_user_image_path, $get_rating_by_user_image_file, $get_rating_by_user_image_thumb_60, $get_rating_by_user_ip, $get_rating_starts, $get_rating_created, $get_rating_created_saying, $get_rating_created_timestamp, $get_rating_updated, $get_rating_updated_saying, $get_rating_likes, $get_rating_dislikes, $get_rating_number_of_replies, $get_rating_read_blog_owner, $get_rating_reported, $get_rating_reported_by_user_id, $get_rating_reported_reason, $get_rating_reported_checked) = $row;

	if($count_ratings == "0"){
		echo"
		<a id=\"ratings\"></a>
		<hr />
		<h2>$l_ratings</h2>
		";
	}
	echo"
	<a id=\"rating$get_rating_id\"></a>
	<table>
	 <tr>
	  <td style=\"vertical-align: top;padding-right: 10px;text-align:center;\">
		<p>
		";
		if(file_exists("$root/$get_rating_by_user_image_path/$get_rating_by_user_image_thumb_60") && $get_rating_by_user_image_thumb_60 != ""){
			
			echo"
			<a href=\"users/view_profile.php?user_id=$get_rating_by_user_id&amp;l=$l\"><img src=\"$root/$get_rating_by_user_image_path/$get_rating_by_user_image_thumb_60\" alt=\"$get_rating_by_user_image_thumb_60\" /></a>
			<br />
			";
		}
		echo"
		
		</p>
	  </td>
	  <td style=\"vertical-align: top;\">
		<p>
		<a href=\"users/view_profile.php?user_id=$get_rating_by_user_id&amp;l=$l\" style=\"font-weight: bold;\">$get_rating_by_user_name</a> 
		$get_rating_created_saying<br />
		</p>

		<p>
		$get_rating_text
		</p>

		<!-- Like, dislike, report spam + owner actions -->
			<p>\n";
			if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
				$can_edit = 0;
				if($get_my_user_id == "$get_rating_by_user_id"){
					$can_edit = 1;
				}
				if($get_my_user_rank == "admin" OR $get_my_user_rank == "moderator"){
					$can_edit = 1;
				}

				if($can_edit == "1"){
					echo"
					<a href=\"rating_edit.php?rating_id=$get_rating_id&amp;l=$l\">$l_edit</a> &middot;
					<a href=\"rating_delete.php?rating_id=$get_rating_id&amp;l=$l\">$l_delete</a> &middot;
					";
				}

				echo"<a href=\"rating_report.php?rating_id=$get_rating_id&amp;l=$l\">$l_report</a>";
			}
			else{
				echo"<a href=\"users/login.php?l=$l&amp;referer=../food/rating_report.php?rating_id=$get_rating_id\">$l_report</a>\n";
			}
			echo"
			</p>
		<!-- //Like, dislike, reply, report spam + owner actions -->
	  </td>
	 </tr>
	</table>
	";


	$count_ratings++;
} // comments			
?>