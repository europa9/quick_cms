﻿<?php
/**
*
* File: references/_includes/group_index.php
* Version 2.0.0
* Date 22:38 03.05.2019
* Copyright (c) 2011-2019 Localhost
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Functions ------------------------------------------------------------------------ */

/*- Variables ------------------------------------------------------------------------ */
$tabindex = 0;

/*- Tables ---------------------------------------------------------------------------- */
$t_references_title_translations = $mysqlPrefixSav . "references_title_translations";
$t_references_categories_main	 = $mysqlPrefixSav . "references_categories_main";
$t_references_categories_sub 	 = $mysqlPrefixSav . "references_categories_sub";
$t_references_index		 = $mysqlPrefixSav . "references_index";
$t_references_index_groups	 = $mysqlPrefixSav . "references_index_groups";
$t_references_index_guides	 = $mysqlPrefixSav . "references_index_guides";


/*- Translation ---------------------------------------------------------------------------- */
include("$root/_admin/_translations/site/$l/references/ts_group_index.php");

// Find reference
$reference_title_mysql = quote_smart($link, $referenceTitleSav);
$query = "SELECT reference_id, reference_title, reference_title_clean, reference_is_active, reference_front_page_intro, reference_description, reference_language, reference_main_category_id, reference_main_category_title, reference_sub_category_id, reference_sub_category_title, reference_image_file, reference_image_thumb, reference_icon_16, reference_icon_32, reference_icon_48, reference_icon_64, reference_icon_96, reference_icon_260, reference_groups_count, reference_guides_count, reference_read_times, reference_read_times_ip_block, reference_created, reference_updated FROM $t_references_index WHERE reference_title=$reference_title_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_current_reference_id, $get_current_reference_title, $get_current_reference_title_clean, $get_current_reference_is_active, $get_current_reference_front_page_intro, $get_current_reference_description, $get_current_reference_language, $get_current_reference_main_category_id, $get_current_reference_main_category_title, $get_current_reference_sub_category_id, $get_current_reference_sub_category_title, $get_current_reference_image_file, $get_current_reference_image_thumb, $get_current_reference_icon_16, $get_current_reference_icon_32, $get_current_reference_icon_48, $get_current_reference_icon_64, $get_current_reference_icon_96, $get_current_reference_icon_260, $get_current_reference_groups_count, $get_current_reference_guides_count, $get_current_reference_read_times, $get_current_reference_read_times_ip_block, $get_current_reference_created, $get_current_reference_updated) = $row;

