<?php 
/**
*
* File: food/view_food_include_new_rating.php
* Version 1.0.0
* Date 10:28 15.11.2020
* Copyright (c) 2020 S. A. Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if(!(isset($get_current_food_id))){
	echo"error, food id not found";
	die;
}




// Logged in?
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	// Link
	if($process != "1"){
		echo"
		<a id=\"new_rating_form\"></a>
		";
	}
	

	// Get my user
	$my_user_id = $_SESSION['user_id'];
	$my_user_id = output_html($my_user_id);
	$my_user_id_mysql = quote_smart($link, $my_user_id);
	$query = "SELECT user_id, user_email, user_name, user_alias, user_rank FROM $t_users WHERE user_id=$my_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_my_user_id, $get_my_user_email, $get_my_user_name, $get_my_user_alias, $get_my_user_rank) = $row;

	$query = "SELECT photo_id, photo_destination, photo_thumb_60 FROM $t_users_profile_photo WHERE photo_user_id=$my_user_id_mysql AND photo_profile_image='1'";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_my_photo_id, $get_my_photo_destination, $get_my_photo_thumb_60) = $row;


	
	// Dates
	$time = time();
	$datetime = date("Y-m-d H:i:s");
	$date_saying = date("j M Y");
	$year = date("Y");
	$month = date("m");
	$month_full = date("F");
	$month_short = date("M");
	$week = date("W");

	// IP Check
	$my_ip = $_SERVER['REMOTE_ADDR'];
	$my_ip = output_html($my_ip);
	$my_ip_mysql = quote_smart($link, $my_ip);
	$q = "SELECT rating_id, rating_created_timestamp FROM $t_food_index_ratings WHERE rating_by_user_ip=$my_ip_mysql ORDER BY rating_id DESC LIMIT 0,1";
	$r = mysqli_query($link, $q);
	$rowb = mysqli_fetch_row($r);
	list($get_rating_id, $get_rating_created_timestamp) = $rowb;	
	
	$can_rate = 1;

	if($get_rating_id != ""){
		$time_since_written = $time-$get_rating_created_timestamp;
		$remaining = 60-$time_since_written;
		if($time_since_written < 60){ // 60 seconds
			$can_rate = 0;
			
		}
	}

	if($can_rate == 1){

		// Post rating
		if(isset($_GET['rating_action'])){

			$inp_text = $_POST['inp_text'];
			$inp_text = output_html($inp_text);
			$inp_text_mysql = quote_smart($link, $inp_text);

			$inp_my_user_name = output_html($get_my_user_name);
			$inp_my_user_name_mysql = quote_smart($link, $inp_my_user_name);

			$inp_my_image_path = output_html("_uploads/users/images/$get_my_user_id");
			$inp_my_image_path_mysql = quote_smart($link, $inp_my_image_path);

			$inp_my_image_file = output_html($get_my_photo_destination);
			$inp_my_image_file_mysql = quote_smart($link, $inp_my_image_file);

			$inp_my_image_thumb = output_html($get_my_photo_thumb_60);
			$inp_my_image_thumb_mysql = quote_smart($link, $inp_my_image_thumb);


			if($inp_text == ""){
				$url = "view_food.php?main_category_id=$get_current_main_category_id&sub_category_id=$get_current_sub_category_id&food_id=$get_current_food_id&l=$l&ft_rating=warning&fm_rating=missing_text#new_rating_form";
				header("Location: $url");
				exit;
			} // no text 
			else{

				
				// Insert comment
				mysqli_query($link, "INSERT INTO $t_food_index_ratings
				(rating_id, rating_food_id, rating_text, rating_by_user_id, 
				rating_by_user_name, rating_by_user_image_path, rating_by_user_image_file, rating_by_user_image_thumb_60, rating_by_user_ip, 
				rating_created, rating_created_saying, rating_created_timestamp, rating_updated, rating_updated_saying, 
				rating_read_blog_owner, rating_reported) 
				VALUES 
				(NULL, $get_current_food_id, $inp_text_mysql, $get_my_user_id, 
				$inp_my_user_name_mysql, $inp_my_image_path_mysql, $inp_my_image_file_mysql, $inp_my_image_thumb_mysql, $my_ip_mysql, 
				'$datetime', '$date_saying', '$time', '$datetime', '$date_saying',
				0, 0)")
				or die(mysqli_error($link));

				// Get ID
				$query = "SELECT rating_id FROM $t_food_index_ratings WHERE rating_created='$datetime'";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_current_rating_id) = $row;



				// Email to download owner
				if($configMailSendActiveSav == "1"){
					// Find admin
					$query = "SELECT user_id, user_email, user_name FROM $t_users WHERE user_rank='admin' LIMIT 0,1";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_admin_user_id, $get_admin_user_email, $get_admin_user_name) = $row;

					// Admin subscriptions
					$query = "SELECT es_id, es_user_id, es_type, es_on_off FROM $t_users_email_subscriptions WHERE es_user_id=$get_admin_user_id";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_admin_es_id, $get_admin_es_user_id, $get_admin_es_type, $get_admin_es_on_off) = $row;
					if($get_admin_es_on_off == "1"){


						// Send mail
						$host = $_SERVER['HTTP_HOST'];

						$subject = "$l_new_rating_for_food $get_current_food_manufacturer_name_and_food_name";
			
						$message = "<html>\n";
						$message = $message. "<head>\n";
						$message = $message. "  <title>$subject</title>\n";
						$message = $message. " </head>\n";
						$message = $message. "<body>\n";

						$message = $message . "<h1>$l_new_rating_for_food $get_current_food_manufacturer_name_and_food_name</h1>\n\n";
						$message = $message . "<table>\n";
						$message = $message . " <tr>\n";
						$message = $message . "  <td style=\"padding: 0px 6px 0px 0x;text-align:center;vertical-align:top;\">\n";
						$message = $message . "		<p>\n";
						if(file_exists("$root/_uploads/users/images/$get_my_user_id/$get_my_photo_destination") && $get_my_photo_destination != ""){
							$message = $message . "		<a href=\"$configSiteURLSav/users/view_profile.php?user_id=$get_my_user_id\"><img src=\"$configSiteURLSav/_uploads/users/images/$get_my_user_id/$get_my_photo_thumb_60\" alt=\"$get_my_photo_thumb_60\" /></a><br />\n";

						}
						$message = $message . "		<a href=\"$configSiteURLSav/users/view_profile.php?user_id=$get_my_user_id\">$get_my_user_name</a>\n";
						$message = $message . "		</p>\n\n";
						$message = $message . "  </td>\n";
						$message = $message . "  <td style=\"padding: 0px 6px 0px 0x;vertical-align:top;\">\n";
						$message = $message . "		<p>$inp_text</p>\n\n";
						$message = $message . "  </td>\n";
						$message = $message . " </tr>\n";
						$message = $message . "</table>\n\n";
						$message = $message . "<p><b>$l_actions:</b><br />\n";
						$message = $message . "1. <a href=\"$configSiteURLSav/food/view_food.php?main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;food_id=$get_current_food_id\">$l_view_food</a><br />\n";
						$message = $message . "2. <a href=\"$configSiteURLSav/food/view_food.php?main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;food_id=$get_current_food_id#rating$get_current_rating_id\">$l_view_rating</a><br />\n";
						$message = $message . "5. <a href=\"$configSiteURLSav/food/rating_report.php?rating_id=$get_current_rating_id\">$l_report</a><br />\n";
						$message = $message . "</p>\n\n";

			

						$message = $message . "<p>\n\n--<br />\nBest regards<br />\n$configWebsiteTitleSav<br />\n<a href=\"$configSiteURLSav\">$configSiteURLSav</a></p>";
						$message = $message . "<p><a href=\"$configSiteURLSav/users/edit_subscriptions.php\">$l_unsubscribe</a></p>";
						$message = $message. "</body>\n";
						$message = $message. "</html>\n";



						// Preferences for Subject field
						$headers = 'MIME-Version: 1.0\n';
						$headers = $headers . 'Content-type: text/html; charset=utf-8\n';
						$headers = $headers . "From: $configFromNameSav <" . $configFromEmailSav . ">";
						mail($get_admin_user_email, $subject, $message, $headers);
					} // admin wants mail
				} // $get_current_blog_new_comments_email_warning == 1

				// Stats :: Comments :: Year
				$query = "SELECT stats_comments_id, stats_comments_comments_written FROM $t_stats_comments_per_year WHERE stats_comments_year='$year'";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_stats_comments_id, $get_stats_comments_comments_written) = $row;
				if($get_stats_comments_id == ""){
					mysqli_query($link, "INSERT INTO $t_stats_comments_per_year 
					(stats_comments_id, stats_comments_year, stats_comments_comments_written) 
					VALUES 
					(NULL, $year, 1)")
					or die(mysqli_error($link));
				}
				else{
					$inp_counter = $get_stats_comments_comments_written+1;
					mysqli_query($link, "UPDATE $t_stats_comments_per_year 
								SET stats_comments_comments_written=$inp_counter
								WHERE stats_comments_id=$get_stats_comments_id")
								or die(mysqli_error($link));
				}

				// Stats :: Comments :: Month
				$query = "SELECT stats_comments_id, stats_comments_comments_written FROM $t_stats_comments_per_month WHERE stats_comments_month='$month' AND stats_comments_year='$year'";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_stats_comments_id, $get_stats_comments_comments_written) = $row;
				if($get_stats_comments_id == ""){
					mysqli_query($link, "INSERT INTO $t_stats_comments_per_month 
					(stats_comments_id, stats_comments_month, stats_comments_month_full, stats_comments_month_short, stats_comments_year, stats_comments_comments_written) 
					VALUES 
					(NULL, $month, '$month_full', '$month_short', $year, 1)")
					or die(mysqli_error($link));
				}
				else{
					$inp_counter = $get_stats_comments_comments_written+1;
					mysqli_query($link, "UPDATE $t_stats_comments_per_month 
								SET stats_comments_comments_written=$inp_counter
								WHERE stats_comments_id=$get_stats_comments_id")
								or die(mysqli_error($link));
				}

				// Stats :: Comments :: Week
				$query = "SELECT stats_comments_id, stats_comments_comments_written FROM $t_stats_comments_per_week WHERE stats_comments_week='$week' AND stats_comments_year='$year'";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_stats_comments_id, $get_stats_comments_comments_written) = $row;
				if($get_stats_comments_id == ""){
					mysqli_query($link, "INSERT INTO $t_stats_comments_per_week 
					(stats_comments_id, stats_comments_week, stats_comments_month, stats_comments_year, stats_comments_comments_written) 
					VALUES 
					(NULL, $week, $month, $year, 1)")
					or die(mysqli_error($link));
				}
				else{
					$inp_counter = $get_stats_comments_comments_written+1;
					mysqli_query($link, "UPDATE $t_stats_comments_per_week
								SET stats_comments_comments_written=$inp_counter
								WHERE stats_comments_id=$get_stats_comments_id")
								or die(mysqli_error($link));
				}

				// Refresh site
				$url = "view_food.php?main_category_id=$get_current_main_category_id&sub_category_id=$get_current_sub_category_id&food_id=$get_current_food_id&&l=$l&ft_rating=success&fm_rating=rating_saved#rating$get_current_rating_id";
				header("Location: $url");
				exit;
			} // text 
			

		} // action == post_rating
		echo"
		<!-- New rating form -->
			<hr />
			<h2>$l_rate_this_food</h2>
			<form method=\"post\" action=\"view_food.php?main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;food_id=$get_current_food_id&amp;rating_action=post_rating&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
		
			<table>
	 		 <tr>
			  <td style=\"vertical-align: top;padding-right: 10px;text-align:center;\">
				<p>
				";
				if(file_exists("$root/_uploads/users/images/$get_my_user_id/$get_my_photo_destination") && $get_my_photo_destination != ""){

					// Thumb
					if(!(file_exists("$root/_uploads/users/images/$get_my_user_id/$get_my_photo_thumb_60"))){
						resize_crop_image(60, 60, "$root/_uploads/users/images/$get_my_user_id/$get_my_photo_destination", "$root/_uploads/users/images/$get_my_user_id/$get_my_photo_thumb_60");
					}


					echo"
					<img src=\"$root/_uploads/users/images/$get_my_user_id/$get_my_photo_thumb_60\" alt=\"$get_my_photo_thumb_60\" />
					<br />
					";
				}
				echo"
				$get_my_user_name
				</p>
			  </td>
			  <td style=\"vertical-align: top;\">
				<p>
				<textarea name=\"inp_text\" rows=\"5\" cols=\"80\"></textarea><br />
				<input type=\"submit\" value=\"$l_save_rating\" class=\"btn_default\" />
				</p>
			  </td>
			 </tr>
			</table>

			</form>
		<!-- //New rating form -->
		";
	} // can rate
} // logged in
else{
	echo"
	<p>
	<a href=\"$root/users/login.php?l=$l&amp;referer=../food/view_food.php?main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;food_id=$food_id\" class=\"btn_default\">$l_login_to_post_comment</a>
	<a href=\"$root/users/create_free_account.php?l=$l\" class=\"btn_default\">$l_create_new_account</a>
	";
}
?>