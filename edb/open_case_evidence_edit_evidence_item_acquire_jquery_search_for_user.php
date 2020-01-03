<?php 
/**
*
* File: edb/open_case_index.php
* Version 1.0
* Date 21:03 04.08.2019
* Copyright (c) 2019 S. A. Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/*- Configuration ---------------------------------------------------------------------------- */
$pageIdSav            = "2";
$pageNoColumnSav      = "2";
$pageAllowCommentsSav = "1";
$pageAuthorUserIdSav  = "1";

/*- Root dir --------------------------------------------------------------------------------- */
// This determine where we are
if(file_exists("favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
elseif(file_exists("../../../../favicon.ico")){ $root = "../../../.."; }
else{ $root = "../../.."; }

/*- Website config --------------------------------------------------------------------------- */
include("$root/_admin/website_config.php");


/*- Query --------------------------------------------------------------------------- */

if(isset($_GET['q']) && $_GET['q'] != ''){
	$q = $_GET['q'];
	$q = strip_tags(stripslashes($q));
	$q = trim($q);
	$q = strtolower($q);
	$q = output_html($q);
	$q = $q . "%";
	$part_mysql = quote_smart($link, $q);


	//get matched data from skills table
	$last_user_id = "";
	$query = "SELECT station_member_id, station_member_user_id, station_member_rank, station_member_user_name, station_member_user_alias, station_member_first_name, station_member_middle_name, station_member_last_name, station_member_user_email, station_member_user_image_path, station_member_user_image_file, station_member_user_image_thumb_40, station_member_user_image_thumb_50, station_member_user_image_thumb_60 FROM $t_edb_stations_members WHERE station_member_user_name LIKE $part_mysql OR station_member_first_name LIKE $part_mysql OR station_member_last_name LIKE $part_mysql";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_station_member_id, $get_station_member_user_id, $get_station_member_rank, $get_station_member_user_name, $get_station_member_user_alias, $get_station_member_first_name, $get_station_member_middle_name, $get_station_member_last_name, $get_station_member_user_email, $get_station_member_user_image_path, $get_station_member_user_image_file, $get_station_member_user_image_thumb_40, $get_station_member_user_image_thumb_50, $get_station_member_user_image_thumb_60) = $row;
		if($last_user_id != "$get_station_member_user_id"){
			echo"
			<table>
			 <tr>
			  <td style=\"padding-right: 5px;\">
				<!-- Img -->
				<p>";
				if($get_station_member_user_image_file != "" && file_exists("$root/$get_station_member_user_image_path/$get_station_member_user_image_file")){
					if(file_exists("$root/$get_station_member_user_image_path/$get_station_member_user_image_thumb_50") && $get_station_member_user_image_thumb_50 != ""){
						echo"
						<a href=\"#\" data-divid=\"$get_station_member_user_name\" class=\"tags_select\"><img src=\"$root/$get_station_member_user_image_path/$get_station_member_user_image_thumb_50\" alt=\"$get_station_member_user_image_file\" /></a>
						";
					}
					else{
						if($get_station_member_user_image_thumb_50 != ""){
							// Make thumb
							$inp_new_x = 50; // 950
							$inp_new_y = 50; // 640
							resize_crop_image($inp_new_x, $inp_new_y, "$root/$get_station_member_user_image_path/$get_station_member_user_image_file", "$root/$get_station_member_user_image_path/$get_station_member_user_image_thumb_50");
							echo"
							<a href=\"#\" data-divid=\"$get_station_member_user_name\" class=\"tags_select\"><img src=\"$root/$get_station_member_user_image_path/$get_station_member_user_image_thumb_50\" alt=\"$get_station_member_user_image_file\" /></a>
							";
						}
						else{
							// Update thumb name
							$ext = get_extension($get_station_member_user_image_file);
							$inp_thumb_name = str_replace($ext, "", $get_station_member_user_image_file);
							$inp_thumb_name = $inp_thumb_name . "_50." . $ext;
							$inp_thumb_name_mysql = quote_smart($link, $inp_thumb_name);
							$result_update = mysqli_query($link, "UPDATE $t_edb_stations_members SET station_member_user_image_thumb_50=$inp_thumb_name_mysql WHERE station_member_id=$get_station_member_id") or die(mysqli_error($link));

						}
					}
				}
				else{
					echo"
					<a href=\"#\" data-divid=\"$get_station_member_user_name\" class=\"tags_select\"><img src=\"_gfx/avatar_blank_50.png\" alt=\"avatar_blank_50.png\" /></a>
					";
				}

				echo"
				</p>
				<!-- //Img -->
			  </td>
			  <td>
				<!-- Name -->	
				<p>
				<a href=\"#\" class=\"tags_select\" data-divid=\"$get_station_member_user_name\">$get_station_member_user_name</a><br />
				<a href=\"#\" class=\"tags_select\" data-divid=\"$get_station_member_user_name\" style=\"color:black;\">$get_station_member_first_name  $get_station_member_middle_name $get_station_member_last_name</a>
				</p>
				<!-- //Name -->
			  </td>
			 </tr>
			</table>
			";
		} // duplicates
		$last_user_id = "$get_station_member_user_id";
	}
	echo"
	<!-- Javascript on click add text to text input -->
		<script type=\"text/javascript\">
		\$(function() {
			\$('.tags_select').click(function() {
				var value = \$(this).data('divid');
            			var input = \$('#autosearch_inp_search_for_acquired');
            			input.val(value);

				// Close
				\$(\".open_case_acquired_results\").html(''); 
            			return false;
       			});
    		});
		</script>
	<!-- //Javascript on click add text to text input -->
	";

}
else{
	echo"Missing q";
}

?>