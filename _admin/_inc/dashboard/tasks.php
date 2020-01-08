<?php
/**
*
* File: _admin/_inc/tasks.php
* Version 1.0.1
* Date 12:54 28.04.2019
* Copyright (c) 2008-2019 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}


/*- Tables ---------------------------------------------------------------------------- */
$t_tasks_index  			= $mysqlPrefixSav . "tasks_index";
$t_tasks_subscriptions			= $mysqlPrefixSav . "tasks_subscriptions";
$t_tasks_status_codes  			= $mysqlPrefixSav . "tasks_status_codes";
$t_tasks_projects  			= $mysqlPrefixSav . "tasks_projects";
$t_tasks_projects_parts  		= $mysqlPrefixSav . "tasks_projects_parts";
$t_tasks_systems  			= $mysqlPrefixSav . "tasks_systems";
$t_tasks_systems_parts  		= $mysqlPrefixSav . "tasks_systems_parts";
$t_tasks_read				= $mysqlPrefixSav . "tasks_read";
$t_tasks_subscriptions_to_new_tasks 	= $mysqlPrefixSav . "tasks_subscriptions_to_new_tasks";

/*- Variables -------------------------------------------------------------------------- */

if(isset($_GET['task_id'])) {
	$task_id = $_GET['task_id'];
	$task_id = strip_tags(stripslashes($task_id));
}
else{
	$task_id = "";
}


