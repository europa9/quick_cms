<?php
echo"
<div class=\"blog_flex_row_e\">
";


$x = 0;
$query = "SELECT blog_post_id, blog_post_user_id, blog_post_title, blog_post_title_pre, blog_post_category_id, blog_post_category_title, blog_post_privacy_level, blog_post_image_path, blog_post_image_thumb_small, blog_post_image_thumb_medium, blog_post_image_thumb_large, blog_post_image_file, blog_post_image_ext, blog_post_image_text, blog_post_updated, blog_post_comments FROM $t_blog_posts WHERE blog_post_language=$l_mysql AND blog_post_privacy_level='everyone' AND blog_post_image_file != '' ORDER BY blog_post_id DESC LIMIT $limit";
$result = mysqli_query($link, $query);
while($row = mysqli_fetch_row($result)) {
	list($get_blog_post_id, $get_blog_post_user_id, $get_blog_post_title, $get_blog_post_title_pre, $get_blog_post_category_id, $get_blog_post_category_title, $get_blog_post_privacy_level, $get_blog_post_image_path, $get_blog_post_image_thumb_small, $get_blog_post_image_thumb_medium, $get_blog_post_image_thumb_large, $get_blog_post_image_file, $get_blog_post_image_ext, $get_blog_post_image_text, $get_blog_post_updated, $get_blog_post_comments) = $row;


	// Owners user ID
	$query_owner = "SELECT user_id, user_name, user_alias, user_rank FROM $t_users WHERE user_id=$get_blog_post_user_id";
	$result_owner = mysqli_query($link, $query_owner);
	$row_owner = mysqli_fetch_row($result_owner);
	list($get_user_id, $get_user_name, $get_user_alias) = $row_owner;
		
	if($get_blog_post_image_file != "" && file_exists("$root/$get_blog_post_image_path/$get_blog_post_image_file")){

		// Create thumb
		$width = 560;
		$height = 400;
		$thumb = $get_blog_post_id . "_thumb_" . $width . "x" . $height . "." . $get_blog_post_image_ext;
		if(!(file_exists("$root/$get_blog_post_image_path/$thumb"))){
			resize_crop_image($width, $height, "$root/$get_blog_post_image_path/$get_blog_post_image_file", "$root/$get_blog_post_image_path/$thumb");
		}	


		if($x == "0"){
			echo"
			<div class=\"blog_flex_column_e_left\">
				<a href=\"$root/blog/view_post.php?post_id=$get_blog_post_id&amp;l=$l\"><img src=\"$root/$get_blog_post_image_path/$thumb\" alt=\"$get_blog_post_image_file\" class=\"recipe_of_the_day_img\" /></a>

				<p>
				<a href=\"$root/blog/view_post.php?post_id=$get_blog_post_id&amp;l=$l\" class=\"blog_post_a_h3\">$get_blog_post_title</a>
				</p>
			</div>
			";
		}
		elseif($x == "1"){
			echo"
			<div class=\"blog_flex_column_e_right\">
				<a href=\"$root/blog/view_post.php?post_id=$get_blog_post_id&amp;l=$l\"><img src=\"$root/$get_blog_post_image_path/$thumb\" alt=\"$get_blog_post_image_file\" class=\"recipe_of_the_day_img\" /></a>

				<p>
				<a href=\"$root/blog/view_post.php?post_id=$get_blog_post_id&amp;l=$l\" class=\"blog_post_a_h3\">$get_blog_post_title</a>
				</p>
			</div>
			";
		}

		$x++;
	} // has image
} // while

echo"
</div> <!-- //blog_flex_row_e -->
<hr />
<div class=\"clear\"></div>
";
?>