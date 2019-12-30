<?php
/**
*
* File: _admin/_inc/comments/default.php
* Version 
* Date 20:17 30.10.2017
* Copyright (c) 2008-2017 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}
/*- Variables ------------------------------------------------------------------------ */
$tabindex = 0;

if(isset($_GET['where'])){
	$where = $_GET['where'];
	$where = output_html($where);
}
else {
	$where = "comment_approved != '-1'";
}

if($action == ""){
	echo"
	<h1>Courses</h1>
				

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
		<a href=\"index.php?open=courses&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Courses</a>
		&gt;
		<a href=\"index.php?open=courses&amp;page=default&amp;editor_language=$editor_language&amp;l=$l\">Categories</a>
		</p>
	<!-- //Where am I? -->

	<!-- Menu -->
		<p>
		<a href=\"index.php?open=courses&amp;page=courses_category_new&amp;editor_language=$editor_language&amp;l=$l\" class=\"btn_default\">New category</a>
		<a href=\"index.php?open=courses&amp;page=courses_category_scan&amp;amp;editor_language=$editor_language&amp;l=$l\" class=\"btn_default\">Scan for categories</a>
		<a href=\"index.php?open=courses&amp;page=courses_new&amp;editor_language=$editor_language&amp;l=$l\" class=\"btn_default\">New course</a>
		</p>
	<!-- //Menu -->

	<!-- List all categories -->
		
        	
		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\">
			<span>Title</span>
		   </th>
		   <th scope=\"col\">
			<span>Actions</span>
		   </th>
		  </tr>
		</thead>
		<tbody>
		";
	


		$editor_language_mysql = quote_smart($link, $editor_language);
		$query = "SELECT category_id, category_title, category_description, category_language, category_created, category_updated FROM $t_courses_categories ORDER BY category_title ASC";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_category_id, $get_category_title, $get_category_description, $get_category_language, $get_category_created, $get_category_updated) = $row;

			if(isset($odd) && $odd == false){
				$odd = true;
			}
			else{
				$odd = false;
			}

			echo"
			<tr>
			  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
				<a href=\"index.php?open=$open&amp;page=open_category&amp;category_id=$get_category_id&amp;editor_language=$editor_language&amp;l=$l\">$get_category_title</a>
			  </td>
			  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
				<span>
				<a href=\"index.php?open=$open&amp;page=courses_category_edit&amp;category_id=$get_category_id&amp;editor_language=$editor_language\">Edit</a>
				&middot;
				<a href=\"index.php?open=$open&amp;page=courses_category_delete&amp;category_id=$get_category_id&amp;editor_language=$editor_language\">Delete</a>
				</span>
			 </td>
			</tr>
			";
		}
		echo"
		 </tbody>
		</table>
	<!-- //List all categories -->
	";
}
?>