<?php
/**
*
* File: _admin/_inc/contact_forms/tables.php
* Version 00.28 20.03.2017
* Copyright (c) 2008-2017 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}
/*- Tables ---------------------------------------------------------------------------- */
$t_contact_forms_index			= $mysqlPrefixSav . "contact_forms_index";
$t_contact_forms_images			= $mysqlPrefixSav . "contact_forms_images";
$t_contact_forms_questions		= $mysqlPrefixSav . "contact_forms_questions";
$t_contact_forms_questions_alternatives	= $mysqlPrefixSav . "contact_forms_questions_alternatives";
$t_contact_forms_auto_replies		= $mysqlPrefixSav . "contact_forms_auto_replies";
$t_contact_forms_messages_index		= $mysqlPrefixSav . "contact_forms_messages_index";
$t_contact_forms_messages_answers	= $mysqlPrefixSav . "contact_forms_messages_answers";

echo"
<h1>Tables</h1>


	<!-- contact_forms_index -->
	";
	
	$query = "SELECT * FROM $t_contact_forms_index";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_contact_forms_index: $row_cnt</p>
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

		
		<meta http-equiv=\"refresh\" content=\"2;url=index.php?open=$open&amp;page=$page\">
		";


		mysqli_query($link, "CREATE TABLE $t_contact_forms_index(
	  	 form_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(form_id), 
	  	   form_title VARCHAR(250),
	  	   form_language VARCHAR(50),
	  	   form_mail_to TEXT,
	  	   form_text_before_form TEXT,
	  	   form_text_left_of_form TEXT,
	  	   form_text_right_of_form TEXT,
	  	   form_text_after_form TEXT,
	  	   form_first_field_name VARCHAR(250),
	  	   form_created_datetime DATETIME,
	  	   form_created_by_user_id INT,
	  	   form_updated_datetime DATETIME,
	  	   form_updated_by_user_id INT,
	  	   form_api_avaible INT,
	  	   form_api_password VARCHAR(250),
	  	   form_ipblock TEXT,
	  	   form_used_times INT)")
		   or die(mysqli_error());

		// Me
		$my_user_id = $_SESSION['admin_user_id'];
		$my_user_id = output_html($my_user_id);
		$my_user_id_mysql = quote_smart($link, $my_user_id);

		$query = "SELECT user_id, user_email, user_name, user_language, user_last_online, user_rank, user_login_tries FROM $t_users WHERE user_id=$my_user_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_my_user_id, $get_my_user_email, $get_my_user_name, $get_my_user_language, $get_my_user_last_online, $get_my_user_rank, $get_my_user_login_tries) = $row;

		$inp_my_email_mysql = quote_smart($link, $get_my_user_email);

		$datetime = date("Y-m-d H:i:s");

		// Random password
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    		$charactersLength = strlen($characters);
    		$randa = '';
    		$randb = '';
    		$randc = '';
    		$randd = '';
    		for ($i = 0; $i < 6; $i++) {
        		$randa .= $characters[rand(0, $charactersLength - 1)];
        		$randb .= $characters[rand(0, $charactersLength - 1)];
        		$randc .= $characters[rand(0, $charactersLength - 1)];
        		$randd .= $characters[rand(0, $charactersLength - 1)];
    		}
		$randa_mysql = quote_smart($link, $randa);
		$randb_mysql = quote_smart($link, $randb);
		$randc_mysql = quote_smart($link, $randc);
		$randd_mysql = quote_smart($link, $randd);

		mysqli_query($link, "INSERT INTO $t_contact_forms_index 
		(form_id, form_title, form_language, form_mail_to, form_text_before_form, form_text_left_of_form, form_text_right_of_form, form_text_after_form, form_first_field_name, form_created_datetime, form_created_by_user_id, form_updated_datetime, form_updated_by_user_id, form_api_avaible, form_api_password, form_ipblock, form_used_times) 
		VALUES
		(NULL, 'Contact form', 'en', $inp_my_email_mysql, '<h1>Contact form</h1><p>Please feel free to contact us by filling in this form.</p>', '', '', '', 'inp_q_name', '$datetime', 1, '$datetime', 1, 1, $randa_mysql, '', 0),
		(NULL, 'Kontaktskjema', 'no', $inp_my_email_mysql, '<h1>Kontaktskjema</h1><p>Kontakt oss ved å fylle inn skjemaet under.</p>', '', '', '', 'inp_q_name', '$datetime', 1, '$datetime', 1, 1, $randb_mysql, '', 0),
		(NULL, 'App feedback', 'en', $inp_my_email_mysql, '<h1>App feedback</h1><p>Tell us what you think about our app. Email address is optional.</p>', '', '', '', 'inp_q_email', '$datetime', 1, '$datetime', 1, 1, $randc_mysql, '', 0),
		(NULL, 'App tilbakemelding', 'no', $inp_my_email_mysql, '<h1>App tilbakemelding</h1><p>Fortell oss hva du synes om appen vår ved å fylle inn skjemaet under. E-post adresse er valgfritt.</p>', '', '', '', 'inp_q_email', '$datetime', 1, '$datetime', 1, 1, $randd_mysql, '', 0)
		") or die(mysqli_error());
	}


	echo"
	<!-- //contact_forms_index -->

	<!-- $t_contact_forms_images -->
	";
	$query = "SELECT * FROM $t_contact_forms_images";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_contact_forms_images: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_contact_forms_images(
	  	 image_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(image_id), 
	  	   image_contact_form_id INT,
	  	   image_path VARCHAR(250),
	  	   image_file VARCHAR(250))")
		   or die(mysqli_error());


	}
	echo"
	<!-- //contact_forms_images -->

	<!-- $t_contact_forms_questions -->
	";
	$query = "SELECT * FROM $t_contact_forms_questions";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_contact_forms_questions: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_contact_forms_questions(
	  	 question_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(question_id), 
	  	   question_form_id INT,
	  	   question_title VARCHAR(250),
	  	   question_field_name VARCHAR(250),
	  	   question_weight INT,
	  	   question_type VARCHAR(250),
	  	   question_size INT,
	  	   question_rows INT,
	  	   question_cols INT,
	  	   question_required INT,
	  	   question_answer VARCHAR(250))")
		   or die(mysqli_error());

		mysqli_query($link, "INSERT INTO $t_contact_forms_questions (`question_id`, `question_form_id`, `question_title`, `question_field_name`, `question_weight`, `question_type`, `question_size`, `question_rows`, `question_cols`, `question_required`, `question_answer`) 
		VALUES
		(NULL, 1, 'Name', 'name', 0, 'text', 25, 8, 40, 1, ''),
		(NULL, 1, 'E-mail', 'email', 1, 'text', 25, 8, 40, 1, ''),
		(NULL, 1, 'Website', 'website', 2, 'text', 25, 8, 40, 0, ''),
		(NULL, 1, 'Message', 'message', 3, 'textarea', 25, 8, 40, 1, ''),
		(NULL, 2, 'Navn', 'name', 0, 'text', 25, 8, 40, 1, ''),
		(NULL, 2, 'E-post', 'email', 1, 'text', 25, 8, 40, 1, ''),
		(NULL, 2, 'Webside', 'webside', 2, 'text', 25, 8, 40, 0, ''),
		(NULL, 2, 'Beskjed', 'message', 3, 'textarea', 25, 8, 40, 1, ''),
		(NULL, 3, 'E-mail', 'email', 1, 'text', 25, 8, 40, 1, ''),
		(NULL, 3, 'Message', 'message', 3, 'textarea', 25, 8, 40, 1, ''),
		(NULL, 4, 'E-post', 'email', 1, 'text', 25, 8, 40, 1, ''),
		(NULL, 4, 'Beskjed', 'message', 3, 'textarea', 25, 8, 40, 1, '')")
		   or die(mysqli_error());

	}
	echo"
	<!-- //contact_forms_questions -->


	<!-- contact_forms_questions_alternatives -->
	";
	$query = "SELECT * FROM $t_contact_forms_questions_alternatives";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_contact_forms_questions_alternatives: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_contact_forms_questions_alternatives(
	  	 alternative_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(alternative_id), 
	  	   form_id INT,
	  	   question_id INT,
	  	   alternative_title VARCHAR(250),
	  	   alternative_preselected INT)")
		   or die(mysqli_error());


	}
	echo"
	<!-- //contact_forms_questions_alternatives -->



	<!-- contact_forms_auto_replies -->
	";
	$query = "SELECT * FROM $t_contact_forms_auto_replies";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_contact_forms_auto_replies: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_contact_forms_auto_replies(
	  	 auto_reply_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(auto_reply_id), 
	  	   auto_reply_form_id INT,
	  	   auto_reply_from_email VARCHAR(200),
	  	   auto_reply_from_name VARCHAR(200),
	  	   auto_reply_subject VARCHAR(200),
	  	   auto_reply_text TEXT,
	  	   auto_reply_delay VARCHAR(200),
	  	   auto_reply_attachment_a VARCHAR(200),
	  	   auto_reply_attachment_b VARCHAR(200),
	  	   auto_reply_attachment_c VARCHAR(200),
	  	   auto_reply_active INT)")
		   or die(mysqli_error());
	}
	echo"
	<!-- //contact_forms_auto_replies -->



	<!-- contact_forms_messages_index -->
	";
	$query = "SELECT * FROM $t_contact_forms_messages_index";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_contact_forms_messages_index: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_contact_forms_messages_index(
	  	 message_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(message_id), 
	  	   message_form_id INT,
	  	   message_password VARCHAR(250),
	  	   message_notes TEXT,
	  	   message_source VARCHAR(250),
	  	   message_created_datetime DATETIME,
	  	   message_updated_datetime DATETIME,
	  	   message_ip VARCHAR(250),
	  	   message_hostname VARCHAR(250),
	  	   message_agent VARCHAR(250))")
		   or die(mysqli_error());
	}
	echo"
	<!-- //contact_forms_messages_index -->

	<!-- contact_forms_messages_answers -->
	";
	$query = "SELECT * FROM $t_contact_forms_messages_answers";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_contact_forms_messages_answers: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_contact_forms_messages_answers(
	  	 answer_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(answer_id), 
	  	   form_id INT,
	  	   question_id INT,
	  	   message_id INT,
	  	   qestion_answer TEXT)")
		   or die(mysqli_error());
	}
	echo"
	<!-- //contact_forms_messages_answers -->


	";
?>