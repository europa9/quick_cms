<?php

/*- Config ----------------------------------------------------------------------------- */
if(file_exists("$root/_admin/_data/config/comments_settings.php")){
	include("$root/_admin/_data/config/comments_settings.php");
}


/*- Translation ------------------------------------------------------------------------ */
include("$root/_admin/_translations/site/$l/comment/ts_view_comments.php");

echo"
<div class=\"clear\"></div>
<a id=\"comments\"></a>
<h2>$l_comments</h2>

<p>
<a href=\"$root/comments/new_comment.php?object=$object&amp;object_id=$object_id&amp;object_user_id=$object_user_id&amp;refererer_from_root=$refererer_from_root&amp;l=$l\" class=\"btn_default\">$l_add_comment</a>
</p>
";


// Am I logged in?
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


$object_mysql = quote_smart($link, $object);
$object_id_mysql = quote_smart($link, $object_id);

$number_of_comments = 0;
$query_groups = "SELECT comment_id, comment_user_id, comment_language, comment_object, comment_object_id, comment_parent_id, comment_user_ip, comment_user_name, comment_user_avatar, comment_user_email, comment_user_subscribe, comment_created, comment_updated, comment_text, comment_likes, comment_dislikes, comment_reported, comment_report_checked, comment_approved FROM $t_comments WHERE comment_object=$object_mysql AND comment_object_id=$object_id_mysql AND comment_parent_id='0' AND comment_approved='1'";
if(isset($order_comments_by) && isset($order_comments_method)){
	$query_groups = $query_groups . " ORDER BY $order_comments_by $order_comments_method";
}
else{
	$query_groups = $query_groups . " ORDER BY comment_likes ASC";
}
$result_groups = mysqli_query($link, $query_groups);
while($row_groups = mysqli_fetch_row($result_groups)) {
	list($get_comment_id, $get_comment_user_id, $get_comment_language, $get_comment_object, $get_comment_object_id, $get_comment_parent_id, $get_comment_user_ip, $get_comment_user_name, $get_comment_user_avatar, $get_comment_user_email, $get_comment_user_subscribe, $get_comment_created, $get_comment_updated, $get_comment_text, $get_comment_likes, $get_comment_dislikes, $get_comment_reported, $get_comment_report_checked, $get_comment_approved) = $row_groups;
		
	// Date
	$date_day = substr($get_comment_updated, 8, 2);
	$date_month = substr($get_comment_updated, 5, 2);
	$date_year = substr($get_comment_updated, 0, 4);

	if($date_day < 10){
		$date_day = substr($date_day, 1, 1);
	}
	if($date_month == "01"){
		$date_month_saying = "$l_jan";
	}
	elseif($date_month == "02"){
		$date_month_saying = "$l_feb";
	}
	elseif($date_month == "03"){
		$date_month_saying = "$l_mar";
	}
	elseif($date_month == "04"){
		$date_month_saying = "$l_apr";
	}
	elseif($date_month == "05"){
		$date_month_saying = "$l_may";
	}
	elseif($date_month == "06"){
		$date_month_saying = "$l_jun";
	}
	elseif($date_month == "07"){
		$date_month_saying = "$l_jul";
	}
	elseif($date_month == "08"){
		$date_month_saying = "$l_aug";
	}
	elseif($date_month == "09"){
		$date_month_saying = "$l_sep";
	}
	elseif($date_month == "10"){
		$date_month_saying = "$l_oct";
	}
	elseif($date_month == "11"){
		$date_month_saying = "$l_nov";
	}
	else{
		$date_month_saying = "$l_dec";
	}
			

	echo"
	<a id=\"comment$get_comment_id\"></a>
	<div class=\"clear\" style=\"height:14px;\"></div>
	
	<div class=\"comment_item\">
		<table style=\"width: 100%;\">
		 <tr>
		  <td style=\"vertical-align: top;width: 80px;\">
			<p style=\"padding: 10px 0px 10px 0px;margin:0;\">
			<a href=\"$root/users/view_profile.php?user_id=$get_comment_user_id&amp;l=$l\">";
			if($get_comment_user_avatar == "" OR !(file_exists("$root/_uploads/users/images/$get_comment_user_id/$get_comment_user_avatar"))){ 
				echo"<img src=\"$root/comments/_gfx/avatar_blank_65.png\" alt=\"avatar_blank_65.png\" class=\"comment_avatar\" />";
			} 
			else{ 
				$inp_new_x = 65; // 950
				$inp_new_y = 65; // 640
				$thumb_full_path = "$root/_cache/user_" . $get_comment_user_id . "-" . $inp_new_x . "x" . $inp_new_y . ".png";
				if(!(file_exists("$thumb_full_path"))){
					resize_crop_image($inp_new_x, $inp_new_y, "$root/_uploads/users/images/$get_comment_user_id/$get_comment_user_avatar", "$thumb_full_path");
				}

				echo"	<img src=\"$thumb_full_path\" alt=\"$get_comment_user_avatar.png\" class=\"comment_view_avatar\" />"; 
			} 
			echo"</a>
			</p>
	
		  </td>
		  <td style=\"vertical-align: top;\">
			<!-- Comment header -->
				<table style=\"width: 100%;\">
				 <tr>
				  <td style=\"vertical-align: top;\">
					<p class=\"comment_view_author\">
					<a href=\"$root/users/view_profile.php?user_id=$get_comment_user_id&amp;l=$l\" class=\"comment_view_author\">$get_comment_user_name</a>
					</p>

					<p>
					<a href=\"#comment$get_comment_id\" class=\"comment_view_date\">$date_day $date_month_saying $date_year</a></span>
					</p>
				  </td>
				  <td style=\"vertical-align: top;text-align: right;\">

					<!-- Menu -->
					<p>
					";
					if(isset($my_user_id)){
						if($get_comment_user_id == "$my_user_id" OR $get_my_user_rank == "admin" OR $get_my_user_rank == "moderator"){
							echo"
							<a href=\"$root/comments/edit_comment.php?comment_id=$get_comment_id&amp;l=$l\"><img src=\"$root/users/_gfx/edit.png\" alt=\"edit.png\" title=\"$l_edit\" /></a>
							<a href=\"$root/comments/delete_comment.php?comment_id=$get_comment_id&amp;l=$l\"><img src=\"$root/users/_gfx/delete.png\" alt=\"delete.png\" title=\"$l_delete\" /></a>
							";
						}
						else{
							echo"
							<a href=\"$root/comments/report_comment.php?comment_id=$get_comment_id&amp;l=$l\"><img src=\"$root/comments/_gfx/report_grey.png\" alt=\"report_grey.png\" title=\"$l_report\" /></a>
							";
						}
					}
					echo"
					</p>
					<!-- //Menu -->
				  </td>
				 </tr>
				</table>
			<!-- //Comment header -->
			
			<p style=\"margin-top: 0px;padding-top: 0;\">$get_comment_text</p>
		  </td>
		 </tr>
		</table>
	</div>
	";
	$number_of_comments = $number_of_comments+1;
} // comments

if($number_of_comments == "0"){
	echo"
	<p>
	$l_no_comments_yet
	$l_you_can_be_the_first_one_to_comment
	$l_just_write_your_comment_in_the_form_and_click_on_the_submit_button
	</p>
	";
}
?>