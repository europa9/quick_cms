<?php
/**
*
* File: _admin/_inc/references/open_guide.php
* Version 
* Date 13:50 03.04.2021
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
$t_references_title_translations  = $mysqlPrefixSav . "references_title_translations";
$t_references_categories_main	  = $mysqlPrefixSav . "references_categories_main";
$t_references_categories_sub 	  = $mysqlPrefixSav . "references_categories_sub";
$t_references_index		  = $mysqlPrefixSav . "references_index";
$t_references_index_groups	  = $mysqlPrefixSav . "references_index_groups";
$t_references_index_guides	  = $mysqlPrefixSav . "references_index_guides";
$t_references_index_guides_images = $mysqlPrefixSav . "references_index_guides_images";

/*- Tables search --------------------------------------------------------------------- */
$t_search_engine_index 		= $mysqlPrefixSav . "search_engine_index";
$t_search_engine_access_control = $mysqlPrefixSav . "search_engine_access_control";

/*- Variables ------------------------------------------------------------------------ */
$tabindex = 0;
if(isset($_GET['guide_id'])){
	$guide_id = $_GET['guide_id'];
	$guide_id = strip_tags(stripslashes($guide_id));
	if(!(is_numeric($guide_id))){
		echo"guide_id not numeric";
		die;
	}
}
else{
	$guide_id = "";
}
$guide_id_mysql = quote_smart($link, $guide_id);


$query = "SELECT guide_id, guide_number, guide_title, guide_title_clean, guide_title_short, guide_title_length, guide_short_description, guide_content, guide_group_id, guide_group_title, guide_reference_id, guide_reference_title, guide_read_times, guide_read_ipblock, guide_created, guide_updated, guide_updated_formatted, guide_last_read, guide_last_read_formatted, guide_comments FROM $t_references_index_guides WHERE guide_id=$guide_id_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_current_guide_id, $get_current_guide_number, $get_current_guide_title, $get_current_guide_title_clean, $get_current_guide_title_short, $get_current_guide_title_length, $get_current_guide_short_description, $get_current_guide_content, $get_current_guide_group_id, $get_current_guide_group_title, $get_current_guide_reference_id, $get_current_guide_reference_title, $get_current_guide_read_times, $get_current_guide_read_ipblock, $get_current_guide_created, $get_current_guide_updated, $get_current_guide_updated_formatted, $get_current_guide_last_read, $get_current_guide_last_read_formatted, $get_current_guide_comments) = $row;

