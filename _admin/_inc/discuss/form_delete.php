<?php
/**
*
* File: _admin/_inc/discuss/form_delete.php
* Version 1
* Date 10:34 03.03.2018
* Copyright (c) 2008-2018 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}


/*- Functions ----------------------------------------------------------------------- */


/*- Variables ------------------------------------------------------------------------ */
if(isset($_GET['form_id'])){
	$form_id = $_GET['form_id'];
	$form_id = output_html($form_id);
}
else{
	$form_id = "";
}
$tabindex = 0;


// Get form
$form_id_mysql = quote_smart($link, $form_id);
$query = "SELECT form_id, form_title, form_language, form_introduction, form_tags, form_created, form_updated FROM $t_discuss_forms WHERE form_id=$form_id_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_current_form_id, $get_current_form_title, $get_current_form_language, $get_current_form_introduction, $get_current_form_tags, $get_current_form_created, $get_current_form_updated) = $row;

if($get_current_form_id == ""){
	echo"
	<h1>Error</h1>

	<p>
	Not found.
	</p>
	";

}
else{
	if($process == "1"){
		



		$result = mysqli_query($link, "DELETE FROM $t_discuss_forms WHERE form_id=$get_current_form_id");
		$result = mysqli_query($link, "DELETE FROM $t_discuss_forms_questions WHERE form_id=$get_current_form_id");


		$url = "index.php?open=$open&page=forms&editor_language=$editor_language&ft=success&fm=form_deleted";
		header("Location: $url");
		exit;
	}
	echo"
	<h1>$get_current_form_title</h1>


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
	<!-- Form -->
		<p>
		Are you sure?
		</p>


		<p>
		<a href=\"index.php?open=$open&amp;page=$page&amp;form_id=$get_current_form_id&amp;editor_language=$editor_language&amp;process=1\">Yes</a>
		</p>
	<!-- //Form -->
	";
}
?>