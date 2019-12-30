<?php
/*- Functions ------------------------------------------------------------------------- */
include("../../_admin/_functions/output_html.php");
include("../../_admin/_functions/clean.php");
include("../../_admin/_functions/quote_smart.php");


/*- Config ----------------------------------------------------------------------------- */
include("../../_admin/_data/config/meta.php");
include("../../_admin/_data/config/user_system.php");
include("../../_admin/_data/logo.php");

/*- MySQL ----------------------------------------------------------------------------- */
$server_name = $_SERVER['HTTP_HOST'];
$server_name = clean($server_name);

$mysql_config_file = "../../_admin/_data/mysql_" . $server_name . ".php";
include("$mysql_config_file");
$link = mysqli_connect($mysqlHostSav, $mysqlUserNameSav, $mysqlPasswordSav, $mysqlDatabaseNameSav);
if (!$link) {
	echo "Error MySQL link";
	die;
}


/*- MySQL Tables ---------------------------------------------------------------------- */
$t_users 	 		= $mysqlPrefixSav . "users";
$t_users_profile_photo		= $mysqlPrefixSav . "users_profile_photo";
$t_users_email_subscriptions 	= $mysqlPrefixSav . "users_email_subscriptions";
$t_users_moderator_of_the_week	= $mysqlPrefixSav . "users_moderator_of_the_week";
$t_comments			= $mysqlPrefixSav . "comments";
$t_comments_users_block		= $mysqlPrefixSav . "comments_users_block";

$t_stats_comments_weekly  = $mysqlPrefixSav . "stats_comments_weekly";
$t_stats_comments_monthly = $mysqlPrefixSav . "stats_comments_monthly";
$t_stats_comments_yearly  = $mysqlPrefixSav . "stats_comments_yearly";


/*- Find user ------------------------------------------------------------------------- */
if(isset($_POST['inp_user_id'])){
	$inp_user_id = $_POST['inp_user_id'];
	$inp_user_id = output_html($inp_user_id);
	$inp_user_id_mysql = quote_smart($link, $inp_user_id);
}
else{
	echo"Missing user id";
	die;
}
if(isset($_POST['inp_user_password'])){
	$inp_user_password = $_POST['inp_user_password']; // Already encrypted
}
else{
	echo"Missing user password";
	die;
}

// Check for user
$query = "SELECT user_id, user_password, user_email, user_alias, user_date_format FROM $t_users WHERE user_id=$inp_user_id_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_user_id, $get_user_password, $get_my_user_email, $get_my_user_alias, $get_my_user_date_format) = $row;






if($get_user_id == ""){
	echo"User id";
	die;
}
if($get_user_password != "$inp_user_password"){
	echo"Wrong user password.$get_user_password != $inp_user_password";
	die;
}	

// Get my profile image
$q = "SELECT photo_id, photo_destination FROM $t_users_profile_photo WHERE photo_user_id=$inp_user_id_mysql AND photo_profile_image='1'";
$r = mysqli_query($link, $q);
$rowb = mysqli_fetch_row($r);
list($get_my_photo_id, $get_my_photo_destination) = $rowb;


// Get my subscription status
$q = "SELECT es_id, es_on_off FROM $t_users_email_subscriptions WHERE es_user_id=$inp_user_id_mysql AND es_type='comments'";
$r = mysqli_query($link, $q);
$rowb = mysqli_fetch_row($r);
list($get_my_es_id, $get_my_es_on_off) = $rowb;