if($get_current_guide_id == ""){
	echo"<p>Server error 404.</p>";
}
else{
	// Reference
	$query = "SELECT reference_id, reference_title, reference_title_clean, reference_is_active, reference_front_page_intro, reference_description, reference_language, reference_main_category_id, reference_main_category_title, reference_sub_category_id, reference_sub_category_title, reference_image_file, reference_image_thumb, reference_icon_16, reference_icon_32, reference_icon_48, reference_icon_64, reference_icon_96, reference_icon_260, reference_groups_count, reference_guides_count, reference_read_times, reference_read_times_ip_block, reference_created, reference_updated FROM $t_references_index WHERE reference_id=$get_current_guide_reference_id";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_reference_id, $get_current_reference_title, $get_current_reference_title_clean, $get_current_reference_is_active, $get_current_reference_front_page_intro, $get_current_reference_description, $get_current_reference_language, $get_current_reference_main_category_id, $get_current_reference_main_category_title, $get_current_reference_sub_category_id, $get_current_reference_sub_category_title, $get_current_reference_image_file, $get_current_reference_image_thumb, $get_current_reference_icon_16, $get_current_reference_icon_32, $get_current_reference_icon_48, $get_current_reference_icon_64, $get_current_reference_icon_96, $get_current_reference_icon_260, $get_current_reference_groups_count, $get_current_reference_guides_count, $get_current_reference_read_times, $get_current_reference_read_times_ip_block, $get_current_reference_created, $get_current_reference_updated) = $row;


	// Find group
	$query = "SELECT group_id, group_title, group_title_clean, group_title_short, group_title_length, group_number, group_content, group_reference_id, group_reference_title, group_read_times, group_read_times_ip_block, group_created_datetime, group_updated_datetime, group_updated_formatted, group_last_read, group_last_read_formatted FROM $t_references_index_groups WHERE group_id=$get_current_guide_group_id";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_group_id, $get_current_group_title, $get_current_group_title_clean, $get_current_group_title_short, $get_current_group_title_length, $get_current_group_number, $get_current_group_content, $get_current_group_reference_id, $get_current_group_reference_title, $get_current_group_read_times, $get_current_group_read_times_ip_block, $get_current_group_created_datetime, $get_current_group_updated_datetime, $get_current_group_updated_formatted, $get_current_group_last_read, $get_current_group_last_read_formatted) = $row;

	// Find category
	$query = "SELECT main_category_id, main_category_title, main_category_title_clean, main_category_description, main_category_language, main_category_created, main_category_updated FROM $t_references_categories_main WHERE main_category_id=$get_current_reference_main_category_id";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_main_category_id, $get_current_main_category_title, $get_current_main_category_title_clean, $get_current_main_category_description, $get_current_main_category_language, $get_current_main_category_created, $get_current_main_category_updated) = $row;

	$query = "SELECT sub_category_id, sub_category_title, sub_category_title_clean, sub_category_description, sub_category_main_category_id, sub_category_main_category_title, sub_category_language, sub_category_created, sub_category_updated FROM $t_references_categories_sub WHERE sub_category_id=$get_current_reference_sub_category_id";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_sub_category_id, $get_current_sub_category_title, $get_current_sub_category_title_clean, $get_current_sub_category_description, $get_current_sub_category_main_category_id, $get_current_sub_category_main_category_title, $get_current_sub_category_language, $get_current_sub_category_created, $get_current_sub_category_updated) = $row;

	if($process == "1"){

		$inp_title = $_POST['inp_title'];
		$inp_title = output_html($inp_title);
		$inp_title_mysql = quote_smart($link, $inp_title);

		$inp_title_clean = clean($inp_title);
		$inp_title_clean_mysql = quote_smart($link, $inp_title_clean);

		$inp_title_length = strlen($inp_title);
		$inp_title_length_mysql = quote_smart($link, $inp_title_length);

		if($inp_title_length  > 27){
			$inp_title_short = substr($inp_title, 0, 27);
			$inp_title_short = $inp_title_short . "...";
		}
		else{
			$inp_title_short = "";
		}
		$inp_title_short_mysql = quote_smart($link, $inp_title_short);

		$inp_short_description = $_POST['inp_short_description'];
		$inp_short_description = output_html($inp_short_description);
		$inp_short_description_mysql = quote_smart($link, $inp_short_description);

		$inp_reference_title_mysql = quote_smart($link, $get_current_reference_title);
		$inp_group_title_mysql = quote_smart($link, $get_current_group_title);

		$datetime = date("Y-m-d H:i:s");
		$datetime_saying = date("j M Y H:i");

		$result = mysqli_query($link, "UPDATE $t_references_index_guides SET 
								guide_title=$inp_title_mysql, 
								guide_title_clean=$inp_title_clean_mysql,
								guide_title_short=$inp_title_short_mysql,
								guide_title_length=$inp_title_length_mysql,
								guide_short_description=$inp_short_description_mysql,
								guide_group_title=$inp_group_title_mysql,
								guide_reference_title=$inp_reference_title_mysql,
								guide_updated='$datetime'
								WHERE guide_id=$get_current_guide_id") or die(mysqli_error($link));

		// Text
		$inp_content = $_POST['inp_content'];
		$sql = "UPDATE $t_references_index_guides SET guide_content=? WHERE guide_id=$get_current_guide_id";
		$stmt = $link->prepare($sql);
		$stmt->bind_param("s", $inp_content);
		$stmt->execute();
		if ($stmt->errno) {
			echo "FAILURE!!! " . $stmt->error; die;
		}



		// Search engine
		include("_translations/site/$get_current_reference_language/references/ts_references.php");

		$inp_index_title = "$inp_title |  $get_current_group_title | $get_current_reference_title | $l_references";
		$inp_index_title_mysql = quote_smart($link, $inp_index_title);

		$inp_index_url = "$get_current_reference_title_clean/$get_current_group_title_clean/$inp_title_clean.php?reference_id=$get_current_reference_id&group_id=$get_current_group_id&guide_id=$get_current_guide_id";
		$inp_index_url_mysql = quote_smart($link, $inp_index_url);

		$query_exists = "SELECT index_id FROM $t_search_engine_index WHERE index_module_name='references' AND index_reference_name='guide_id' AND index_reference_id=$get_current_guide_id";
		$result_exists = mysqli_query($link, $query_exists);
		$row_exists = mysqli_fetch_row($result_exists);
		list($get_index_id) = $row_exists;

		$result = mysqli_query($link, "UPDATE $t_search_engine_index SET 
								index_title=$inp_index_title_mysql,
								index_url=$inp_index_url_mysql,
								index_short_description=$inp_short_description_mysql,
								index_updated_datetime='$datetime',
								index_updated_datetime_print='$datetime_saying'
							WHERE index_id=$get_index_id") or die(mysqli_error($link));
			

		// Mkdir
		if(!(is_dir("../$get_current_reference_title_clean"))){
			mkdir("../$get_current_reference_title_clean");
		}
		if(!(is_dir("../$get_current_reference_title_clean/$get_current_group_title_clean"))){
			mkdir("../$get_current_reference_title_clean/$get_current_group_title_clean");
		}

		// Make file
		$input="<?php
/*- Configuration ---------------------------------------------------------------------------- */
\$layoutNumberOfColumn = \"2\";
\$layoutCommentsActive = \"1\";

/*- Header ----------------------------------------------------------- */
\$website_title = \"$get_current_reference_title - $get_current_group_title - $inp_title\";
if(file_exists(\"./favicon.ico\")){ \$root = \".\"; }
elseif(file_exists(\"../favicon.ico\")){ \$root = \"..\"; }
elseif(file_exists(\"../../favicon.ico\")){ \$root = \"../..\"; }
elseif(file_exists(\"../../../favicon.ico\")){ \$root = \"../../..\"; }
include(\"\$root/_webdesign/header.php\");

/*- Content ---------------------------------------------------------- */
?>

$inp_content

<?php
/*- After references ------------------------------------------------------------------------- */
include(\"\$root/references/_includes/after_guide.php\");

/*- Footer ----------------------------------------------------------- */
include(\"\$root/_webdesign/\$webdesignSav/footer.php\");
?>";
		$fh = fopen("../$get_current_reference_title_clean/$get_current_group_title_clean/$inp_title_clean.php", "w+") or die("can not open file");
		fwrite($fh, $input);
		fclose($fh);
		


		$url = "index.php?open=$open&page=$page&guide_id=$get_current_guide_id&editor_language=$editor_language&ft=success&fm=changes_saved";
		header("Location: $url");
		exit;
	} // process == 1

	echo"
	<h1>$get_current_guide_title</h1>
				

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

	<!-- Where am I? -->
		<p><b>You are here:</b><br />
		<a href=\"index.php?open=references&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">References</a>
		&gt;
		<a href=\"index.php?open=references&amp;page=default&amp;editor_language=$editor_language&amp;l=$l\">References index</a>
		&gt;
		<a href=\"index.php?open=references&amp;page=open_main_category&amp;main_category_id=$get_current_reference_main_category_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_reference_main_category_title</a>
		&gt;
		<a href=\"index.php?open=references&amp;page=open_sub_category&amp;sub_category_id=$get_current_reference_sub_category_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_reference_sub_category_title</a>
		&gt;
		<a href=\"index.php?open=references&amp;page=reference_open&amp;reference_id=$get_current_reference_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_reference_title</a>
		&gt;
		<a href=\"index.php?open=references&amp;page=reference_groups_and_guides&amp;reference_id=$get_current_reference_id&amp;editor_language=$editor_language&amp;l=$l\">Groups and guides</a>
		&gt;
		<a href=\"index.php?open=references&amp;page=open_group&amp;group_id=$get_current_group_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_group_title</a>
		&gt;
		<a href=\"index.php?open=references&amp;page=open_guide&amp;guide_id=$get_current_guide_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_guide_title</a>
		</p>
	<!-- //Where am I? -->
	
	<!-- Open guide form -->
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
					image_list: [";
					$x = 0;
					$query_i = "SELECT image_id, image_title, image_path, image_file FROM $t_references_index_guides_images WHERE image_guide_id=$get_current_guide_id ORDER BY image_title ASC";
					$result_i = mysqli_query($link, $query_i);
					while($row_i = mysqli_fetch_row($result_i)) {
						list($get_image_id, $get_image_title, $get_image_path, $get_image_file) = $row_i;
						if($x > 0){
							echo",";
						}
						echo"
						{ title: '$get_image_title', value: '../$get_image_path/$get_image_file' }";
						$x++;
					}

					echo"
					],
						image_class_list: [
						{ title: 'None', value: '' },
						{ title: 'Some class', value: 'class-name' }
					],
					importcss_append: true,
					height: 500,
					/* without images_upload_url set, Upload tab won't show up*/
					images_upload_url: 'index.php?open=$open&page=open_guide_upload_image&guide_id=$get_current_guide_id&process=1',
				});
			</script>
		<!-- //TinyMCE -->
		<script>
		\$(document).ready(function(){
			\$('[name=\"inp_title\"]').focus();
		});
		</script>

		<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;guide_id=$get_current_guide_id&amp;editor_language=$editor_language&amp;process=1\" enctype=\"multipart/form-data\">
		
		<p><b>Title:</b><br />
		<input type=\"text\" name=\"inp_title\" value=\"$get_current_guide_title\" size=\"25\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" style=\"width: 90%;\" />
		</p>

		<p><b>Short description:</b><br />
		<input type=\"text\" name=\"inp_short_description\" value=\"$get_current_guide_short_description\" size=\"45\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" style=\"width: 90%;\" />
		</p>

		<p>
		<textarea name=\"inp_content\" rows=\"40\" cols=\"120\" class=\"editor\">$get_current_guide_content</textarea>
		</p>

		<p>
		<input type=\"submit\" value=\"Save lesson\" class=\"btn_default\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
		</p>

	<!-- //Open guide form -->
	";
} // found
?>