<?php
/**
*
* File: _admin/_inc/tasks_subscriptions.php
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
$t_tasks_status_codes  			= $mysqlPrefixSav . "tasks_status_codes";
$t_tasks_projects  			= $mysqlPrefixSav . "tasks_projects";
$t_tasks_projects_parts  		= $mysqlPrefixSav . "tasks_projects_parts";
$t_tasks_systems  			= $mysqlPrefixSav . "tasks_systems";
$t_tasks_systems_parts  		= $mysqlPrefixSav . "tasks_systems_parts";
$t_tasks_read				= $mysqlPrefixSav . "tasks_read";
$t_tasks_subscriptions_to_new_tasks 	= $mysqlPrefixSav . "tasks_subscriptions_to_new_tasks";



/*- Variables  ---------------------------------------------------- */
$tabindex = 0;


if($action == ""){
	if($process == 1){

		$inp_subscribe_to_new_tasks = $_POST['inp_subscribe_to_new_tasks'];
		$inp_subscribe_to_new_tasks = output_html($inp_subscribe_to_new_tasks);
		$inp_subscribe_to_new_tasks_mysql = quote_smart($link, $inp_subscribe_to_new_tasks);

		$my_user_id = $_SESSION['user_id'];
		$my_user_id = output_html($my_user_id);
		$my_user_id_mysql = quote_smart($link, $my_user_id);

		$query = "SELECT user_id, user_email, user_name, user_alias, user_rank FROM $t_users WHERE user_id=$my_user_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_my_user_id, $get_my_user_email, $get_my_user_name, $get_my_user_alias, $get_my_user_rank) = $row;

		// Check if exists
		$query = "SELECT subscription_id FROM $t_tasks_subscriptions_to_new_tasks WHERE subscription_user_id=$my_user_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_subscription_id) = $row;
		if($get_current_subscription_id == ""){
			if($inp_subscribe_to_new_tasks == "1"){
				// Insert
				$inp_my_user_email_mysql = quote_smart($link, $get_my_user_email);
				mysqli_query($link, "INSERT INTO $t_tasks_subscriptions_to_new_tasks 
				(subscription_id, subscription_user_id, subscription_user_email) 
				VALUES 
				(NULL, $get_my_user_id, $inp_my_user_email_mysql)")
				or die(mysqli_error($link));

			}
			

		
		}
		elseif($get_current_subscription_id != ""){
			if($inp_subscribe_to_new_tasks == "0"){
				// Delete
				$result = mysqli_query($link, "DELETE FROM $t_tasks_subscriptions_to_new_tasks WHERE subscription_user_id=$my_user_id_mysql") or die(mysqli_error($link));
			}
		}



		header("Location: index.php?open=dashboard&page=$page&ft=success&fm=changes_saved");
		exit;
	}

	// Get subscription status
	$my_user_id = $_SESSION['user_id'];
	$my_user_id = output_html($my_user_id);
	$my_user_id_mysql = quote_smart($link, $my_user_id);

	$query = "SELECT subscription_id FROM $t_tasks_subscriptions_to_new_tasks WHERE subscription_user_id=$my_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_subscription_id) = $row;


	echo"
	<h1>Tasks projects</h1>

	<!-- Where am I? -->
		<p><b>You are here:</b><br />
		<a href=\"index.php?open=$open&amp;page=tasks&amp;l=$l\">Tasks</a>
		&gt;
		<a href=\"index.php?open=$open&amp;page=$page&amp;l=$l\">Subscriptions</a>
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

	<!-- Subscription form -->
		<script>
		\$(document).ready(function(){
			\$('[name=\"inp_subscribe_to_new_tasks\"]').focus();
		});
		</script>
		<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
		<p>Subscribe to new tasks:<br />
		<input type=\"radio\" name=\"inp_subscribe_to_new_tasks\" value=\"1\""; if($get_current_subscription_id != ""){ echo" checked=\"checked\""; } echo"  /> Yes
		&nbsp;
		<input type=\"radio\" name=\"inp_subscribe_to_new_tasks\" value=\"0\""; if($get_current_subscription_id == ""){ echo" checked=\"checked\""; } echo"  /> No
		</p>


		<p><input type=\"submit\" value=\"Create project\" class=\"btn_default\" /></p>

		</form>
	<!-- //Subscription form -->
	";
}
?>