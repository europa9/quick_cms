<?php
/**
*
* File: _admin/_inc/notepad.php
* Version 1.0.1
* Date 11:46 28-Jul-18
* Copyright (c) 2008-2018 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}


/*- Notebook -------------------------------------------------------------------------- */
if(!(file_exists("_data/notepad_common.php"))){

	// Create file
	$datetime = date("Y-m-d H:i:s");
	$input="<?php
\$notepadUpdatedDateTimeSav = \"$datetime\";
\$notepadUpdatedUserIdSav   = \"$get_my_user_id\";
\$notepadUpdatedUserNameSav = \"$get_my_user_name\";
\$notepadNotesSav = \"\";
?>";

	$fh = fopen("_data/notepad_common.php", "w+") or die("can not open file");
	fwrite($fh, $input);
	fclose($fh);
}



if($action == ""){
	echo"
	<h1>Notepad</h1>

	<!-- Menu -->
		<div class=\"tabs\">
			<ul>
				<li><a href=\"index.php?open=dashboard&amp;page=notepad&amp;l=$l\" class=\"active\">Notepad</a></li>
				<li><a href=\"index.php?open=dashboard&amp;page=notepad&amp;action=edit&amp;l=$l\">Edit</a></li>
			</ul>
		</div>
		<div class=\"clear\"></div>
	<!-- Menu -->

	";

		include("_data/notepad_common.php");
	
	echo"
	$notepadNotesSav
	";
}
elseif($action == "edit"){
	if($process == 1){

		$inp_notes = $_POST['inp_notes'];
		$inp_notes = addslashes($inp_notes);


		// Create file
		$datetime = date("Y-m-d H:i:s");
		$input="<?php
\$notepadUpdatedDateTimeSav = \"$datetime\";
\$notepadUpdatedUserIdSav   = \"$get_my_user_id\";
\$notepadUpdatedUserNameSav = \"$get_my_user_name\";
\$notepadNotesSav = \"$inp_notes\";
?>";
	
		$fh = fopen("_data/notepad_common.php", "w+") or die("can not open file");
		fwrite($fh, $input);
		fclose($fh);

		header("Location: index.php?open=dashboard&page=notepad&action=edit&ft=success&fm=changes_saved");
		exit;
	}
	$tabindex = 0;
	echo"
	<h2>Edit</h2>

	<!-- Menu -->
		<div class=\"tabs\">
			<ul>
				<li><a href=\"index.php?open=dashboard&amp;page=notepad&amp;l=$l\">Notepad</a></li>
				<li><a href=\"index.php?open=dashboard&amp;page=notepad&amp;action=edit&amp;l=$l\" class=\"active\">Edit</a></li>
			</ul>
		</div>
		<div class=\"clear\"></div>
	<!-- Menu -->

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
		\$('[name=\"inp_notes\"]').focus();
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
						'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
						'//www.tiny.cloud/css/codepen.min.css'
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

	<!-- Edit notebook form -->";
		include("_data/notepad_common.php");
		
		echo"
		<form method=\"post\" action=\"index.php?open=dashboard&amp;page=notepad&amp;action=edit&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
			<h2>Notes</h2>
			<p style=\"padding:0;margin:0;\">
			<textarea name=\"inp_notes\" rows=\"10\" cols=\"80\" class=\"editor\">$notepadNotesSav</textarea><br />
			</p>

			<p style=\"padding: 5px 0px 0px 0px;margin:0;\"><input type=\"submit\" value=\"$l_save\" class=\"btn\" /></p>

		</form>
	<!-- //Edit notebook form -->

	";
} // edit

?>