if($get_current_reference_id != ""){
	
	// Find group
	if(isset($_GET['group_id'])) {
		$group_id = $_GET['group_id'];
		$group_id = strip_tags(stripslashes($group_id));
	}
	else{
		echo"Group not found";
		die;
	}
		
	// Search for group
	$group_id_mysql = quote_smart($link, $group_id);
	$query = "SELECT group_id, group_title, group_title_clean, group_title_short, group_title_length, group_number, group_reference_id, group_reference_title, group_read_times, group_read_times_ip_block, group_created_datetime, group_updated_datetime, group_updated_formatted FROM $t_references_index_groups WHERE group_id=$group_id_mysql AND group_reference_id=$get_current_reference_id";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_group_id, $get_current_group_title, $get_current_group_title_clean, $get_current_group_title_short, $get_current_group_title_length, $get_current_group_number, $get_current_group_reference_id, $get_current_group_reference_title, $get_current_group_read_times, $get_current_group_read_times_ip_block, $get_current_group_created_datetime, $get_current_group_updated_datetime, $get_current_group_updated_formatted) = $row;


	if($get_current_group_id != ""){
		if($action == ""){
			// Last read
			$datetime = date("Y-m-d H:i:s");
			$date_formatted = date("j M Y");
			$result = mysqli_query($link, "UPDATE $t_references_index_groups SET group_last_read='$datetime', group_last_read_formatted='$date_formatted' WHERE group_id=$get_current_group_id");

			// Visits
			$my_ip = $_SERVER['REMOTE_ADDR'];
			$my_ip = output_html($my_ip);
		
			$ipblock_array = explode("\n", $get_current_group_read_times_ip_block);
			$size = sizeof($ipblock_array);
			$i_have_visited_before = "false";
			for($x=0;$x<$size;$x++){
				if($ipblock_array[$x] == "$my_ip"){
					$i_have_visited_before = "true";
				}
			}
			
			if($i_have_visited_before == "false"){
				$inp_read_times = $get_current_group_read_times+1;
			
				if($get_current_group_read_times_ip_block == ""){
					$inp_read_ipblock = "$my_ip";
				}
				else{
					$inp_read_ipblock = "$my_ip\n" . substr($get_current_group_read_times_ip_block, 0, 400);
				}
				$inp_read_ipblock_mysql = quote_smart($link, $inp_read_ipblock);

				$result = mysqli_query($link, "UPDATE $t_references_index_groups SET group_read_times=$inp_read_times, group_read_times_ip_block=$inp_read_ipblock_mysql WHERE group_id=$get_current_group_id") or die(mysqli_error($link));

			}


			echo"
			<h1>$get_current_group_title</h1>
			
			<!-- Search -->
			
			<script>
			\$(document).ready(function(){
				\$('[name=\"inp_search_query\"]').focus();
			});
			</script>
			<form method=\"get\" action=\"reference_by_alphabet.php\" enctype=\"multipart/form-data\">
			
			<p>
			<input type=\"text\" name=\"search_query\" id=\"autosearch_search_query\" size=\"20\" value=\"";
			if(isset($search_query)){
				echo"$search_query";
			}
			else{
				echo"$l_search...";
			}
			echo"\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
			<input type=\"hidden\" name=\"reference_id\" value=\"$get_current_reference_id\" />
				<input type=\"hidden\" name=\"guide_id\" value=\"-1\" />
			<input type=\"hidden\" name=\"l\" value=\"$l\" />
			</p>
		
			</form>
			<!-- Search script -->
				<script id=\"source\" language=\"javascript\" type=\"text/javascript\">
				\$(document).ready(function () {
					\$('#autosearch_search_query').click(function() {
     						var searchString    = $(\"#autosearch_search_query\").val();
						if (searchString.endsWith(\"$l_search...\")) {
							\$('#autosearch_search_query').val('');
						}
       					});
					\$('#autosearch_search_query').keyup(function () {
						$(\"#autosearch_search_results_show\").show();
						$(\"#autosearch_search_results_hide\").hide();

       						// getting the value that user typed
       						var searchString    = $(\"#autosearch_search_query\").val();
 						// forming the queryString
      						var data            = 'l=$l&reference_id=$get_current_reference_id&q='+ searchString;
         
        					// if searchString is not empty
        					if(searchString) {
							// Start with Search...
							if (searchString.match(\"^$l_search...\")) {
								searchString = searchString.replace('$l_search...', '');
								\$('#autosearch_search_query').val(searchString);
							}
							// Ends with Search...
							if (searchString.endsWith(\"$l_search...\")) {
								searchString = searchString.replace('$l_search...', '');
								\$('#autosearch_search_query').val(searchString);
							}

      							// ajax call
      							\$.ajax({
               							type: \"POST\",
              								url: \"$root/references/_includes/group_index_jquery_search.php\",
                							data: data,
									beforeSend: function(html) { // this happens before actual call
										\$(\"#autosearch_search_results_show\").html(''); 
									},
               								success: function(html){
                    								\$(\"#autosearch_search_results_show\").append(html);
              								}
            						});
       						}
        					return false;
            				});
         			});
				</script>
			<!-- //Search script -->
			<!-- //Search -->


			<!-- Reference by category -->
				<div style=\"height:10px;\"></div>

				<table class=\"hor-zebra\">
				 <thead>
				  <tr>
				   <th scope=\"col\">
					<span>$l_title</span>
				   </th>
				   <th scope=\"col\">
					<span>$l_description</span>
				   </th>
				  </tr>
				 </thead>
				 <tbody id=\"autosearch_search_results_show\">";
				// Get guides
				$query_lessons = "SELECT guide_id, guide_title, guide_title_clean, guide_title_short, guide_title_length, guide_short_description FROM $t_references_index_guides WHERE guide_group_id=$get_current_group_id ORDER BY guide_number ASC";
				$result_lessons = mysqli_query($link, $query_lessons);
				while($row_lessons = mysqli_fetch_row($result_lessons)) {
					list($get_guide_id, $get_guide_title, $get_guide_title_clean, $get_guide_title_short, $get_guide_title_length, $get_guide_short_description) = $row_lessons;
					
					if(isset($style) && $style == ""){
						$style = "odd";
					}
					else{
						$style = "";
					}
					echo"
					 <tr>
					  <td class=\"$style\" style=\"width: 20%;\">
						<span><a href=\"$root/$get_current_reference_title_clean/$get_current_group_title_clean/$get_guide_title_clean.php?reference_id=$get_current_reference_id&amp;group_id=$get_current_group_id&amp;guide_id=$get_guide_id&amp;l=$l\">$get_guide_title</a></span>
					  </td>
					  <td class=\"$style\">
						<span>$get_guide_short_description</span>
					  </td>
					 </tr>";
				} // guides
				echo"
				 </tbody>
				</table>
			
				<div style=\"height:20px;\"></div>
			<!-- //Reference by category -->

			";
		} // action == ""
	} // group found
} // course found

?>