if($get_my_es_id == ""){
	mysqli_query($link, "INSERT INTO $t_users_email_subscriptions
	(es_id, es_user_id, es_type, es_on_off) 
	VALUES 
	(NULL, $inp_user_id_mysql, 'comments', '1')") or die(mysqli_error($link));
	
	$get_my_es_on_off = "1";
}





/*- Object -------------------------------------------------------------------------------- */

if(isset($_POST['inp_object'])) {
	$inp_object = $_POST['inp_object'];
	$inp_object = strip_tags(stripslashes($inp_object));
	$inp_object_mysql = quote_smart($link, $inp_object);
}
else{
	echo"Missing inp object";
	die;
}
if(isset($_POST['inp_object_id'])) {
	$inp_object_id = $_POST['inp_object_id'];
	$inp_object_id = strip_tags(stripslashes($inp_object_id));
	$inp_object_id_mysql = quote_smart($link, $inp_object_id);
}
else{
	echo"Missing inp object id";
	die;
}
if(isset($_POST['inp_referer'])) {
	$inp_referer = $_POST['inp_referer'];
	$inp_referer = strip_tags(stripslashes($inp_referer));
}
else{
	echo"Missing inp referer";
	die;
}



/*- Comment text --------------------------------------------------------------------------- */
$inp_comment_text = $_POST['inp_comment_text'];
$inp_comment_text = output_html($inp_comment_text);
$inp_comment_text_mysql = quote_smart($link, $inp_comment_text);
if(empty($inp_comment_text)){
	echo"Missing comment";
	die;
}


$inp_comment_language = output_html($get_recipe_language);
$inp_comment_language_mysql = quote_smart($link, $inp_comment_language);

if(isset($_GET['comment_parent_id'])){
	$inp_comment_parent_id = $_POST['comment_parent_id'];
}
else{
	$inp_comment_parent_id = "0";
}
$inp_comment_parent_id = output_html($inp_comment_parent_id);
$inp_comment_parent_id_mysql = quote_smart($link, $inp_comment_parent_id);


$inp_user_ip = $_SERVER['REMOTE_ADDR'];
$inp_user_ip = output_html($inp_user_ip);
$inp_user_ip_mysql = quote_smart($link, $inp_user_ip);

$inp_comment_user_name_mysql = quote_smart($link, $get_my_user_alias);

$inp_comment_user_avatar_mysql = quote_smart($link, $get_my_photo_destination);

$inp_comment_user_email_mysql = quote_smart($link, $get_my_user_email);

$inp_comment_user_subscribe_mysql = quote_smart($link, $get_my_es_on_off);

$inp_comment_created = date("Y-m-d H:i:s");
$inp_comment_updated = date("Y-m-d H:i:s");




/*- IP Block --------------------------------------------------------------------------- */

$my_user_ip = $_SERVER['REMOTE_ADDR'];
$my_user_ip = output_html($my_user_ip);
$my_user_ip_mysql = quote_smart($link, $my_user_ip);

$block_to = date("ymdh");

// Check by user ID
$query = "SELECT block_id FROM $t_comments_users_block WHERE block_user_id=$inp_user_id_mysql AND block_object=$inp_object_mysql AND block_object_id=$inp_object_id_mysql AND block_to=$block_to";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_block_id) = $row;
if($get_block_id != ""){
	echo"Please wait one hour before commenting again";
	die;
}
else{
	// Check by user IP
	$query = "SELECT block_id FROM $t_comments_users_block WHERE block_user_ip=$inp_user_id_mysql AND block_object=$inp_object_mysql AND block_object_id=$inp_object_id_mysql AND block_to=$block_to";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_block_id) = $row;
	if($get_block_id != ""){
		echo"Please wait one hour before commenting again";
		die;
	}
	else{
		mysqli_query($link, "INSERT INTO $t_comments_users_block
		(block_id, block_user_id, block_user_ip, block_object, block_object_id, block_to) 
		VALUES 
		(NULL, $inp_user_id_mysql, $my_user_ip_mysql, $inp_object_mysql, $inp_object_id_mysql, '$block_to')")
		or die(mysqli_error($link));
	}
}


/*- Insert comment ------------------------------------------------------------------ */
mysqli_query($link, "INSERT INTO $t_comments
(comment_id, comment_user_id, comment_language, 
comment_object, comment_object_id, comment_parent_id, 
comment_user_ip, comment_user_name, comment_user_avatar, 
comment_user_email, comment_user_subscribe, comment_created, 
comment_updated, comment_text, comment_likes, comment_dislikes, comment_reported, comment_approved) 
VALUES 
(NULL, $inp_user_id_mysql, $inp_comment_language_mysql, 
$inp_object_mysql, $inp_object_id_mysql, $inp_comment_parent_id_mysql, 
$inp_user_ip_mysql, $inp_comment_user_name_mysql, $inp_comment_user_avatar_mysql, 
$inp_comment_user_email_mysql, $inp_comment_user_subscribe_mysql, '$inp_comment_created', 
'$inp_comment_updated', $inp_comment_text_mysql, '0', '0', '0', '1')")
or die(mysqli_error($link));


// Get comment ID
$query = "SELECT comment_id FROM $t_comments WHERE comment_user_id=$inp_user_id_mysql AND comment_created='$inp_comment_created'";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_comment_id) = $row;


echo"Comment saved";




/*- Email to moderator ---------------------------------------------------------------- */

$inp_message_title = "New comment";
$inp_message_title_mysql = quote_smart($link, $inp_message_title);

$inp_message_text = "<table>
				 <tr>
				  <td style=\"padding-right: 10px;text-align:center;vertical-align: top;\">
					<p style=\"color: #000;font: normal 14px 'Open Sans',sans-serif;\">
					<img src=\"$commenter_image\" alt=\"commenter_image.png\" /><br />
					<a href=\"$configSiteURLSav/users/index.php?page=view_profile&user_id=$get_my_user_id&l=$get_object_owner_user_language\" style=\"color: #000;font: normal 14px 'Open Sans',sans-serif;text-decoration: none;\">$get_my_user_alias</a>
					</p>
				  </td>
				  <td style=\"vertical-align: top;\">
					<p style=\"color: #000;font: normal 14px 'Open Sans',sans-serif;\">
					$inp_comment_text
					</p>

					<p style=\"color: #000;font: normal 14px 'Open Sans',sans-serif;\">
					<a href=\"$view_link\" style=\"font: normal 14px 'Open Sans',sans-serif;\">View</a>
					&middot;
					<a href=\"$configSiteURLSav/comments/reply_comment.php?comment_id=$get_comment_id&l=$get_object_owner_user_language\" style=\"font: normal 14px 'Open Sans',sans-serif;\">Reply</a>
					&middot;
					<a href=\"$report_link\" style=\"font: normal 14px 'Open Sans',sans-serif;\">Report</a>
					</p>
				  </td>
				 </tr>
				</table>";
