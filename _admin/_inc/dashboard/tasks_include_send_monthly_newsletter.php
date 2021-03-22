<?php
/**
*
* File: _admin/_inc/tasks_include_send_monthly_newsletter.php
* Version 1.0.0
* Date 21:19 22.03.2021
* Copyright (c) 2021 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}


/*- Tables ---------------------------------------------------------------------------- */
$t_tasks_user_subscription_selections	= $mysqlPrefixSav . "tasks_user_subscription_selections";

/*- Variables  ---------------------------------------------------- */
$month = date("m");

$month_year_saying = date("M Y");
$time = time();
$datetime = date("Y-m-d H:i:s");

// Check when last time we sendt e-mail was
$query = "SELECT selection_id, selection_user_id, selection_user_email, selection_subscribe_to_new_tasks, selection_subscribe_to_monthly_newsletter, selection_unsubscribe_code, selection_last_sendt_monthly_newsletter_month, selection_last_sendt_datetime, selection_last_sendt_time FROM $t_tasks_user_subscription_selections WHERE selection_subscribe_to_monthly_newsletter=1 AND selection_last_sendt_monthly_newsletter_month!= $month LIMIT 0,1";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_selection_id, $get_selection_user_id, $get_selection_user_email, $get_selection_subscribe_to_new_tasks, $get_selection_subscribe_to_monthly_newsletter, $get_selection_unsubscribe_code, $get_selection_last_sendt_monthly_newsletter_month, $get_selection_last_sendt_datetime, $get_selection_last_sendt_time) = $row;