if($action == ""){
	if(isset($_GET['status_code_id'])) {
		$status_code_id = $_GET['status_code_id'];
		$status_code_id = strip_tags(stripslashes($status_code_id));
	}
	else{
		$status_code_id = "";
	}
	if(isset($_GET['show_archive'])) {
		$show_archive = $_GET['show_archive'];
		$show_archive = strip_tags(stripslashes($show_archive));
	}
	else{
		$show_archive = "";
	}
	if(isset($_GET['assigned_to_user_id'])) {
		$assigned_to_user_id = $_GET['assigned_to_user_id'];
			$assigned_to_user_id = strip_tags(stripslashes($assigned_to_user_id));
	}
	else{
		$assigned_to_user_id = "";
	}
	echo"
	<h1>Tasks</h1>

	<!-- Menu -->
		<p>
		<a href=\"index.php?open=$open&amp;page=$page&amp;action=new_task&amp;l=$l\" class=\"btn_default\">New task</a>
		<a href=\"index.php?open=$open&amp;page=tasks_projects&amp;l=$l\" class=\"btn_default\">Projects</a>
		<a href=\"index.php?open=$open&amp;page=tasks_systems&amp;l=$l\" class=\"btn_default\">Systems</a>
		<a href=\"index.php?open=dashboard&amp;page=tasks&status_code_id=$status_code_id&amp;assigned_to_user_id=$assigned_to_user_id&amp;show_archive="; if($show_archive == "1"){ echo"0"; } else{ echo"1"; } echo"&amp;l=$l&amp;editor_language=$editor_language\""; if($show_archive == "1"){ echo" style=\"font-weight: bold;\""; } echo" class=\"btn_default\">"; if($show_archive == "1"){ echo"Hide"; } else{ echo"Show"; } echo" archive</a>
		<a href=\"index.php?open=dashboard&amp;page=tasks_subscriptions&amp;l=$l&amp;editor_language=$editor_language\" class=\"btn_default\">Subscriptions</a>
		</p>
	<!-- Menu -->

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

	<!-- Task tabs -->
		<div class=\"clear\" style=\"height: 10px;\"></div>
		<div class=\"tabs\">
			<ul>";

			$query = "SELECT status_code_id, status_code_title, status_code_color, status_code_count_tasks FROM $t_tasks_status_codes ORDER BY status_code_weight ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_status_code_id, $get_status_code_title, $get_status_code_color, $get_status_code_count_tasks) = $row;
				if($status_code_id == ""){ $status_code_id = $get_status_code_id; }
				echo"				";
				echo"<li><a href=\"index.php?open=$open&amp;page=$page&amp;status_code_id=$get_status_code_id&amp;show_archive=$show_archive&amp;l=$l\""; if($status_code_id == "$get_status_code_id"){ echo" class=\"active\""; } echo">$get_status_code_title ($get_status_code_count_tasks)</a></li>\n";
			}
			echo"
			</ul>
		</div>
		<div class=\"clear\" style=\"height: 20px;\"></div>
		
	<!-- //Task tabs -->

	<!-- Tasks -->
		
		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\">
			<span><b>Task</b></span>
		   </td>
		   <th scope=\"col\">
			<span><b>Assigned to</b></span>
		   </td>
		   <th scope=\"col\">
			<span><b>Priority</b></span>
		   </td>
		   <th scope=\"col\">
			<span><b>Due</b></span>
		   </td>
		  </tr>
		 </thead>
		";

		// Me
		$my_user_id = $_SESSION['user_id'];
		$my_user_id = output_html($my_user_id);
		$my_user_id_mysql = quote_smart($link, $my_user_id);
		

		$status_code_id_mysql = quote_smart($link, $status_code_id);
		$x = 0;
		$query = "SELECT task_id, task_title, task_text, task_status_code_id, task_priority_id, task_created_datetime, task_created_by_user_id, task_created_by_user_alias, task_created_by_user_image, task_created_by_user_email, task_updated_datetime, task_due_datetime, task_due_time, task_due_translated, task_assigned_to_user_id, task_assigned_to_user_alias, task_assigned_to_user_image, task_assigned_to_user_email, task_qa_datetime, task_qa_by_user_id, task_qa_by_user_alias, task_qa_by_user_image, task_qa_by_user_email, task_finished_datetime, task_finished_by_user_id, task_finished_by_user_alias, task_finished_by_user_image, task_finished_by_user_email, task_is_archived, task_comments, task_project_id, task_project_part_id, task_system_id, task_system_part_id FROM $t_tasks_index ";
		$query = $query . "WHERE task_status_code_id=$status_code_id_mysql";
		if($assigned_to_user_id != "" && is_numeric($assigned_to_user_id)){
			$assigned_to_user_id_mysql = quote_smart($link, $assigned_to_user_id);
			$query = $query . " AND task_assigned_to_user_id=$assigned_to_user_id_mysql";
		}
		if($show_archive == "1"){
			$query = $query . " AND task_is_archived='1'";
		}
		else{
			$query = $query . " AND task_is_archived='0'";
		}

		$query = $query . " ORDER BY task_priority_id, task_id ASC";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_task_id, $get_task_title, $get_task_text, $get_task_status_code_id, $get_task_priority_id, $get_task_created_datetime, $get_task_created_by_user_id, $get_task_created_by_user_alias, $get_task_created_by_user_image, $get_task_created_by_user_email, $get_task_updated_datetime, $get_task_due_datetime, $get_task_due_time, $get_task_due_translated, $get_task_assigned_to_user_id, $get_task_assigned_to_user_alias, $get_task_assigned_to_user_image, $get_task_assigned_to_user_email, $get_task_qa_datetime, $get_task_qa_by_user_id, $get_task_qa_by_user_alias, $get_task_qa_by_user_image, $get_task_qa_by_user_email, $get_task_finished_datetime, $get_task_finished_by_user_id, $get_task_finished_by_user_alias, $get_task_finished_by_user_image, $get_task_finished_by_user_email, $get_task_is_archived, $get_task_comments, $get_task_project_id, $get_task_project_part_id, $get_task_system_id, $get_task_system_part_id) = $row;
			
			// Style
			if(isset($style) && $style == ""){
				$style = "odd";
			}
			else{
				$style = "";
			}
			if($get_task_priority_id == "1"){
				$style = "danger";
			}
			elseif($get_task_priority_id == "2"){
				$style = "important";
			}

			// Read?
			$query_r = "SELECT read_id FROM $t_tasks_read WHERE read_task_id=$get_task_id AND read_user_id=$my_user_id_mysql";
			$result_r = mysqli_query($link, $query_r);
			$row_r = mysqli_fetch_row($result_r);
			list($get_read_id) = $row_r;			
		
			echo"
			 <tr>
			  <td class=\"$style\">
				<a id=\"#task$get_task_id\"></a>
				<span>
				<a href=\"index.php?open=$open&amp;page=$page&amp;action=open_task&amp;task_id=$get_task_id&amp;l=$l&amp;editor_language=$editor_language\""; if($get_read_id == ""){ echo" style=\"font-weight: bold;\""; } echo">$get_task_title</a>
				</span>
			  </td>
			  <td class=\"$style\">
				<span>
				<a href=\"index.php?open=$open&amp;page=$page&amp;task_id=$get_task_id&amp;status_code_id=$get_task_status_code_id&amp;assigned_to_user_id=$get_task_assigned_to_user_id&amp;show_archive=$show_archive&amp;l=$l&amp;editor_language=$editor_language\">$get_task_assigned_to_user_alias</a>
				</span>
			  </td>
			  <td class=\"$style\">
				<span>";
				if($get_task_priority_id == "1"){
					echo"Immediate Priority";
				}
				elseif($get_task_priority_id == "2"){
					echo"High Priority";
				}
				elseif($get_task_priority_id == "3"){
					echo"Normal Priority";
				}
				elseif($get_task_priority_id == "4"){
					echo"Low Priority";
				}
				elseif($get_task_priority_id == "5"){
					echo"Non-attendance";
				}
				echo"
				</span>
			  </td>
			  <td class=\"$style\">
				<span>
				$get_task_due_translated
				</span>
			  </td>
			 </tr>";

			$x++;
		}
		
		// Check that counter for status is correct		
		if($show_archive != "1"){

			$query_r = "SELECT status_code_id, status_code_count_tasks FROM $t_tasks_status_codes WHERE status_code_id=$status_code_id_mysql ";
			$result_r = mysqli_query($link, $query_r);
			$row_r = mysqli_fetch_row($result_r);
			list($get_status_code_id, $get_status_code_count_tasks) = $row_r;	

			if($x != $get_status_code_count_tasks){
				$result = mysqli_query($link, "UPDATE $t_tasks_status_codes SET status_code_count_tasks=$x WHERE status_code_id=$get_status_code_id");


				echo"<div class=\"info\"><p>Updated counter of status codes to $x.</p></div>\n";
			}
		}
		echo"
			</table>
		  </td>
		 </tr>
		</table>
	<!-- //Tasks -->

	";
}
elseif($action == "new_task"){
	if($process == 1){

		$inp_title = $_POST['inp_title'];
		$inp_title = output_html($inp_title);
		$inp_title_mysql = quote_smart($link, $inp_title);
		
		$inp_text = $_POST['inp_text'];

		$inp_status_code_id = $_POST['inp_status_code_id'];
		$inp_status_code_id = output_html($inp_status_code_id);
		$inp_status_code_id_mysql = quote_smart($link, $inp_status_code_id);
		
		// Update status_code_count_tasks
		$query = "SELECT status_code_id, status_code_count_tasks FROM $t_tasks_status_codes WHERE status_code_id=$inp_status_code_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_status_code_id, $get_status_code_count_tasks) = $row;
		if($get_status_code_id != ""){
			$inp_status_code_count_tasks = $get_status_code_count_tasks+1;
			$result = mysqli_query($link, "UPDATE $t_tasks_status_codes SET status_code_count_tasks='$inp_status_code_count_tasks' WHERE status_code_id=$get_status_code_id");


		}

		$inp_priority_id = $_POST['inp_priority_id'];
		$inp_priority_id = output_html($inp_priority_id);
		$inp_priority_id_mysql = quote_smart($link, $inp_priority_id);

		$inp_due_day = $_POST['inp_due_day'];
		$inp_due_month = $_POST['inp_due_month'];
		$inp_due_year = $_POST['inp_due_year'];
		$inp_due_datetime = $inp_due_year . "-" . $inp_due_month . "-" . $inp_due_day . " 23:00:00";
		$inp_due_datetime = output_html($inp_due_datetime);
		$inp_due_datetime_mysql = quote_smart($link, $inp_due_datetime);

		$inp_due_time = strtotime($inp_due_datetime);
		$inp_due_time_mysql = quote_smart($link, $inp_due_time);

		$inp_due_translated = "$inp_due_day";
		if($inp_due_month == "1" OR $inp_due_month == "01"){
			$inp_due_translated = $inp_due_translated . " $l_january";
		}
		elseif($inp_due_month == "2" OR $inp_due_month == "02"){
			$inp_due_translated = $inp_due_translated . " $l_february";
		}
		elseif($inp_due_month == "3" OR $inp_due_month == "03"){
			$inp_due_translated = $inp_due_translated . " $l_march";
		}
		elseif($inp_due_month == "4" OR $inp_due_month == "04"){
			$inp_due_translated = $inp_due_translated . " $l_april";
		}
		elseif($inp_due_month == "5" OR $inp_due_month == "05"){
			$inp_due_translated = $inp_due_translated . " $l_may";
		}
		elseif($inp_due_month == "6" OR $inp_due_month == "06"){
			$inp_due_translated = $inp_due_translated . " $l_june";
		}
		elseif($inp_due_month == "7" OR $inp_due_month == "07"){
			$inp_due_translated = $inp_due_translated . " $l_juli";
		}
		elseif($inp_due_month == "8" OR $inp_due_month == "08"){
			$inp_due_translated = $inp_due_translated . " $l_august";
		}
		elseif($inp_due_month == "9" OR $inp_due_month == "09"){
			$inp_due_translated = $inp_due_translated . " $l_september";
		}
		elseif($inp_due_month == "10"){
			$inp_due_translated = $inp_due_translated . " $l_october";
		}
		elseif($inp_due_month == "11"){
			$inp_due_translated = $inp_due_translated . " $l_november";
		}
		elseif($inp_due_month == "12"){
			$inp_due_translated = $inp_due_translated . " $l_december";
		}
		$inp_due_translated = $inp_due_translated . " $inp_due_year";
		$inp_due_translated = output_html($inp_due_translated);
		$inp_due_translated_mysql = quote_smart($link, $inp_due_translated);



		// Assigned to
		$inp_assigned_to_user_alias = $_POST['inp_assigned_to_user_alias'];
		$inp_assigned_to_user_alias = output_html($inp_assigned_to_user_alias);
		$inp_assigned_to_user_alias_mysql = quote_smart($link, $inp_assigned_to_user_alias);

		$query = "SELECT user_id, user_email, user_name, user_alias FROM $t_users WHERE user_alias=$inp_assigned_to_user_alias_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_user_id, $get_user_email, $get_user_name, $get_user_alias) = $row;

		if($get_user_id == ""){
			$get_user_id = 0;
		}
		$inp_assigned_to_user_id = $get_user_id;
		$inp_assigned_to_user_id = output_html($inp_assigned_to_user_id);
		$inp_assigned_to_user_id_mysql = quote_smart($link, $inp_assigned_to_user_id);

		$inp_assigned_to_user_email = "$get_user_email";
		$inp_assigned_to_user_email = output_html($inp_assigned_to_user_email);
		$inp_assigned_to_user_email_mysql = quote_smart($link, $inp_assigned_to_user_email);

		// Get assigned to photo
		$query = "SELECT photo_id, photo_destination FROM $t_users_profile_photo WHERE photo_user_id=$inp_assigned_to_user_id_mysql AND photo_profile_image='1'";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_photo_id, $get_photo_destination) = $row;

		$inp_assigned_to_user_image_mysql = quote_smart($link, $get_photo_destination);

		// System id
		$inp_system_id = $_POST['inp_system_id'];
		$inp_system_id = output_html($inp_system_id);
		$inp_system_id_mysql = quote_smart($link, $inp_system_id);

		// Project id
		$inp_project_id = $_POST['inp_project_id'];
		$inp_project_id = output_html($inp_project_id);
		$inp_project_id_mysql = quote_smart($link, $inp_project_id);


		// Creator
		$my_user_id = $_SESSION['user_id'];
		$my_user_id = output_html($my_user_id);
		$my_user_id_mysql = quote_smart($link, $my_user_id);
		$query = "SELECT user_id, user_email, user_name, user_alias, user_rank FROM $t_users WHERE user_id=$my_user_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_my_user_id, $get_my_user_email, $get_my_user_name, $get_my_user_alias, $get_my_user_rank) = $row;

		$query = "SELECT photo_id, photo_destination FROM $t_users_profile_photo WHERE photo_user_id=$get_my_user_id AND photo_profile_image='1'";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_photo_id, $get_photo_destination) = $row;

		$inp_created_by_user_id = $get_my_user_id;
		$inp_created_by_user_id = output_html($inp_created_by_user_id);
		$inp_created_by_user_id_mysql = quote_smart($link, $inp_created_by_user_id);

		$inp_created_by_user_alias = "$get_my_user_alias";
		$inp_created_by_user_alias = output_html($inp_created_by_user_alias);
		$inp_created_by_user_alias_mysql = quote_smart($link, $inp_created_by_user_alias);

		$inp_created_by_user_image = "$get_photo_destination";
		$inp_created_by_user_image = output_html($inp_created_by_user_image);
		$inp_created_by_user_image_mysql = quote_smart($link, $inp_created_by_user_image);

		$inp_created_by_user_email = "$get_my_user_email";
		$inp_created_by_user_email = output_html($inp_created_by_user_email);
		$inp_created_by_user_email_mysql = quote_smart($link, $inp_created_by_user_email);

		// Created and updated
		$datetime = date("Y-m-d H:i:s");


		$inp_created_translated = date("d");
		$month = date("m");
		$year = date("Y");
		if($month == "01"){
			$inp_created_translated = $inp_created_translated . " $l_january";
		}
		elseif($month == "02"){
			$inp_created_translated = $inp_created_translated . " $l_february";
		}
		elseif($month == "03"){
			$inp_created_translated = $inp_created_translated . " $l_march";
		}
		elseif($month == "04"){
			$inp_created_translated = $inp_created_translated . " $l_april";
		}
		elseif($month == "05"){
			$inp_created_translated = $inp_created_translated . " $l_may";
		}
		elseif($month == "06"){
			$inp_created_translated = $inp_created_translated . " $l_june";
		}
		elseif($month == "07"){
			$inp_created_translated = $inp_created_translated . " $l_juli";
		}
		elseif($month == "08"){
			$inp_created_translated = $inp_created_translated . " $l_august";
		}
		elseif($month == "09"){
			$inp_created_translated = $inp_created_translated . " $l_september";
		}
		elseif($month == "10"){
			$inp_created_translated = $inp_created_translated . " $l_october";
		}
		elseif($month == "11"){
			$inp_created_translated = $inp_created_translated . " $l_november";
		}
		elseif($month == "12"){
			$inp_created_translated = $inp_created_translated . " $l_december";
		}
		$inp_created_translated = $inp_created_translated . " $year";
		$inp_created_translated = output_html($inp_created_translated);
		$inp_created_translated_mysql = quote_smart($link, $inp_created_translated);


		// Insert
		mysqli_query($link, "INSERT INTO $t_tasks_index
		(task_id, task_title, task_text, task_status_code_id, task_priority_id, task_created_datetime, task_created_translated, task_created_by_user_id, task_created_by_user_alias, task_created_by_user_image, task_created_by_user_email, 
		task_updated_datetime, task_updated_translated, task_due_datetime, task_due_time, task_due_translated, task_assigned_to_user_id, task_assigned_to_user_alias, task_assigned_to_user_image, task_assigned_to_user_email, 
		task_is_archived, task_comments, task_project_id, task_project_part_id, task_system_id, task_system_part_id) 
		VALUES 
		(NULL, $inp_title_mysql, '', $inp_status_code_id_mysql, $inp_priority_id_mysql, '$datetime', $inp_created_translated_mysql , $inp_created_by_user_id_mysql, $inp_created_by_user_alias_mysql, $inp_created_by_user_image_mysql, $inp_created_by_user_email_mysql, 
		'$datetime', $inp_created_translated_mysql, $inp_due_datetime_mysql, $inp_due_time_mysql, $inp_due_translated_mysql, $inp_assigned_to_user_id_mysql, $inp_assigned_to_user_alias_mysql, $inp_assigned_to_user_image_mysql, $inp_assigned_to_user_email_mysql, 
		0, 0, $inp_project_id_mysql, 0, $inp_system_id_mysql, 0)")
		or die(mysqli_error($link));

		// Get ID
		$query = "SELECT task_id FROM $t_tasks_index WHERE task_created_datetime='$datetime'";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_task_id) = $row;

		// Text
		$sql = "UPDATE $t_tasks_index SET task_text=? WHERE task_id='$get_task_id'";
		$stmt = $link->prepare($sql);
		$stmt->bind_param("s", $inp_text);
		$stmt->execute();
		if ($stmt->errno) {
			echo "FAILURE!!! " . $stmt->error; die;
		}

		// Insert me + assigned person into subscriptions for this task
		mysqli_query($link, "INSERT INTO $t_tasks_subscriptions
		(subscription_id, subscription_task_id, subscription_user_id, subscription_user_email) 
		VALUES 
		(NULL, $get_task_id, $inp_created_by_user_id_mysql , $inp_created_by_user_email_mysql)")
		or die(mysqli_error($link));
		if($inp_assigned_to_user_email != "" && $inp_created_by_user_email != "$inp_assigned_to_user_email"){
			mysqli_query($link, "INSERT INTO $t_tasks_subscriptions
			(subscription_id, subscription_task_id, subscription_user_id, subscription_user_email) 
			VALUES 
			(NULL, $get_task_id, $inp_assigned_to_user_id_mysql , $inp_assigned_to_user_email_mysql)")
			or die(mysqli_error($link));
		}


		// Email to assigned person
		$fm_email = "";
		if($inp_assigned_to_user_email != "" && $inp_assigned_to_user_email != "$inp_created_by_user_email"){
			$subject = "Task $inp_title at $configWebsiteTitleSav";

			$message = "<html>\n";
			$message = $message. "<head>\n";
			$message = $message. "  <title>$subject</title>\n";

			$message = $message. "  <style type=\"text/css\"></style>\n";
			$message = $message. " </head>\n";
			$message = $message. "<body>\n";
			$message = $message. "<p><a href=\"$configSiteURLSav/users/view_profile.php?user_id=$inp_created_by_user_id&amp;l=$l\">$inp_created_by_user_alias</a> created a new task and assigned it to you.</p>\n";
			$message = $message. "<table>\n";
			$message = $message. " <tr>\n";
			$message = $message. "  <td><span>ID:</span></td>\n";
			$message = $message. "  <td><span>$get_task_id</span></td>\n";
			$message = $message. " </tr>\n";
			$message = $message. " <tr>\n";
			$message = $message. "  <td><span>Title:</span></td>\n";
			$message = $message. "  <td><span><a href=\"$configControlPanelURLSav/index.php?open=dashboard&amp;page=tasks&amp;action=open_task&amp;task_id=$get_task_id&amp;editor_language=$editor_language&amp;l=$l\">$inp_title</a></span></td>\n";
			$message = $message. " </tr>\n";
			$message = $message. " <tr>\n";
			$message = $message. "  <td><span>Due:</span></td>\n";
			$message = $message. "  <td><span>$inp_due_translated</span></td>\n";
			$message = $message. " </tr>\n";
			$message = $message. " <tr>\n";
			$message = $message. "  <td><span>Priority:</span></td>\n";
			$message = $message. "  <td><span>$inp_priority_id</span></td>\n";
			$message = $message. " </tr>\n";
			$message = $message. "<table>\n";
			$message = $message. "$inp_text";
			$message = $message. "</body>\n";
			$message = $message. "</html>\n";


			$headers = "MIME-Version: 1.0" . "\r\n" .
		  	  "Content-type: text/html; charset=iso-8859-1" . "\r\n" .
			    "To: $inp_assigned_to_user_email " . "\r\n" .
			    "From: $configFromEmailSav" . "\r\n" .
			    "Reply-To: $configFromEmailSav" . "\r\n" .
			    'X-Mailer: PHP/' . phpversion();

			mail($inp_assigned_to_user_email, $subject, $message, $headers);
			$fm_email = "email_sent_to_" . "$inp_assigned_to_user_email";
		}

		// Email to all subscribers
		$datetime = date("Y-m-d H:i:s");
		$time = time();
		$query = "SELECT subscription_id, subscription_user_id, subscription_user_email, subscription_last_sendt_datetime, subscription_last_sendt_time FROM $t_tasks_subscriptions_to_new_tasks";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_subscription_id, $get_subscription_user_id, $get_subscription_user_email, $get_subscription_last_sendt_datetime, $get_subscription_last_sendt_time) = $row;

			if($get_subscription_user_email != "$inp_created_by_user_email" && $get_subscription_user_email != "$inp_assigned_to_user_email"){
				$subject = "Info about new task $inp_title at $configWebsiteTitleSav";

				$message = "<html>\n";
				$message = $message. "<head>\n";
				$message = $message. "  <title>$subject</title>\n";

				$message = $message. "  <style type=\"text/css\"></style>\n";
				$message = $message. " </head>\n";
				$message = $message. "<body>\n";
				$message = $message. "<p><a href=\"$configSiteURLSav/users/view_profile.php?user_id=$inp_created_by_user_id&amp;l=$l\">$inp_created_by_user_alias</a> created a new task at $configWebsiteTitleSav.</p>\n";
				$message = $message. "<table>\n";
				$message = $message. " <tr>\n";
				$message = $message. "  <td><span>ID:</span></td>\n";
				$message = $message. "  <td><span>$get_task_id</span></td>\n";
				$message = $message. " </tr>\n";
				$message = $message. " <tr>\n";
				$message = $message. "  <td><span>Title:</span></td>\n";
				$message = $message. "  <td><span><a href=\"$configControlPanelURLSav/index.php?open=dashboard&amp;page=tasks&amp;action=open_task&amp;task_id=$get_task_id&amp;editor_language=$editor_language&amp;l=$l\">$inp_title</a></span></td>\n";
				$message = $message. " </tr>\n";
				$message = $message. " <tr>\n";
				$message = $message. "  <td><span>Due:</span></td>\n";
				$message = $message. "  <td><span>$inp_due_translated</span></td>\n";
				$message = $message. " </tr>\n";
				$message = $message. " <tr>\n";
				$message = $message. "  <td><span>Priority:</span></td>\n";
				$message = $message. "  <td><span>$inp_priority_id</span></td>\n";
				$message = $message. " </tr>\n";
				$message = $message. " <tr>\n";
				$message = $message. "  <td><span>Assigned to:</span></td>\n";
				$message = $message. "  <td><span>$inp_assigned_to_user_alias</span></td>\n";
				$message = $message. " </tr>\n";
				$message = $message. "<table>\n";
				$message = $message. "$inp_text";
				$message = $message. "<p>To unsubscribe go to <a href=\"$configControlPanelURLSav/index.php?open=dashboard&amp;page=tasks&amp;action=subscriptions_to_new_tasks&amp;l=$l\">control panel</a>.</p>";
				$message = $message. "</body>\n";
				$message = $message. "</html>\n";


				$headers = "MIME-Version: 1.0" . "\r\n" .
		  		  "Content-type: text/html; charset=iso-8859-1" . "\r\n" .
				    "To: $get_subscription_user_email " . "\r\n" .
				    "From: $configFromEmailSav" . "\r\n" .
				    "Reply-To: $configFromEmailSav" . "\r\n" .
				    'X-Mailer: PHP/' . phpversion();

				mail($inp_assigned_to_user_email, $subject, $message, $headers);
			} // email ok
		}



		header("Location: index.php?open=dashboard&page=tasks&action=open_task&task_id=$get_task_id&ft=success&fm=task_created&fm_email=$fm_email");
		exit;
	}
	$tabindex = 0;
	echo"
	<h1>New task</h1>

	<!-- Where am I? -->
		<p><b>You are here:</b><br />
		<a href=\"index.php?open=$open&amp;page=$page&amp;l=$l\">Tasks</a>
		&gt;
		<a href=\"index.php?open=$open&amp;page=$page&amp;action=new_task&amp;l=$l\">New task</a>
		</p>
	<!-- //Where am I? -->

	<!-- Feedback -->
		";
		if($ft != ""){
			if($fm == "changes_saved"){
				$fm = "$l_changes_saved";
			}
			else{
				$fm = ucfirst($ft);
			}
			echo"<div class=\"$ft\"><span>$fm</span></div>";
		}
		echo"	
	<!-- //Feedback -->

	<!-- Focus -->
		<script>
		\$(document).ready(function(){
			\$('[name=\"inp_title\"]').focus();
		});
		</script>
	<!-- //Focus -->

	<!-- TinyMCE -->
		<script type=\"text/javascript\" src=\"_javascripts/tinymce/tinymce.min.js\"></script>
				<script>
				tinymce.init({
					selector: 'textarea.editor',
					plugins: 'print preview searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern help',
					toolbar: 'formatselect | bold italic strikethrough forecolor backcolor permanentpen formatpainter | link image media pageembed | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent | removeformat | addcomment',
					image_advtab: true,
					content_css: [
					],
					link_list: [
						{ title: 'My page 1', value: 'http://www.tinymce.com' },
						{ title: 'My page 2', value: 'http://www.moxiecode.com' }
					],
					image_list: [
						{ title: 'My page 1', value: 'http://www.tinymce.com' },
						{ title: 'My page 2', value: 'http://www.moxiecode.com' }
					],
						image_class_list: [
						{ title: 'None', value: '' },
						{ title: 'Some class', value: 'class-name' }
					],
					importcss_append: true,
					height: 500,
					file_picker_callback: function (callback, value, meta) {
						/* Provide file and text for the link dialog */
						if (meta.filetype === 'file') {
							callback('https://www.google.com/logos/google.jpg', { text: 'My text' });
						}
						/* Provide image and alt text for the image dialog */
						if (meta.filetype === 'image') {
							callback('https://www.google.com/logos/google.jpg', { alt: 'My alt text' });
						}
						/* Provide alternative source and posted for the media dialog */
						if (meta.filetype === 'media') {
							callback('movie.mp4', { source2: 'alt.ogg', poster: 'https://www.google.com/logos/google.jpg' });
						}
					}
				});
				</script>
	<!-- //TinyMCE -->

	<!-- New task form -->";
		
		echo"
		<form method=\"post\" action=\"index.php?open=dashboard&amp;page=$page&amp;action=$action&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
		<p>Title:<br />
		<input type=\"text\" name=\"inp_title\" value=\"\" size=\"25\" />
		</p>

		<p>Text:<br />
		<textarea name=\"inp_text\" rows=\"10\" cols=\"80\" class=\"editor\"></textarea><br />
		</p>

		<p>Status:<br />
		<select name=\"inp_status_code_id\">";

		if(isset($_GET['status_code_id'])) {
			$status_code_id = $_GET['status_code_id'];
			$status_code_id = strip_tags(stripslashes($status_code_id));
		}
		else{
			$status_code_id = "";
		}


		$query = "SELECT status_code_id, status_code_title, status_code_color FROM $t_tasks_status_codes ORDER BY status_code_weight ASC";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_status_code_id, $get_status_code_title, $get_status_code_color) = $row;
			echo"			<option value=\"$get_status_code_id\""; if($get_status_code_id == "$status_code_id"){ echo" selected=\"selected\""; } echo">$get_status_code_title</option>\n";

		}
		echo"
		</select>
		</p>

		<p>Priority:<br />
		<select name=\"inp_priority_id\">
			<option value=\"1\">Immediate Priority</option>
			<option value=\"2\">High Priority</option>
			<option value=\"3\" selected=\"selected\">Normal Priority</option>
			<option value=\"4\">Low Priority</option>
			<option value=\"5\">Non-attendance</option>
		</select>
		</p>

		<p>Due:<br />
		<select name=\"inp_due_day\">
			<option value=\"\">- Day -</option>\n";
		$day = date("d");
		for($x=1;$x<32;$x++){
			if($x<10){
				$y = 0 . $x;
			}
			else{
				$y = $x;
			}
			echo"<option value=\"$y\""; if($day == "$y"){ echo" selected=\"selected\""; } echo">$x</option>\n";
		}
		echo"
		</select>

		<select name=\"inp_due_month\">
			<option value=\"\">- Month -</option>\n";
			$month = date("m");
			$next_month = $month+1;
			$l_month_array[0] = "";
			$l_month_array[1] = "$l_january";
			$l_month_array[2] = "$l_february";
			$l_month_array[3] = "$l_march";
			$l_month_array[4] = "$l_april";
			$l_month_array[5] = "$l_may";
			$l_month_array[6] = "$l_june";
			$l_month_array[7] = "$l_juli";
			$l_month_array[8] = "$l_august";
			$l_month_array[9] = "$l_september";
			$l_month_array[10] = "$l_october";
			$l_month_array[11] = "$l_november";
			$l_month_array[12] = "$l_december";
			for($x=1;$x<13;$x++){
				if($x<10){
					$y = 0 . $x;
				}
				else{
					$y = $x;
				}
				echo"<option value=\"$y\""; if($next_month == "$x"){ echo" selected=\"selected\""; } echo">$l_month_array[$x]</option>\n";
			}
		echo"
		</select>

		<select name=\"inp_due_year\">
		<option value=\"\">- Year -</option>\n";
			$current_year = date("Y");
			$year = date("Y");
			for($x=0;$x<150;$x++){
				echo"<option value=\"$year\""; if($current_year == "$year"){ echo" selected=\"selected\""; } echo">$year</option>\n";
				$year = $year-1;

			}
			echo"
		</select>
		</p>

		<p>Assign to:<br />
		<input type=\"text\" name=\"inp_assigned_to_user_alias\" value=\"\" size=\"25\" id=\"assigned_to_user_alias_search_query\" autocomplete=\"off\" />
		</p>
  		<div id=\"assigned_to_user_alias_search_results\"></div>

		<!-- Assign to search script -->
		<script id=\"source\" language=\"javascript\" type=\"text/javascript\">
			\$(document).ready(function () {
				\$('#assigned_to_user_alias_search_query').keyup(function () {
        				// getting the value that user typed
        				var searchString    = \$(\"#assigned_to_user_alias_search_query\").val();
        				// forming the queryString
       					var data            = 'inp_search_query='+ searchString;
         
        				// if searchString is not empty
        				if(searchString) {
           					// ajax call
            					\$.ajax({
                					type: \"POST\",
               						url: \"_inc/dashboard/tasks_search_for_user.php\",
                					data: data,
							beforeSend: function(html) { // this happens before actual call
								\$(\"#assigned_to_user_alias_search_results\").html(''); 
							},
               						success: function(html){
                    						\$(\"#assigned_to_user_alias_search_results\").append(html);
              						}
            					});
       					}
        				return false;
            			});
            		});
		</script>
		<!-- //Assign to search script -->


		<p>System: <a href=\"index.php?open=$open&amp;page=tasks_systems&amp;action=new_system&amp;l=$l\" target=\"_blank\">New</a><br />
		<select name=\"inp_system_id\">
			<option value=\"0\">None</option>\n";
		$query = "SELECT system_id, system_title FROM $t_tasks_systems WHERE system_is_active=1 ORDER BY system_title ASC";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_system_id, $get_system_title) = $row;
			echo"			<option value=\"$get_system_id\">$get_system_title</option>\n";
		}
		echo"
		</select>
		</p>

		<p>Project: <a href=\"index.php?open=$open&amp;page=tasks_projects&amp;action=new_project&amp;l=$l\" target=\"_blank\">New</a><br />
		<select name=\"inp_project_id\">
			<option value=\"0\">None</option>\n";
		$query = "SELECT project_id, project_title FROM $t_tasks_projects WHERE project_is_active=1 ORDER BY project_title ASC";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_project_id, $get_project_title) = $row;
			echo"			<option value=\"$get_project_id\">$get_project_title</option>\n";
		}
		echo"
		</select>
		</p>

		<p><input type=\"submit\" value=\"$l_save\" class=\"btn\" /></p>

		</form>
	<!-- //New task form -->

	";
} // new_task
elseif($action == "open_task"){
	// Get task
	$task_id_mysql = quote_smart($link, $task_id);
	$query = "SELECT task_id, task_title, task_text, task_status_code_id, task_priority_id, task_created_datetime, task_created_translated,  task_created_by_user_id, task_created_by_user_alias, task_created_by_user_image, task_created_by_user_email, task_updated_datetime, task_updated_translated, task_due_datetime, task_due_time, task_due_translated, task_assigned_to_user_id, task_assigned_to_user_alias, task_assigned_to_user_image, task_assigned_to_user_email, task_qa_datetime, task_qa_by_user_id, task_qa_by_user_alias, task_qa_by_user_image, task_qa_by_user_email, task_finished_datetime, task_finished_by_user_id, task_finished_by_user_alias, task_finished_by_user_image, task_finished_by_user_email, task_is_archived, task_comments, task_project_id, task_project_part_id, task_system_id, task_system_part_id FROM $t_tasks_index WHERE task_id=$task_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_task_id, $get_current_task_title, $get_current_task_text, $get_current_task_status_code_id, $get_current_task_priority_id, $get_current_task_created_datetime, $get_current_task_created_translated, $get_current_task_created_by_user_id, $get_current_task_created_by_user_alias, $get_current_task_created_by_user_image, $get_current_task_created_by_user_email, $get_current_task_updated_datetime, $get_current_task_updated_translated, $get_current_task_due_datetime, $get_current_task_due_time, $get_current_task_due_translated, $get_current_task_assigned_to_user_id, $get_current_task_assigned_to_user_alias, $get_current_task_assigned_to_user_image, $get_current_task_assigned_to_user_email, $get_current_task_qa_datetime, $get_current_task_qa_by_user_id, $get_current_task_qa_by_user_alias, $get_current_task_qa_by_user_image, $get_current_task_qa_by_user_email, $get_current_task_finished_datetime, $get_current_task_finished_by_user_id, $get_current_task_finished_by_user_alias, $get_current_task_finished_by_user_image, $get_current_task_finished_by_user_email, $get_current_task_is_archived, $get_current_task_comments, $get_current_task_project_id, $get_current_task_project_part_id, $get_current_task_system_id, $get_current_task_system_part_id) = $row;
	if($get_current_task_id == ""){
		echo"<p>Server error 404</p>";
	}
	else{

		// Read?
		$my_user_id = $_SESSION['user_id'];
		$my_user_id = output_html($my_user_id);
		$my_user_id_mysql = quote_smart($link, $my_user_id);
		$query_r = "SELECT read_id FROM $t_tasks_read WHERE read_task_id=$get_current_task_id AND read_user_id=$my_user_id_mysql";
		$result_r = mysqli_query($link, $query_r);
		$row_r = mysqli_fetch_row($result_r);
		list($get_read_id) = $row_r;
		if($get_read_id == ""){
			// Insert read
			mysqli_query($link, "INSERT INTO $t_tasks_read 
			(read_id, read_task_id, read_user_id) 
			VALUES 
			(NULL, $get_current_task_id, $my_user_id_mysql)")
			or die(mysqli_error($link));
		}


		echo"
		<h1>$get_current_task_title</h1>
		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=$open&amp;page=tasks&amp;l=$l\">Tasks</a>
			";

			// Status
			$query = "SELECT status_code_id, status_code_title FROM $t_tasks_status_codes WHERE status_code_id=$get_current_task_status_code_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_status_code_id, $get_status_code_title) = $row;
			echo"
			&gt;
			<a href=\"index.php?open=$open&amp;page=$page&amp;status_code_id=$get_status_code_id&amp;l=$l\">$get_status_code_title</a>
			&gt;
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=open_task&amp;task_id=$get_current_task_id&amp;l=$l\">$get_current_task_title</a>
			</p>
		<!-- //Where am I? -->

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

		<!-- Menu -->
			<p>
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=edit_task&amp;task_id=$get_current_task_id&amp;l=$l\" class=\"btn_default\">Edit task</a>
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=delete_task&amp;task_id=$get_current_task_id&amp;l=$l\" class=\"btn_default\">Delete task</a>
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=archive_task&amp;task_id=$get_current_task_id&amp;l=$l\" class=\"btn_default\">Archive task</a>
			</p>
		<!-- Menu -->


		<!-- View task header-->
			<div style=\"display: flex;\">
				<div style=\"flex: 1;\">
					<table>
					 <tr>
					  <td style=\"padding-right: 4px;\">
						<span style=\"font-weight: bold;\">System:</span>
					  </td>
					  <td>
						<span>";
						$query = "SELECT system_id, system_title FROM $t_tasks_systems WHERE system_id=$get_current_task_system_id";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_system_id, $get_system_title) = $row;
						echo"$get_system_title</span>
					  </td>
					 </tr>
					 <tr>
					  <td style=\"padding-right: 4px;\">
						<span style=\"font-weight: bold;\">Project:</span>
					  </td>
					  <td>
						<span>";
						$query = "SELECT project_id, project_title FROM $t_tasks_projects WHERE project_id=$get_current_task_project_id";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_project_id, $get_project_title) = $row;
						echo"$get_project_title</span>
					  </td>
					 </tr>
					 <tr>
					  <td style=\"padding-right: 4px;\">
						<span style=\"font-weight: bold;\">Priority:</span>
					  </td>
					  <td>
						<span>";
						if($get_current_task_priority_id == "1"){
							echo"Immediate Priority";
						}
						elseif($get_current_task_priority_id == "2"){
							echo"High Priority";
						}
						elseif($get_current_task_priority_id == "3"){
							echo"Normal Priority";
						}
						elseif($get_current_task_priority_id == "4"){
							echo"Low Priority";
						}
						elseif($get_current_task_priority_id == "5"){
							echo"Non-attendance";
						}
						echo"</span>
					  </td>
					 </tr>
					</table>
				</div>
				<div style=\"flex: 1;\">
					<table>
					 <tr>
					  <td style=\"padding-right: 4px;\">
						<span style=\"font-weight: bold;\">Assigned to:</span>
					  </td>
					  <td>
						<span><a href=\"../users/view_profile.php?user_id=$get_current_task_assigned_to_user_id&amp;l=$l\">$get_current_task_assigned_to_user_alias</a></span>
					  </td>
					 </tr>
					 <tr>
					  <td style=\"padding-right: 4px;\">
						<span style=\"font-weight: bold;\">Updated:</span>
					  </td>
					  <td>
						<span>$get_current_task_updated_translated</span>
					  </td>
					 </tr>
					 <tr>
					  <td style=\"padding-right: 4px;\">
						<span style=\"font-weight: bold;\">Due:</span>
					  </td>
					  <td>
						<span>$get_current_task_due_translated</span>
					  </td>
					 </tr>
					</table>
				</div>
				<div style=\"flex: 1;\">
					<table>
					 <tr>
					  <td style=\"padding-right: 4px;\">
						<span style=\"font-weight: bold;\">Created by:</span>
					  </td>
					  <td>
						<span><a href=\"../users/view_profile.php?user_id=$get_current_task_created_by_user_id&amp;l=$l\">$get_current_task_created_by_user_alias</a></span>
					  </td>
					 </tr>
					 <tr>
					  <td style=\"padding-right: 4px;\">
						<span style=\"font-weight: bold;\">Created date:</span>
					  </td>
					  <td>
						<span>$get_current_task_created_translated</span>
					  </td>
					 </tr>
					</table>
				</div>

			</div>
			<div class=\"clear\" style=\"height: 20px;\"></div>
		<!-- //View task header -->

		<!-- Text -->
			$get_current_task_text
		<!-- //Text -->
		";
	} // task foud
} // open_task
elseif($action == "edit_task"){
	// Get task
	$task_id_mysql = quote_smart($link, $task_id);
	$query = "SELECT task_id, task_title, task_text, task_status_code_id, task_priority_id, task_created_datetime, task_created_translated,  task_created_by_user_id, task_created_by_user_alias, task_created_by_user_image, task_created_by_user_email, task_updated_datetime, task_updated_translated, task_due_datetime, task_due_time, task_due_translated, task_assigned_to_user_id, task_assigned_to_user_alias, task_assigned_to_user_image, task_assigned_to_user_email, task_qa_datetime, task_qa_by_user_id, task_qa_by_user_alias, task_qa_by_user_image, task_qa_by_user_email, task_finished_datetime, task_finished_by_user_id, task_finished_by_user_alias, task_finished_by_user_image, task_finished_by_user_email, task_is_archived, task_comments, task_project_id, task_project_part_id, task_system_id, task_system_part_id FROM $t_tasks_index WHERE task_id=$task_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_task_id, $get_current_task_title, $get_current_task_text, $get_current_task_status_code_id, $get_current_task_priority_id, $get_current_task_created_datetime, $get_current_task_created_translated, $get_current_task_created_by_user_id, $get_current_task_created_by_user_alias, $get_current_task_created_by_user_image, $get_current_task_created_by_user_email, $get_current_task_updated_datetime, $get_current_task_updated_translated, $get_current_task_due_datetime, $get_current_task_due_time, $get_current_task_due_translated, $get_current_task_assigned_to_user_id, $get_current_task_assigned_to_user_alias, $get_current_task_assigned_to_user_image, $get_current_task_assigned_to_user_email, $get_current_task_qa_datetime, $get_current_task_qa_by_user_id, $get_current_task_qa_by_user_alias, $get_current_task_qa_by_user_image, $get_current_task_qa_by_user_email, $get_current_task_finished_datetime, $get_current_task_finished_by_user_id, $get_current_task_finished_by_user_alias, $get_current_task_finished_by_user_image, $get_current_task_finished_by_user_email, $get_current_task_is_archived, $get_current_task_comments, $get_current_task_project_id, $get_current_task_project_part_id, $get_current_task_system_id, $get_current_task_system_part_id) = $row;
	if($get_current_task_id == ""){
		echo"<p>Server error 404</p>";
	}
	else{	if($process == 1){

			$inp_title = $_POST['inp_title'];
			$inp_title = output_html($inp_title);
			$inp_title_mysql = quote_smart($link, $inp_title);
		
			$inp_text = $_POST['inp_text'];

			$inp_status_code_id = $_POST['inp_status_code_id'];
			$inp_status_code_id = output_html($inp_status_code_id);
			$inp_status_code_id_mysql = quote_smart($link, $inp_status_code_id);
		
			// Update status_code_count_tasks
			$query = "SELECT status_code_id, status_code_count_tasks FROM $t_tasks_status_codes WHERE status_code_id=$inp_status_code_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_status_code_id, $get_status_code_count_tasks) = $row;
			if($get_status_code_id != "$get_current_task_status_code_id"){
				// Update new status code with +1
				$inp_status_code_count_tasks = $get_status_code_count_tasks+1;
				$result = mysqli_query($link, "UPDATE $t_tasks_status_codes SET status_code_count_tasks='$inp_status_code_count_tasks' WHERE status_code_id=$get_status_code_id");

				// Update old status code with -1
				$query = "SELECT status_code_id, status_code_count_tasks FROM $t_tasks_status_codes WHERE status_code_id=$get_current_task_status_code_id";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_status_code_id, $get_status_code_count_tasks) = $row;
				$inp_status_code_count_tasks = $get_status_code_count_tasks-1;
				$result = mysqli_query($link, "UPDATE $t_tasks_status_codes SET status_code_count_tasks='$inp_status_code_count_tasks' WHERE status_code_id=$get_current_task_status_code_id");

			}

			$inp_priority_id = $_POST['inp_priority_id'];
			$inp_priority_id = output_html($inp_priority_id);
			$inp_priority_id_mysql = quote_smart($link, $inp_priority_id);

			$inp_due_day = $_POST['inp_due_day'];
			$inp_due_month = $_POST['inp_due_month'];
			$inp_due_year = $_POST['inp_due_year'];
			$inp_due_datetime = $inp_due_year . "-" . $inp_due_month . "-" . $inp_due_day . " 23:00:00";
			$inp_due_datetime = output_html($inp_due_datetime);
			$inp_due_datetime_mysql = quote_smart($link, $inp_due_datetime);

			$inp_due_time = strtotime($inp_due_datetime);
			$inp_due_time_mysql = quote_smart($link, $inp_due_time);

			$inp_due_translated = "$inp_due_day";
			if($inp_due_month == "1" OR $inp_due_month == "01"){
				$inp_due_translated = $inp_due_translated . " $l_january";
			}
			elseif($inp_due_month == "2" OR $inp_due_month == "02"){
				$inp_due_translated = $inp_due_translated . " $l_february";
			}
			elseif($inp_due_month == "3" OR $inp_due_month == "03"){
				$inp_due_translated = $inp_due_translated . " $l_march";
			}
			elseif($inp_due_month == "4" OR $inp_due_month == "04"){
				$inp_due_translated = $inp_due_translated . " $l_april";
			}
			elseif($inp_due_month == "5" OR $inp_due_month == "05"){
				$inp_due_translated = $inp_due_translated . " $l_may";
			}
			elseif($inp_due_month == "6" OR $inp_due_month == "06"){
				$inp_due_translated = $inp_due_translated . " $l_june";
			}
			elseif($inp_due_month == "7" OR $inp_due_month == "07"){
				$inp_due_translated = $inp_due_translated . " $l_juli";
			}
			elseif($inp_due_month == "8" OR $inp_due_month == "08"){
				$inp_due_translated = $inp_due_translated . " $l_august";
			}
			elseif($inp_due_month == "9" OR $inp_due_month == "09"){
				$inp_due_translated = $inp_due_translated . " $l_september";
			}
			elseif($inp_due_month == "10"){
				$inp_due_translated = $inp_due_translated . " $l_october";
			}
			elseif($inp_due_month == "11"){
				$inp_due_translated = $inp_due_translated . " $l_november";
			}
			elseif($inp_due_month == "12"){
				$inp_due_translated = $inp_due_translated . " $l_december";
			}
			$inp_due_translated = $inp_due_translated . " $inp_due_year";
			$inp_due_translated = output_html($inp_due_translated);
			$inp_due_translated_mysql = quote_smart($link, $inp_due_translated);



			// Assigned to
			$inp_assigned_to_user_alias = $_POST['inp_assigned_to_user_alias'];
			$inp_assigned_to_user_alias = output_html($inp_assigned_to_user_alias);
			$inp_assigned_to_user_alias_mysql = quote_smart($link, $inp_assigned_to_user_alias);
	
			$query = "SELECT user_id, user_email, user_name, user_alias FROM $t_users WHERE user_alias=$inp_assigned_to_user_alias_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_user_id, $get_user_email, $get_user_name, $get_user_alias) = $row;

			if($get_user_id == ""){
				$get_user_id = 0;
			}
			$inp_assigned_to_user_id = $get_user_id;
			$inp_assigned_to_user_id = output_html($inp_assigned_to_user_id);
			$inp_assigned_to_user_id_mysql = quote_smart($link, $inp_assigned_to_user_id);

			$inp_assigned_to_user_email = "$get_user_email";
			$inp_assigned_to_user_email = output_html($inp_assigned_to_user_email);
			$inp_assigned_to_user_email_mysql = quote_smart($link, $inp_assigned_to_user_email);

			// Get assigned to photo
			$query = "SELECT photo_id, photo_destination FROM $t_users_profile_photo WHERE photo_user_id=$inp_assigned_to_user_id_mysql AND photo_profile_image='1'";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_photo_id, $get_photo_destination) = $row;

			$inp_assigned_to_user_image_mysql = quote_smart($link, $get_photo_destination);

			// System id
			$inp_system_id = $_POST['inp_system_id'];
			$inp_system_id = output_html($inp_system_id);
			$inp_system_id_mysql = quote_smart($link, $inp_system_id);

			// Project id
			$inp_project_id = $_POST['inp_project_id'];
			$inp_project_id = output_html($inp_project_id);
			$inp_project_id_mysql = quote_smart($link, $inp_project_id);


		
			// Updated
			$datetime = date("Y-m-d H:i:s");


			$inp_updated_translated = date("d");
			$month = date("m");
			$year = date("Y");
			if($month == "01"){
				$inp_updated_translated = $inp_updated_translated . " $l_january";
			}
			elseif($month == "2"){
				$inp_updated_translated = $inp_updated_translated . " $l_february";
			}
			elseif($month == "03"){
				$inp_updated_translated = $inp_updated_translated . " $l_march";
			}
			elseif($month == "04"){
				$inp_updated_translated = $inp_updated_translated . " $l_april";
			}
			elseif($month == "05"){
				$inp_updated_translated = $inp_updated_translated . " $l_may";
			}
			elseif($month == "06"){
				$inp_updated_translated = $inp_updated_translated . " $l_june";
			}
			elseif($month == "07"){
				$inp_updated_translated = $inp_updated_translated . " $l_juli";
			}
			elseif($month == "08"){
				$inp_updated_translated = $inp_updated_translated . " $l_august";
			}
			elseif($month == "09"){
				$inp_updated_translated = $inp_updated_translated . " $l_september";
			}
			elseif($month == "10"){
				$inp_updated_translated = $inp_updated_translated . " $l_october";
			}
			elseif($month == "11"){
				$inp_updated_translated = $inp_updated_translated . " $l_november";
			}
			elseif($month == "12"){
				$inp_updated_translated = $inp_updated_translated . " $l_december";
			}
			$inp_updated_translated = $inp_updated_translated . " $year";
			$inp_updated_translated = output_html($inp_updated_translated);
			$inp_updated_translated_mysql = quote_smart($link, $inp_updated_translated);


			// Update
			$result = mysqli_query($link, "UPDATE $t_tasks_index SET 
				task_title=$inp_title_mysql, task_status_code_id=$inp_status_code_id_mysql, task_priority_id=$inp_priority_id_mysql, 
				task_updated_datetime='$datetime', task_updated_translated=$inp_updated_translated_mysql, task_due_datetime=$inp_due_datetime_mysql, 
				task_due_time=$inp_due_time_mysql, task_due_translated=$inp_due_translated_mysql, 
				task_assigned_to_user_id=$inp_assigned_to_user_id_mysql, task_assigned_to_user_alias=$inp_assigned_to_user_alias_mysql, 
				task_assigned_to_user_image=$inp_assigned_to_user_image_mysql, task_assigned_to_user_email=$inp_assigned_to_user_email_mysql, 
				task_project_id=$inp_project_id_mysql, task_system_id=$inp_system_id_mysql WHERE task_id=$get_current_task_id") or die(mysqli_error($link));



			// Text
			$sql = "UPDATE $t_tasks_index SET task_text=? WHERE task_id='$get_current_task_id'";
			$stmt = $link->prepare($sql);
			$stmt->bind_param("s", $inp_text);
			$stmt->execute();
			if ($stmt->errno) {
				echo "FAILURE!!! " . $stmt->error; die;
			}

			// Delete read
			$result = mysqli_query($link, "DELETE FROM $t_tasks_read WHERE read_task_id='$get_current_task_id'");


			// Fetch my id and alias
			$my_user_id = $_SESSION['user_id'];
			$my_user_id = output_html($my_user_id);
			$my_user_id_mysql = quote_smart($link, $my_user_id);
			$query = "SELECT user_id, user_email, user_name, user_alias, user_rank FROM $t_users WHERE user_id=$my_user_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_my_user_id, $get_my_user_email, $get_my_user_name, $get_my_user_alias, $get_my_user_rank) = $row;


			// Email if assigned to new person
			$fm_email = "";
			if($get_current_task_assigned_to_user_id != "$inp_assigned_to_user_id" && $inp_assigned_to_user_email != ""){
				
				$subject = "Task $inp_title reassiged to you at $configWebsiteTitleSav";

				$message = "<html>\n";
				$message = $message. "<head>\n";
				$message = $message. "  <title>$subject</title>\n";

				$message = $message. "  <style type=\"text/css\"></style>\n";
				$message = $message. " </head>\n";
				$message = $message. "<body>\n";
				$message = $message. "<p>An assignment has been reassigned to you by <a href=\"$configSiteURLSav/users/view_profile.php?user_id=$get_my_user_id&amp;l=$l\">$get_my_user_alias</a>.</p>\n";
				$message = $message. "<table>\n";
				$message = $message. " <tr>\n";
				$message = $message. "  <td><span>ID:</span></td>\n";
				$message = $message. "  <td><span>$get_current_task_id</span></td>\n";
				$message = $message. " </tr>\n";
				$message = $message. " <tr>\n";
				$message = $message. "  <td><span>Title:</span></td>\n";
				$message = $message. "  <td><span><a href=\"$configControlPanelURLSav/index.php?open=dashboard&amp;page=tasks&amp;action=open_task&amp;task_id=$get_current_task_id&amp;editor_language=$editor_language&amp;l=$l\">$inp_title</a></span></td>\n";
				$message = $message. " </tr>\n";
				$message = $message. " <tr>\n";
				$message = $message. "  <td><span>Due:</span></td>\n";
				$message = $message. "  <td><span>$inp_due_translated</span></td>\n";
				$message = $message. " </tr>\n";
				$message = $message. " <tr>\n";
				$message = $message. "  <td><span>Priority:</span></td>\n";
				$message = $message. "  <td><span>$inp_priority_id</span></td>\n";
				$message = $message. " </tr>\n";
				$message = $message. " <tr>\n";
				$message = $message. "  <td><span>Status:</span></td>\n";
				$message = $message. "  <td><span>$inp_status_code_id</span></td>\n";
				$message = $message. " </tr>\n";
				$message = $message. "<table>\n";
				$message = $message. "$inp_text";

				$message = $message. "</body>\n";
				$message = $message. "</html>\n";

				$headers = "MIME-Version: 1.0" . "\r\n" .
		  		  "Content-type: text/html; charset=iso-8859-1" . "\r\n" .
				    "To: $inp_assigned_to_user_email " . "\r\n" .
				    "From: $configFromEmailSav" . "\r\n" .
				    "Reply-To: $configFromEmailSav" . "\r\n" .
				    'X-Mailer: PHP/' . phpversion();
				mail($inp_assigned_to_user_email, $subject, $message, $headers);


				$fm_email = "email_sent_to_" . "$inp_assigned_to_user_email" . "_from_" . $configFromEmailSav;
			}

			// Email to all task subscribers
			$query = "SELECT subscription_id, subscription_task_id, subscription_user_id, subscription_user_email FROM $t_tasks_subscriptions WHERE subscription_task_id=$get_current_task_id";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_subscription_id, $get_subscription_task_id, $get_subscription_user_id, $get_subscription_user_email) = $row;

				if($get_subscription_user_email != "$get_my_user_email" && $get_subscription_user_email != "$inp_assigned_to_user_id"){
					$subject = "Task $inp_title changed at $configWebsiteTitleSav";

					$message = "<html>\n";
					$message = $message. "<head>\n";
					$message = $message. "  <title>$subject</title>\n";

					$message = $message. "  <style type=\"text/css\"></style>\n";
					$message = $message. " </head>\n";
					$message = $message. "<body>\n";
					$message = $message. "<p>The user <a href=\"$configSiteURLSav/users/view_profile.php?user_id=$get_my_user_id&amp;l=$l\">$get_my_user_alias</a> has made changes to the task.</p>\n";
					$message = $message. "<table>\n";
					$message = $message. " <tr>\n";
					$message = $message. "  <td><span>ID:</span></td>\n";
					$message = $message. "  <td><span>$get_current_task_id</span></td>\n";
					$message = $message. " </tr>\n";
					$message = $message. " <tr>\n";
					$message = $message. "  <td><span>Title:</span></td>\n";
					$message = $message. "  <td><span><a href=\"$configControlPanelURLSav/index.php?open=dashboard&amp;page=tasks&amp;action=open_task&amp;task_id=$get_current_task_id&amp;editor_language=$editor_language&amp;l=$l\">$inp_title</a></span></td>\n";
					$message = $message. " </tr>\n";
					$message = $message. " <tr>\n";
					$message = $message. "  <td><span>Due:</span></td>\n";
					$message = $message. "  <td><span>$inp_due_translated</span></td>\n";
					$message = $message. " </tr>\n";
					$message = $message. " <tr>\n";
					$message = $message. "  <td><span>Priority:</span></td>\n";
					$message = $message. "  <td><span>$inp_priority_id</span></td>\n";
					$message = $message. " </tr>\n";
					$message = $message. " <tr>\n";
					$message = $message. "  <td><span>Status:</span></td>\n";
					$message = $message. "  <td><span>$inp_status_code_id</span></td>\n";
					$message = $message. " </tr>\n";
					$message = $message. "<table>\n";
					$message = $message. "$inp_text";

					$message = $message. "</body>\n";
					$message = $message. "</html>\n";


					$headers = "MIME-Version: 1.0" . "\r\n" .
		  			  "Content-type: text/html; charset=iso-8859-1" . "\r\n" .
					    "To: $get_subscription_user_email " . "\r\n" .
					    "From: $configFromEmailSav" . "\r\n" .
					    "Reply-To: $configFromEmailSav" . "\r\n" .
					    'X-Mailer: PHP/' . phpversion();
					mail($get_subscription_user_email, $subject, $message, $headers);
					

				} // not extra emails

			} // while


			header("Location: index.php?open=dashboard&page=tasks&action=open_task&task_id=$get_current_task_id&ft=success&fm=changes_saved&fm_email=$fm_email");
			exit;
		}
		echo"
		<h1>$get_current_task_title</h1>
		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=$open&amp;page=tasks&amp;l=$l\">Tasks</a>
			";

			// Status
			$query = "SELECT status_code_id, status_code_title FROM $t_tasks_status_codes WHERE status_code_id=$get_current_task_status_code_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_status_code_id, $get_status_code_title) = $row;
			echo"
			&gt;
			<a href=\"index.php?open=$open&amp;page=$page&amp;status_code_id=$get_status_code_id&amp;l=$l\">$get_status_code_title</a>
			&gt;
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=open_task&amp;task_id=$get_current_task_id&amp;l=$l\">$get_current_task_title</a>
			&gt;
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=edit_task&amp;task_id=$get_current_task_id&amp;l=$l\">Edit</a>
			</p>
		<!-- //Where am I? -->

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


		<!-- Focus -->
		<script>
		\$(document).ready(function(){
			\$('[name=\"inp_title\"]').focus();
		});
		</script>
		<!-- //Focus -->

		<!-- TinyMCE -->
		<script type=\"text/javascript\" src=\"_javascripts/tinymce/tinymce.min.js\"></script>
				<script>
				tinymce.init({
					selector: 'textarea.editor',
					plugins: 'print preview searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern help',
					toolbar: 'formatselect | bold italic strikethrough forecolor backcolor permanentpen formatpainter | link image media pageembed | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent | removeformat | addcomment',
					image_advtab: true,
					content_css: [
					],
					link_list: [
						{ title: 'My page 1', value: 'http://www.tinymce.com' },
						{ title: 'My page 2', value: 'http://www.moxiecode.com' }
					],
					image_list: [
						{ title: 'My page 1', value: 'http://www.tinymce.com' },
						{ title: 'My page 2', value: 'http://www.moxiecode.com' }
					],
						image_class_list: [
						{ title: 'None', value: '' },
						{ title: 'Some class', value: 'class-name' }
					],
					importcss_append: true,
					height: 500,
					file_picker_callback: function (callback, value, meta) {
						/* Provide file and text for the link dialog */
						if (meta.filetype === 'file') {
							callback('https://www.google.com/logos/google.jpg', { text: 'My text' });
						}
						/* Provide image and alt text for the image dialog */
						if (meta.filetype === 'image') {
							callback('https://www.google.com/logos/google.jpg', { alt: 'My alt text' });
						}
						/* Provide alternative source and posted for the media dialog */
						if (meta.filetype === 'media') {
							callback('movie.mp4', { source2: 'alt.ogg', poster: 'https://www.google.com/logos/google.jpg' });
						}
					}
				});
				</script>
		<!-- //TinyMCE -->

		<!-- Edit task form -->
			<form method=\"post\" action=\"index.php?open=dashboard&amp;page=$page&amp;action=$action&amp;task_id=$get_current_task_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
			<p>Title:<br />
			<input type=\"text\" name=\"inp_title\" value=\"$get_current_task_title\" size=\"25\" />
			</p>

			<p>Status:<br />
			<select name=\"inp_status_code_id\">";
			$query = "SELECT status_code_id, status_code_title, status_code_color FROM $t_tasks_status_codes ORDER BY status_code_weight ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
			list($get_status_code_id, $get_status_code_title, $get_status_code_color) = $row;
				echo"			<option value=\"$get_status_code_id\""; if($get_current_task_status_code_id == "$get_status_code_id"){ echo" selected=\"selected\""; } echo">$get_status_code_title</option>\n";
			}
			echo"
			</select>
			</p>

			<p>Assign to:<br />
			<input type=\"text\" name=\"inp_assigned_to_user_alias\" value=\"$get_current_task_assigned_to_user_alias\" size=\"25\" id=\"assigned_to_user_alias_search_query\" autocomplete=\"off\" />
			</p>
  			<div id=\"assigned_to_user_alias_search_results\"></div>

			<!-- Assign to search script -->
			<script id=\"source\" language=\"javascript\" type=\"text/javascript\">
			\$(document).ready(function () {
				\$('#assigned_to_user_alias_search_query').keyup(function () {
        				// getting the value that user typed
        				var searchString    = \$(\"#assigned_to_user_alias_search_query\").val();
        				// forming the queryString
       					var data            = 'inp_search_query='+ searchString;
         
        				// if searchString is not empty
        				if(searchString) {
           					// ajax call
            					\$.ajax({
                					type: \"POST\",
               						url: \"_inc/dashboard/tasks_search_for_user.php\",
                					data: data,
							beforeSend: function(html) { // this happens before actual call
								\$(\"#assigned_to_user_alias_search_results\").html(''); 
							},
               						success: function(html){
                    						\$(\"#assigned_to_user_alias_search_results\").append(html);
              						}
            					});
       					}
        				return false;
            			});
            		});
			</script>
			<!-- //Assign to search script -->
	

			<p>Text:<br />
			<textarea name=\"inp_text\" rows=\"10\" cols=\"80\" class=\"editor\">$get_current_task_text</textarea><br />
			</p>


			<p>Priority:<br />
			<select name=\"inp_priority_id\">
				<option value=\"1\""; if($get_current_task_priority_id == "1"){ echo" selected=\"selected\""; } echo">Immediate Priority</option>
				<option value=\"2\""; if($get_current_task_priority_id == "2"){ echo" selected=\"selected\""; } echo">High Priority</option>
				<option value=\"3\""; if($get_current_task_priority_id == "3"){ echo" selected=\"selected\""; } echo">Normal Priority</option>
				<option value=\"4\""; if($get_current_task_priority_id == "4"){ echo" selected=\"selected\""; } echo">Low Priority</option>
				<option value=\"5\""; if($get_current_task_priority_id == "5"){ echo" selected=\"selected\""; } echo">Non-attendance</option>
			</select>
			</p>

			<p>Due:<br />
			<select name=\"inp_due_day\">
				<option value=\"\">- Day -</option>\n";

			$due_day = substr($get_current_task_due_datetime, 8, 2); 
			for($x=1;$x<32;$x++){
				if($x<10){
					$y = 0 . $x;
				}
				else{
					$y = $x;
				}
				echo"<option value=\"$y\""; if($due_day == "$y"){ echo" selected=\"selected\""; } echo">$x</option>\n";
			}
			echo"
			</select>

		<select name=\"inp_due_month\">
			<option value=\"\">- Month -</option>\n";

			$due_month = substr($get_current_task_due_datetime, 5, 2); 

			$month = date("m");
			$l_month_array[0] = "";
			$l_month_array[1] = "$l_january";
			$l_month_array[2] = "$l_february";
			$l_month_array[3] = "$l_march";
			$l_month_array[4] = "$l_april";
			$l_month_array[5] = "$l_may";
			$l_month_array[6] = "$l_june";
			$l_month_array[7] = "$l_juli";
			$l_month_array[8] = "$l_august";
			$l_month_array[9] = "$l_september";
			$l_month_array[10] = "$l_october";
			$l_month_array[11] = "$l_november";
			$l_month_array[12] = "$l_december";
			for($x=1;$x<13;$x++){
				if($x<10){
					$y = 0 . $x;
				}
				else{
					$y = $x;
				}
				echo"<option value=\"$y\""; if($due_month == "$x"){ echo" selected=\"selected\""; } echo">$l_month_array[$x]</option>\n";
			}
		echo"
		</select>

		<select name=\"inp_due_year\">
		<option value=\"\">- Year -</option>\n";
			$due_year = substr($get_current_task_due_datetime, 0, 4); 
			$year = date("Y");
			for($x=0;$x<150;$x++){
				echo"<option value=\"$year\""; if($due_year == "$year"){ echo" selected=\"selected\""; } echo">$year</option>\n";
				$year = $year-1;

			}
			echo"
		</select>
		</p>



		<p>System: <a href=\"index.php?open=$open&amp;page=tasks_systems&amp;action=new_system&amp;l=$l\" target=\"_blank\">New</a><br />
		<select name=\"inp_system_id\">
			<option value=\"0\">None</option>\n";
		$query = "SELECT system_id, system_title FROM $t_tasks_systems WHERE system_is_active=1 ORDER BY system_title ASC";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_system_id, $get_system_title) = $row;
			echo"			<option value=\"$get_system_id\""; if($get_system_id == "$get_current_task_system_id"){ echo" selected=\"selected\""; } echo">$get_system_title</option>\n";
		}
		echo"
		</select>
		</p>

		<p>Project: <a href=\"index.php?open=$open&amp;page=tasks_projects&amp;action=new_project&amp;l=$l\" target=\"_blank\">New</a><br />
		<select name=\"inp_project_id\">
			<option value=\"0\">None</option>\n";

		$query = "SELECT project_id, project_title FROM $t_tasks_projects WHERE project_is_active=1 ORDER BY project_title ASC";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_project_id, $get_project_title) = $row;
			echo"			<option value=\"$get_project_id\""; if($get_project_id == "$get_current_task_project_id"){ echo" selected=\"selected\""; } echo">$get_project_title</option>\n";
		}
		echo"
		</select>
		</p>

		<p><input type=\"submit\" value=\"$l_save\" class=\"btn\" /></p>

		</form>
		<!-- //New task form -->
		";
	}
} // edit task
elseif($action == "delete_task"){
	// Get task
	$task_id_mysql = quote_smart($link, $task_id);
	$query = "SELECT task_id, task_title, task_text, task_status_code_id, task_priority_id, task_created_datetime, task_created_translated,  task_created_by_user_id, task_created_by_user_alias, task_created_by_user_image, task_created_by_user_email, task_updated_datetime, task_updated_translated, task_due_datetime, task_due_time, task_due_translated, task_assigned_to_user_id, task_assigned_to_user_alias, task_assigned_to_user_image, task_assigned_to_user_email, task_qa_datetime, task_qa_by_user_id, task_qa_by_user_alias, task_qa_by_user_image, task_qa_by_user_email, task_finished_datetime, task_finished_by_user_id, task_finished_by_user_alias, task_finished_by_user_image, task_finished_by_user_email, task_is_archived, task_comments, task_project_id, task_project_part_id, task_system_id, task_system_part_id FROM $t_tasks_index WHERE task_id=$task_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_task_id, $get_current_task_title, $get_current_task_text, $get_current_task_status_code_id, $get_current_task_priority_id, $get_current_task_created_datetime, $get_current_task_created_translated, $get_current_task_created_by_user_id, $get_current_task_created_by_user_alias, $get_current_task_created_by_user_image, $get_current_task_created_by_user_email, $get_current_task_updated_datetime, $get_current_task_updated_translated, $get_current_task_due_datetime, $get_current_task_due_time, $get_current_task_due_translated, $get_current_task_assigned_to_user_id, $get_current_task_assigned_to_user_alias, $get_current_task_assigned_to_user_image, $get_current_task_assigned_to_user_email, $get_current_task_qa_datetime, $get_current_task_qa_by_user_id, $get_current_task_qa_by_user_alias, $get_current_task_qa_by_user_image, $get_current_task_qa_by_user_email, $get_current_task_finished_datetime, $get_current_task_finished_by_user_id, $get_current_task_finished_by_user_alias, $get_current_task_finished_by_user_image, $get_current_task_finished_by_user_email, $get_current_task_is_archived, $get_current_task_comments, $get_current_task_project_id, $get_current_task_project_part_id, $get_current_task_system_id, $get_current_task_system_part_id) = $row;
	if($get_current_task_id == ""){
		echo"<p>Server error 404</p>";
	}
	else{	if($process == 1){

		

			// Delete
			$result = mysqli_query($link, "DELETE FROM $t_tasks_index WHERE task_id=$get_current_task_id") or die(mysqli_error($link));

			// Delete read
			$result = mysqli_query($link, "DELETE FROM $t_tasks_read WHERE read_task_id='$get_current_task_id'");

			// Update status code with -1
			$query = "SELECT status_code_id, status_code_count_tasks FROM $t_tasks_status_codes WHERE status_code_id=$get_current_task_status_code_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_status_code_id, $get_status_code_count_tasks) = $row;
			$inp_status_code_count_tasks = $get_status_code_count_tasks-1;
			$result = mysqli_query($link, "UPDATE $t_tasks_status_codes SET status_code_count_tasks='$inp_status_code_count_tasks' WHERE status_code_id=$get_current_task_status_code_id");


			header("Location: index.php?open=dashboard&page=tasks&status_code_id=$get_current_task_status_code_id&ft=success&fm=task_deleted");
			exit;
		}
		echo"
		<h1>$get_current_task_title</h1>
		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=$open&amp;page=tasks&amp;l=$l\">Tasks</a>
			";

			// Status
			$query = "SELECT status_code_id, status_code_title FROM $t_tasks_status_codes WHERE status_code_id=$get_current_task_status_code_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_status_code_id, $get_status_code_title) = $row;
			echo"
			&gt;
			<a href=\"index.php?open=$open&amp;page=$page&amp;status_code_id=$get_status_code_id&amp;l=$l\">$get_status_code_title</a>
			&gt;
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=open_task&amp;task_id=$get_current_task_id&amp;l=$l\">$get_current_task_title</a>
			&gt;
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=delete_task&amp;task_id=$get_current_task_id&amp;l=$l\">Delete</a>
			</p>
		<!-- //Where am I? -->

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


		
		<!-- Delete task form -->
			<p>
			Are you sure you want to delete the task?
			</p>

			<p>
			<a href=\"index.php?open=dashboard&amp;page=$page&amp;action=$action&amp;task_id=$get_current_task_id&amp;l=$l&amp;process=1\" class=\"btn_danger\">Delete</a>
			</p>
		<!-- //Delete task form -->
		";
	}
} // delete task
elseif($action == "archive_task"){
	// Get task
	$task_id_mysql = quote_smart($link, $task_id);
	$query = "SELECT task_id, task_title, task_text, task_status_code_id, task_priority_id, task_created_datetime, task_created_translated,  task_created_by_user_id, task_created_by_user_alias, task_created_by_user_image, task_created_by_user_email, task_updated_datetime, task_updated_translated, task_due_datetime, task_due_time, task_due_translated, task_assigned_to_user_id, task_assigned_to_user_alias, task_assigned_to_user_image, task_assigned_to_user_email, task_qa_datetime, task_qa_by_user_id, task_qa_by_user_alias, task_qa_by_user_image, task_qa_by_user_email, task_finished_datetime, task_finished_by_user_id, task_finished_by_user_alias, task_finished_by_user_image, task_finished_by_user_email, task_is_archived, task_comments, task_project_id, task_project_part_id, task_system_id, task_system_part_id FROM $t_tasks_index WHERE task_id=$task_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_task_id, $get_current_task_title, $get_current_task_text, $get_current_task_status_code_id, $get_current_task_priority_id, $get_current_task_created_datetime, $get_current_task_created_translated, $get_current_task_created_by_user_id, $get_current_task_created_by_user_alias, $get_current_task_created_by_user_image, $get_current_task_created_by_user_email, $get_current_task_updated_datetime, $get_current_task_updated_translated, $get_current_task_due_datetime, $get_current_task_due_time, $get_current_task_due_translated, $get_current_task_assigned_to_user_id, $get_current_task_assigned_to_user_alias, $get_current_task_assigned_to_user_image, $get_current_task_assigned_to_user_email, $get_current_task_qa_datetime, $get_current_task_qa_by_user_id, $get_current_task_qa_by_user_alias, $get_current_task_qa_by_user_image, $get_current_task_qa_by_user_email, $get_current_task_finished_datetime, $get_current_task_finished_by_user_id, $get_current_task_finished_by_user_alias, $get_current_task_finished_by_user_image, $get_current_task_finished_by_user_email, $get_current_task_is_archived, $get_current_task_comments, $get_current_task_project_id, $get_current_task_project_part_id, $get_current_task_system_id, $get_current_task_system_part_id) = $row;
	if($get_current_task_id == ""){
		echo"<p>Server error 404</p>";
	}
	else{	if($process == 1){

		

			// Delete
			$result = mysqli_query($link, "UPDATE $t_tasks_index SET task_is_archived='1' WHERE task_id=$get_current_task_id") or die(mysqli_error($link));

			// Update status code with -1
			$query = "SELECT status_code_id, status_code_count_tasks FROM $t_tasks_status_codes WHERE status_code_id=$get_current_task_status_code_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_status_code_id, $get_status_code_count_tasks) = $row;
			$inp_status_code_count_tasks = $get_status_code_count_tasks-1;
			$result = mysqli_query($link, "UPDATE $t_tasks_status_codes SET status_code_count_tasks='$inp_status_code_count_tasks' WHERE status_code_id=$get_current_task_status_code_id");


			header("Location: index.php?open=dashboard&page=tasks&status_code_id=$get_current_task_status_code_id&ft=success&fm=task_archived");
			exit;
		}
		echo"
		<h1>$get_current_task_title</h1>
		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=$open&amp;page=tasks&amp;l=$l\">Tasks</a>
			";

			// Status
			$query = "SELECT status_code_id, status_code_title FROM $t_tasks_status_codes WHERE status_code_id=$get_current_task_status_code_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_status_code_id, $get_status_code_title) = $row;
			echo"
			&gt;
			<a href=\"index.php?open=$open&amp;page=$page&amp;status_code_id=$get_status_code_id&amp;l=$l\">$get_status_code_title</a>
			&gt;
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=open_task&amp;task_id=$get_current_task_id&amp;l=$l\">$get_current_task_title</a>
			&gt;
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=delete_task&amp;task_id=$get_current_task_id&amp;l=$l\">Delete</a>
			</p>
		<!-- //Where am I? -->

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


		
		<!-- Archive task form -->
			<p>
			Are you sure you want to archive the task?
			</p>

			<p>
			<a href=\"index.php?open=dashboard&amp;page=$page&amp;action=$action&amp;task_id=$get_current_task_id&amp;l=$l&amp;process=1\" class=\"btn_success\">Archive</a>
			</p>
		<!-- //Archive task form -->
		";
	}
} // archive_task
?>