$inp_message_text_mysql = quote_smart($link, $inp_message_text);

$datetime = date("Y-m-d H:i:s");

$year = date("Y");
$month = date("m");
$day = date("d");
$date_saying = date("j m Y");

mysqli_query($link, "INSERT INTO $t_admin_messages_inbox
(message_id, message_title, message_text, 
message_language, message_datetime, message_year, 
message_month, message_day, message_date_sayning, 
message_sent_email_warning, message_replied, message_from_user_id, 
message_from_name, message_from_ip, message_read, 
message_read_by_user_id, message_read_by_user_name, message_comment) 
VALUES 
(NULL, $inp_message_title_mysql, $inp_message_text_mysql,
$inp_comment_language_mysql, '$datetime', '$year',
'$month', '$day', '$date_saying',
'0', '0', $inp_user_ip_mysql, 
$inp_comment_user_name_mysql, $inp_user_ip_mysql, '0',
'0', '', '')")
or die(mysqli_error($link));






			// Statistics
			// --> weekly
			$day = date("d");
			$month = date("m");
			$week = date("W");
			$year = date("Y");

			$query = "SELECT weekly_id, weekly_comments_written FROM $t_stats_comments_weekly WHERE weekly_week=$week AND weekly_year=$year";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_weekly_id,  $get_weekly_comments_written) = $row;
			if($get_weekly_id == ""){
				mysqli_query($link, "INSERT INTO $t_stats_comments_weekly 
				(weekly_id, weekly_week, weekly_year, weekly_comments_written, weekly_comments_written_diff_from_last_week, weekly_last_updated, weekly_last_updated_day, weekly_last_updated_month, weekly_last_updated_year) 
				VALUES 
				(NULL, $week, $year, 1, 1, '$datetime', $day, $month, $year)")
				or die(mysqli_error($link));
			}
			else{
				$inp_counter = $get_weekly_comments_written+1;
				$result = mysqli_query($link, "UPDATE $t_stats_comments_weekly SET weekly_comments_written=$inp_counter, 
						weekly_last_updated='$datetime', weekly_last_updated_day=$day, weekly_last_updated_month=$month, weekly_last_updated_year=$year WHERE weekly_id=$get_weekly_id") or die(mysqli_error($link));
			}

			// --> monthly
			$query = "SELECT monthly_id, monthly_comments_written FROM $t_stats_comments_monthly WHERE monthly_month=$month AND monthly_year=$year";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_monthly_id,  $get_monthly_comments_written) = $row;
			if($get_monthly_id == ""){
				mysqli_query($link, "INSERT INTO $t_stats_comments_monthly 
				(monthly_id, monthly_month, monthly_year, monthly_comments_written, monthly_last_updated, monthly_last_updated_day, monthly_last_updated_month, monthly_last_updated_year ) 
				VALUES 
				(NULL, $month, $year, 1, '$datetime', $day, $month, $year)")
				or die(mysqli_error($link));
			}
			else{
				$inp_counter = $get_monthly_comments_written+1;
				$result = mysqli_query($link, "UPDATE $t_stats_comments_monthly SET monthly_comments_written=$inp_counter, 
						monthly_last_updated='$datetime', monthly_last_updated_day=$day, monthly_last_updated_month=$month, monthly_last_updated_year=$year WHERE monthly_id=$get_monthly_id") or die(mysqli_error($link));
			}

			// --> yearly
			$query = "SELECT yearly_id, yearly_comments_written FROM $t_stats_comments_yearly WHERE yearly_year=$year";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_yearly_id, $get_yearly_comments_written) = $row;
			if($get_yearly_id == ""){
				mysqli_query($link, "INSERT INTO $t_stats_comments_yearly 
				(yearly_id, yearly_year, yearly_comments_written, yearly_last_updated, yearly_last_updated_day, yearly_last_updated_month, yearly_last_updated_year) 
				VALUES 
				(NULL, $year, 1, '$datetime', $day, $month, $year)")
				or die(mysqli_error($link));
			}
			else{
				$inp_counter = $get_yearly_comments_written+1;
				$result = mysqli_query($link, "UPDATE $t_stats_comments_yearly SET yearly_comments_written=$inp_counter, 
						yearly_last_updated='$datetime', yearly_last_updated_day=$day, yearly_last_updated_month=$month, yearly_last_updated_year=$year WHERE yearly_id=$get_yearly_id") or die(mysqli_error($link));
			}

?>