<?php
/**
*
* File: exercises/index.php
* Version 1.0.0.
* Date 19:42 08.02.2018
* Copyright (c) 2008-2018 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Configuration --------------------------------------------------------------------- */
$pageIdSav            = "2";
$pageNoColumnSav      = "2";
$pageAllowCommentsSav = "0";

/*- Root dir -------------------------------------------------------------------------- */
// This determine where we are
if(file_exists("favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
elseif(file_exists("../../../../favicon.ico")){ $root = "../../../.."; }
else{ $root = "../../.."; }

/*- Website config -------------------------------------------------------------------- */
include("$root/_admin/website_config.php");


/*- Variables ------------------------------------------------------------------------- */
$l_mysql = quote_smart($link, $l);


if(isset($_GET['order_by'])) {
	$order_by = $_GET['order_by'];
	$order_by = strip_tags(stripslashes($order_by));
}
else{
	$order_by = "";
}
if(isset($_GET['order_method'])) {
	$order_method = $_GET['order_method'];
	$order_method = strip_tags(stripslashes($order_method));
}
else{
	$order_method = "";
}


/*- Language ------------------------------------------------------------------------ */
include("../_admin/_translations/site/$l/exercises/ts_exercises.php");


/*- Query --------------------------------------------------------------------------- */
if(isset($_GET['q']) OR isset($_POST['q'])){
	if(isset($_GET['q'])) {
		$q = $_GET['q'];
	}
	else{
		$q = $_POST['q'];
	}
	$q = utf8_decode($q);
	$q = trim($q);
	$q = strtolower($q);
}
else{
	$q = "";
}


/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_exercises";
if($q != ""){
	$website_title = $website_title . " - $q";
}
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");


echo"
<!-- Headline and language -->
	<h1>$l_search</h1>
<!-- //Headline and language -->


<!-- Search -->
	<div style=\"float: left;\">
		<form method=\"post\" action=\"search_exercise.php\" enctype=\"multipart/form-data\">
		<p>
		
		<input type=\"text\" name=\"q\" value=\"$q\" size=\"20\" id=\"nettport_inp_search_query\" />
		<input type=\"submit\" value=\"$l_search\" id=\"nettport_search_submit_button\" />
		</p>
	</div>

	<!-- Search script -->
		<script id=\"source\" language=\"javascript\" type=\"text/javascript\">
		\$(document).ready(function () {
			\$('#nettport_inp_search_query').keyup(function () {
        			var searchString    = $(\"#nettport_inp_search_query\").val();
       				var data            = 'l=$l&q='+ searchString;
         
        			// if searchString is not empty
        			if(searchString) {
           				// ajax call
            				\$.ajax({
                				type: \"POST\",
               					url: \"search_exercise_jquery.php\",
                				data: data,
						beforeSend: function(html) { // this happens before actual call
							\$(\"#nettport_search_results\").html(''); 
						},
               					success: function(html){
                    					\$(\"#nettport_search_results\").append(html);
              					}
            				});
       				}
        			return false;
            		});
            	});
		</script>
	<!-- //Search script -->
<!-- //Search -->


<!-- Show last added exercises -->
	<div id=\"nettport_search_results\">
	";	
	//  
	$x = 0;
	$q = $q . "%";
	$q_mysql = quote_smart($link, $q);
	$query = "SELECT exercise_id, exercise_title, exercise_user_id, exercise_muscle_group_id_main, exercise_equipment_id, exercise_type_id, exercise_level_id, exercise_updated_datetime, exercise_guide FROM $t_exercise_index WHERE (exercise_title LIKE $q_mysql OR exercise_title_alternative LIKE $q_mysql) AND exercise_language=$l_mysql ORDER BY exercise_title ASC";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_exercise_id, $get_exercise_title, $get_exercise_user_id, $get_exercise_muscle_group_id_main, $get_exercise_equipment_id, $get_exercise_type_id, $get_exercise_level_id, $get_exercise_updated_datetime, $get_exercise_guide) = $row;


		if($x == 0){
			echo"
			<div class=\"clear\" style=\"height: 10px;\"></div>
			<div class=\"left_right_left\">
			";
		}
		elseif($x == 1){
			echo"
			<div class=\"left_right_right\">
			";
		}




		echo"
				<p style=\"padding: 10px 0px 0px 0px;margin-bottom:0;\">
				<a href=\"view_exercise.php?exercise_id=$get_exercise_id&amp;type_id=$get_exercise_type_id&amp;main_muscle_group_id=$get_exercise_muscle_group_id_main&amp;l=$l\" class=\"exercise_index_title\">$get_exercise_title</a><br />
				</p>\n";
					// Images
					$query_images = "SELECT exercise_image_id, exercise_image_type, exercise_image_path, exercise_image_file FROM $t_exercise_index_images WHERE exercise_image_exercise_id='$get_exercise_id' ORDER BY exercise_image_type ASC LIMIT 0,2";
					$result_images = mysqli_query($link, $query_images);
					while($row_images = mysqli_fetch_row($result_images)) {
						list($get_exercise_image_id, $get_exercise_image_type, $get_exercise_image_path, $get_exercise_image_file) = $row_images;

						if($get_exercise_image_file != "" && file_exists("$root/$get_exercise_image_path/$get_exercise_image_file")){

							// Thumb
							$inp_new_x = 150;
							$inp_new_y = 150;
							$thumb = "exercise_" . $get_exercise_image_id . "-" . $inp_new_x . "x" . $inp_new_y . ".png";

							if(!(file_exists("$root/_cache/$thumb"))){
								resize_crop_image($inp_new_x, $inp_new_y, "$root/$get_exercise_image_path/$get_exercise_image_file", "$root/_cache/$thumb");
							}

							echo"				";
							echo"<a href=\"view_exercise.php?exercise_id=$get_exercise_id&amp;type_id=$get_exercise_type_id&amp;main_muscle_group_id=$get_exercise_muscle_group_id_main&amp;l=$l\"><img src=\"$root/_cache/$thumb\" alt=\"$get_exercise_image_type\" /></a>\n";
						}
					}
					echo"
			</div>
		";
		if($x == 1){
			$x = -1;
		}
		$x++;
	}
	echo"
	</div>
<!-- //Show all types -->

";


/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>