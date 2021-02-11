<?php
echo"
		</div> <!-- //layout_content_inner -->
	</div> <!-- //layout_content_wrapper -->

	<div id=\"layout_aside\">	
		<!-- Feeds -->
			";
			$t_users_feeds_index		= $mysqlPrefixSav . "users_feeds_index";
			$l = output_html($l);
			$l_mysql = quote_smart($link, $l);
			$query = "SELECT feed_id, feed_title, feed_text, feed_image_path, feed_image_file, feed_image_thumb_300x169, feed_image_thumb_540x304, feed_link_url, feed_link_name, feed_module_name, feed_module_part_name, feed_module_part_id, feed_main_category_id, feed_main_category_name, feed_sub_category_id, feed_sub_category_name, feed_user_id, feed_user_email, feed_user_name, feed_user_alias, feed_user_photo_file, feed_user_photo_thumb_40, feed_user_photo_thumb_50, feed_user_photo_thumb_60, feed_user_photo_thumb_200, feed_user_subscribe, feed_user_ip, feed_user_hostname, feed_language, feed_created_datetime, feed_created_date_saying, feed_created_year, feed_created_time, feed_modified_datetime, feed_likes, feed_dislikes, feed_comments, feed_reported, feed_reported_checked, feed_reported_reason FROM $t_users_feeds_index WHERE feed_language=$l_mysql ORDER BY feed_id DESC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_feed_id, $get_feed_title, $get_feed_text, $get_feed_image_path, $get_feed_image_file, $get_feed_image_thumb_300x169, $get_feed_image_thumb_540x304, $get_feed_link_url, $get_feed_link_name, $get_feed_module_name, $get_feed_module_part_name, $get_feed_module_part_id, $get_feed_main_category_id, $get_feed_main_category_name, $get_feed_sub_category_id, $get_feed_sub_category_name, $get_feed_user_id, $get_feed_user_email, $get_feed_user_name, $get_feed_user_alias, $get_feed_user_photo_file, $get_feed_user_photo_thumb_40, $get_feed_user_photo_thumb_50, $get_feed_user_photo_thumb_60, $get_feed_user_photo_thumb_200, $get_feed_user_subscribe, $get_feed_user_ip, $get_feed_user_hostname, $get_feed_language, $get_feed_created_datetime, $get_feed_created_date_saying, $get_feed_created_year, $get_feed_created_time, $get_feed_modified_datetime, $get_feed_likes, $get_feed_dislikes, $get_feed_comments, $get_feed_reported, $get_feed_reported_checked, $get_feed_reported_reason) = $row;
			
				echo"
				
				<div class=\"feed_bodycell\">
					<table>
					 <tr>
					  <td style=\"padding: 0px 6px 0px 0px;vertical-align:top;\">
						<!-- Author -->
							<span>
							<a href=\"$root/users/view_profile.php?user_id=$get_feed_user_id&amp;l=$l\">";
							if(file_exists("$root/_uploads/users/images/$get_feed_user_id/$get_feed_user_photo_thumb_40") && $get_feed_user_photo_thumb_40 != ""){
								echo"<img src=\"$root/_uploads/users/images/$get_feed_user_id/$get_feed_user_photo_thumb_40\" alt=\"$get_feed_user_photo_thumb_40\" />";
							}
							else{
								echo"<img src=\"$root/users/_gfx/avatar_blank_40.png\" alt=\"avatar_blank_40.png\" />";
							}
							echo"</a><br />
							<a href=\"$root/users/view_profile.php?user_id=$get_feed_user_id&amp;l=$l\">$get_feed_user_name</a><br />
							</span>
						<!-- //Author -->
					  </td>
					  <td style=\"vertical-align:top;\">
	
						<!-- Post -->";
						if(file_exists("$root/$get_feed_image_path/$get_feed_image_file") && $get_feed_image_file != ""){
							if(!(file_exists("$root/$get_feed_image_path/$get_feed_image_thumb_540x304")) && $get_feed_image_thumb_540x304 != ""){
								// Create thumb
								resize_crop_image(540, 304, "$root/$get_feed_image_path/$get_feed_image_file", "$root/$get_feed_image_path/$get_feed_image_thumb_540x304");

								echo"<div class=\"info\"><p>Make thumb</p></div>";
							}

							if(file_exists("$root/$get_feed_image_path/$get_feed_image_thumb_540x304") && $get_feed_image_thumb_540x304 != ""){
								echo"
								<p>
								<a href=\"$root/$get_feed_link_url\"><img src=\"$root/$get_feed_image_path/$get_feed_image_thumb_540x304\" alt=\"$get_feed_image_thumb_540x304\" /></a>
								</p>
								";
							}
						}
						echo"
						<p><a href=\"$root/$get_feed_link_url\"><b>$get_feed_title</b></a><br />
						$get_feed_text
						</p>
						<!-- //Post -->
					  </td>
					 </tr>
					</table>

				</div>
				";
			}
			echo"
		<!-- //Feeds -->
	</div> <!-- //layout_aside -->
</div> <!-- //layout_wrapper -->

<!-- Cookies warning -->
	";
	include("$root/_admin/_functions/cookies_warning_include.php");
	echo"
<!-- //Cookies warning -->

</body>
</html>";

?>