if($get_selection_id != ""){

	$subject = "Monthly task newsletter for $month_year_saying | $configWebsiteTitleSav";
	
	$message = "<html>\n";
	$message = $message. "<head>\n";
	$message = $message. "  <title>$subject</title>\n";

	$message = $message. "  <style type=\"text/css\">\n";
	$message = $message. "  table.hor-zebra {\n";
	$message = $message. "    width: 100%;\n";
	$message = $message. "    text-align: left;\n";
	$message = $message. "    border-spacing:0;\n";
	$message = $message. "    border: #cccccc 1px solid;\n";
	$message = $message. "  }\n";

	$message = $message. "  table.hor-zebra>thead {\n";
	$message = $message. "    border-top: #cccccc 1px solid;\n";
	$message = $message. "  }\n";

	$message = $message. "  table.hor-zebra>thead>tr>th {\n";
	$message = $message. "  	background: #e2e2e2;\n";
	$message = $message. "  	border-top: #ffffff 1px solid;\n";
	$message = $message. "  	border-bottom: #cccccc 1px solid;\n";
	$message = $message. "  	padding: 4px;\n";
	$message = $message. "  	color: #000;\n";
	$message = $message. "  }\n";

	$message = $message. "  table.hor-zebra>tbody>tr>td {\n";
	$message = $message. "  	background: #f3f3f3;\n";
	$message = $message. "  	border-bottom: #cccccc 1px solid;\n";
	$message = $message. "  	padding: 8px 4px 8px 4px;\n";
	$message = $message. "  }\n";

	$message = $message. "  table.hor-zebra>tbody>tr>td.odd {\n";
	$message = $message. "  	background: #f8f8f8;\n";
	$message = $message. "  	border-bottom: #cccccc 1px solid;\n";
	$message = $message. "  }\n";
	$message = $message. "  table.hor-zebra>tbody>tr>td.important {\n";
	$message = $message. "  	background: #fff7e5;\n";
	$message = $message. "  	border-bottom: #eabc63 1px solid;\n";
	$message = $message. "  }\n";
	$message = $message. "  table.hor-zebra>tbody>tr>td.danger {\n";
	$message = $message. "  	background: #ffe7e5;\n";
	$message = $message. "  	border-bottom: #ff4940 1px solid;\n";
	$message = $message. "  	border-top: #ff4940 1px solid;\n";
	$message = $message. "  }\n";

	$message = $message. "  table.hor-zebra>tbody>tr:hover td {\n";
	$message = $message. "  	background: #faf4f2;\n";
	$message = $message. "  }\n";


	$message = $message. "  div.task_content_info{\n";
	$message = $message. "  	float: right;\n";
	$message = $message. "  }\n";
	$message = $message. "  div.task_content_info > span{\n";
	$message = $message. "  	color: #d6685d;\n";
	$message = $message. "  	font-weight: bold;\n";
	$message = $message. "  }\n";


	$message = $message. "  </style>\n";

	$message = $message. " </head>\n";
	$message = $message. "<body>\n";
	$message = $message. "<p>This e-mail contains tasks that are assigned to you.</p>\n";
	$message = $message. "<table class=\"hor-zebra\">\n";
	$message = $message. " <thead>\n";
	$message = $message. "  <tr>\n";
	$message = $message. "   <th>\n";
	$message = $message. "		<span>ID</span>\n";
	$message = $message. "   </th>\n";
	$message = $message. "   <th>\n";
	$message = $message. "		<span>Title</span>\n";
	$message = $message. "   </th>\n";
	$message = $message. "  </tr>\n";
	$message = $message. " </thead>\n";
	$message = $message. " <tbody>\n";


	// Fetch tasks thats not done
	$count_tasks = 0;
	$query = "SELECT task_id, task_system_task_abbr, task_system_incremented_number, task_project_task_abbr, task_project_incremented_number, task_title, task_text, task_status_code_id, task_priority_id, task_priority_weight, task_created_datetime, task_created_by_user_id, task_created_by_user_alias, task_created_by_user_image, task_created_by_user_email, task_updated_datetime, task_due_datetime, task_due_time, task_due_translated, task_assigned_to_user_id, task_assigned_to_user_alias, task_assigned_to_user_image, task_assigned_to_user_thumb_40, task_assigned_to_user_email, task_qa_datetime, task_qa_by_user_id, task_qa_by_user_alias, task_qa_by_user_image, task_qa_by_user_email, task_finished_datetime, task_finished_by_user_id, task_finished_by_user_alias, task_finished_by_user_image, task_finished_by_user_email, task_is_archived, task_comments, task_project_id, task_project_part_id, task_system_id, task_system_part_id FROM $t_tasks_index ";
	$query = $query . "WHERE task_assigned_to_user_id=$get_selection_user_id AND task_is_archived='0' ORDER BY task_priority_id, task_id ASC";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_task_id, $get_task_system_task_abbr, $get_task_system_incremented_number, $get_task_project_task_abbr, $get_task_project_incremented_number, $get_task_title, $get_task_text, $get_task_status_code_id, $get_task_priority_id, $get_task_priority_weight, $get_task_created_datetime, $get_task_created_by_user_id, $get_task_created_by_user_alias, $get_task_created_by_user_image, $get_task_created_by_user_email, $get_task_updated_datetime, $get_task_due_datetime, $get_task_due_time, $get_task_due_translated, $get_task_assigned_to_user_id, $get_task_assigned_to_user_alias, $get_task_assigned_to_user_image, $get_task_assigned_to_user_thumb_40, $get_task_assigned_to_user_email, $get_task_qa_datetime, $get_task_qa_by_user_id, $get_task_qa_by_user_alias, $get_task_qa_by_user_image, $get_task_qa_by_user_email, $get_task_finished_datetime, $get_task_finished_by_user_id, $get_task_finished_by_user_alias, $get_task_finished_by_user_image, $get_task_finished_by_user_email, $get_task_is_archived, $get_task_comments, $get_task_project_id, $get_task_project_part_id, $get_task_system_id, $get_task_system_part_id) = $row;
			
		// Number
		$number = "";
		if($get_task_project_incremented_number == "0" OR $get_task_project_incremented_number == ""){
			if($get_task_system_incremented_number == "0" OR $get_task_system_incremented_number == ""){
				$number = "$get_task_id";
			}
			else{
				$number = "$get_task_system_task_abbr-$get_task_system_incremented_number";
			}
		}
		else{
			$number = "$get_task_project_task_abbr-$get_task_project_incremented_number";
		}
		$message = $message. " <tr>\n";
		$message = $message. "  <td"; 
		if($get_task_priority_weight == "1"){ 
			$message = $message. " class=\"danger\""; 
		} 
		elseif($get_task_priority_weight == "2"){ 
			$message = $message. " class=\"important\""; 
		} 
		$message = $message. ">\n";
		$message = $message. "		<span><a href=\"$configControlPanelURLSav/index.php?open=dashboard&amp;page=tasks&amp;action=open_task&amp;task_id=$get_task_id\">$number</a></span>\n";
		$message = $message. "  </td>\n";
		$message = $message. "  <td"; 
		if($get_task_priority_weight == "1"){ 
			$message = $message. " class=\"danger\""; 
		} 
		elseif($get_task_priority_weight == "2"){ 
			$message = $message. " class=\"important\""; 
		} 
		$message = $message. ">\n";
		$message = $message. "		<span><a href=\"$configControlPanelURLSav/index.php?open=dashboard&amp;page=tasks&amp;action=open_task&amp;task_id=$get_task_id\">$get_task_title</a></span>\n";
		
		if($time > $get_task_due_time){
			$message = $message . "<div class=\"task_content_info\">
				<span>$get_task_due_translated</span>
			</div>\n";
		}
		$message = $message. "  </td>\n";
		$message = $message. " </tr>\n";
		

		$count_tasks++;
	} // while tasks
	$message = $message. " </tbody>\n";
	$message = $message. "</table>\n";
	$message = $message. "<hr />";
	$message = $message. "<p>No longer want montly updates? Then you can ";
	$message = $message. "<a href=\"$configControlPanelURLSav/_inc/dashboard/tasks_subscriptions.php?user_id=$get_selection_user_id&amp;unsubscribe_code=$get_selection_unsubscribe_code\">unsubscribe</a>.\n";
	$message = $message. "</p>";
	$message = $message. "";
	$message = $message. "<p>Regards,<br />";
	$message = $message. "$configWebsiteWebmasterSav<br />\n";
	$message = $message. "$configWebsiteWebmasterEmailSav<br />\n";
	$message = $message. "<a href=\"$configSiteURLSav\">$configSiteURLSav</a>\n";
	$message = $message. "</p>";


	
	$message = $message. "</body>\n";
	$message = $message. "</html>\n";

	$headers = "MIME-Version: 1.0" . "\r\n" .
  		  "Content-type: text/html; charset=iso-8859-1" . "\r\n" .
		    "To: $get_selection_user_email " . "\r\n" .
		    "From: $configFromEmailSav" . "\r\n" .
		    "Reply-To: $configFromEmailSav" . "\r\n" .
		    'X-Mailer: PHP/' . phpversion();

	if($configMailSendActiveSav == "1" && $count_tasks != "0"){
		mail($get_selection_user_email, $subject, $message, $headers);
	
		echo"
		<div class=\"info\"><p>Sending monthly newsletter to $get_selection_user_email:</p>
			<p><b>Subject:</b>  $subject<br />
			<b>Message:</b></p> $message </div>
		";

	}
	
	// Update
	mysqli_query($link, "UPDATE $t_tasks_user_subscription_selections SET
					selection_last_sendt_monthly_newsletter_month=$month,
					selection_last_sendt_datetime='$datetime',
					selection_last_sendt_time='$time'
					WHERE selection_id=$get_selection_id")
					or die(mysqli_error($link));

} // no last found
?>