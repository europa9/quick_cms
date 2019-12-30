<?php 
/**
*
* File: recipes/delete_comment.php
* Version 2.0.0
* Date 22:33 05.02.2019
* Copyright (c) 2019 Localhost
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

/*- Translation ------------------------------------------------------------------------ */
include("$root/_admin/_translations/site/$l/recipes/ts_recipes.php");
include("$root/_admin/_translations/site/$l/recipes/ts_view_recipe.php");


/*- Variables ------------------------------------------------------------------------- */
if(isset($_GET['comment_id'])) {
	$comment_id = $_GET['comment_id'];
	$comment_id = strip_tags(stripslashes($comment_id));
}
else{
	$comment_id = "";
}
$l_mysql = quote_smart($link, $l);


/*- Get comment ------------------------------------------------------------------------- */
// Select
$comment_id_mysql = quote_smart($link, $comment_id);
$query = "SELECT comment_id, comment_recipe_id, comment_language, comment_approved, comment_datetime, comment_time, comment_date_print, comment_user_id, comment_user_alias, comment_user_image_path, comment_user_image_file, comment_user_ip, comment_user_hostname, comment_user_agent, comment_title, comment_text, comment_rating, comment_helpful_clicks, comment_useless_clicks, comment_marked_as_spam, comment_spam_checked, comment_spam_checked_comment FROM $t_recipes_comments WHERE comment_id=$comment_id_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_current_comment_id, $get_current_comment_recipe_id, $get_current_comment_language, $get_current_comment_approved, $get_current_comment_datetime, $get_current_comment_time, $get_current_comment_date_print, $get_current_comment_user_id, $get_current_comment_user_alias, $get_current_comment_user_image_path, $get_current_comment_user_image_file, $get_current_comment_user_ip, $get_current_comment_user_hostname, $get_current_comment_user_agent, $get_current_comment_title, $get_current_comment_text, $get_current_comment_rating, $get_current_comment_helpful_clicks, $get_current_comment_useless_clicks, $get_current_comment_marked_as_spam, $get_current_comment_spam_checked, $get_current_comment_spam_checked_comment) = $row;

/*- Headers ---------------------------------------------------------------------------------- */
if($get_current_comment_id == ""){
	$website_title = "Server error 404";
}
else{
	$website_title = "$l_recipes - $get_current_comment_title";
}

if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");

/*- Content ---------------------------------------------------------------------------------- */


// Check access to comment
if(isset($_SESSION['user_id'])){
	// Get my user
	$my_user_id = $_SESSION['user_id'];
	$my_user_id = output_html($my_user_id);
	$my_user_id_mysql = quote_smart($link, $my_user_id);
	$query = "SELECT user_id, user_email, user_name, user_alias, user_rank FROM $t_users WHERE user_id=$my_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_my_user_id, $get_my_user_email, $get_my_user_name, $get_my_user_alias, $get_my_user_rank) = $row;

	if($get_current_comment_id == ""){
		echo"
		<h1>Server error 404</h1>

		<p>Comment not found.</p>
		";
	}
	else{
		// Find recipe
		$query = "SELECT recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password FROM $t_recipes WHERE recipe_id=$get_current_comment_recipe_id";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_recipe_id, $get_current_recipe_user_id, $get_current_recipe_title, $get_current_recipe_category_id, $get_current_recipe_language, $get_current_recipe_introduction, $get_current_recipe_directions, $get_current_recipe_image_path, $get_current_recipe_image, $get_current_recipe_thumb, $get_current_recipe_video, $get_current_recipe_date, $get_current_recipe_time, $get_current_recipe_cusine_id, $get_current_recipe_season_id, $get_current_recipe_occasion_id, $get_current_recipe_marked_as_spam, $get_current_recipe_unique_hits, $get_current_recipe_unique_hits_ip_block, $get_current_recipe_user_ip, $get_current_recipe_notes, $get_current_recipe_password) = $row;
	
		if($get_current_comment_user_id == "$my_user_id" OR $get_my_user_rank == "admin" OR $get_my_user_rank == "moderator"){
			if($process == "1"){
				
				$result = mysqli_query($link, "DELETE FROM $t_recipes_comments WHERE comment_id=$get_current_comment_id") or die(mysqli_error($link));


				// Edit ratings
				$query = "SELECT count(comment_rating) FROM $t_recipes_comments WHERE comment_recipe_id=$get_current_comment_recipe_id AND comment_rating='1'";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_comment_rating_stars_1) = $row;

				$query = "SELECT count(comment_rating) FROM $t_recipes_comments WHERE comment_recipe_id=$get_current_comment_recipe_id AND comment_rating='2'";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_comment_rating_stars_2) = $row;

				$query = "SELECT count(comment_rating) FROM $t_recipes_comments WHERE comment_recipe_id=$get_current_comment_recipe_id AND comment_rating='3'";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_comment_rating_stars_3) = $row;

				$query = "SELECT count(comment_rating) FROM $t_recipes_comments WHERE comment_recipe_id=$get_current_comment_recipe_id AND comment_rating='4'";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_comment_rating_stars_4) = $row;

				$query = "SELECT count(comment_rating) FROM $t_recipes_comments WHERE comment_recipe_id=$get_current_comment_recipe_id AND comment_rating='5'";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_comment_rating_stars_5) = $row;


				$inp_rating_total_votes = $get_comment_rating_stars_1+$get_comment_rating_stars_2+$get_comment_rating_stars_3+$get_comment_rating_stars_4+$get_comment_rating_stars_5;
				if($inp_rating_total_votes == "0"){
					$inp_rating_average = 0;
				}
				else{
					$inp_rating_average = round((($get_comment_rating_stars_1*1) + ($get_comment_rating_stars_2*2) + ($get_comment_rating_stars_3*3) + ($get_comment_rating_stars_4*4) + ($get_comment_rating_stars_5*5))/$inp_rating_total_votes);
				}
				
				$positive = $get_comment_rating_stars_4+$get_comment_rating_stars_5;
				$negative = $get_comment_rating_stars_1+$get_comment_rating_stars_2;
				$total    = $positive+$negative;
				if($total == "0"){
					$inp_rating_popularity  = 0;
				}
				else{
					$inp_rating_popularity  = round(($positive/$total*100));
				}					
				$result = mysqli_query($link, "UPDATE $t_recipes_rating SET rating_1=$get_comment_rating_stars_1, 
rating_2=$get_comment_rating_stars_2, 
rating_3=$get_comment_rating_stars_3, 
rating_4=$get_comment_rating_stars_4, 
rating_5=$get_comment_rating_stars_5,
 rating_total_votes=$inp_rating_total_votes, rating_average=$inp_rating_average , rating_popularity=$inp_rating_popularity, rating_ip_block='' WHERE rating_recipe_id=$get_current_comment_recipe_id") or die(mysqli_error($link));
					

				$url = "view_recipe.php?recipe_id=$get_current_recipe_id&l=$l&ft=success&fm=comment_deletedd#comments";
				header("Location: $url");
				exit;


			}
			echo"
			<h1>$l_delete_comment</h1>

			
			<!-- Where am I? -->
				<p>$l_you_are_here:<br />
				<a href=\"index.php?l=$l\">$l_recipes</a>
				&gt;
				<a href=\"view_recipe.php?recipe_id=$get_current_recipe_id&amp;l=$l\">$get_current_recipe_title</a>
				&gt;
				<a href=\"edit_comment.php?comment_id=$get_current_comment_id&amp;l=$l\">$l_delete_comment</a>
				</p>
			<!-- //Where am I? -->

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


			<!-- Delete comment form -->


				<p>
				$l_are_you_sure
				</p>
				
				<p>
				<a href=\"delete_comment.php?comment_id=$get_current_comment_id&amp;l=$l&amp;process=1\" class=\"btn_warning\">$l_confirm_delete</a>
				<a href=\"view_recipe.php?recipe_id=$get_current_recipe_id&amp;l=$l\" class=\"btn_default\">$l_go_back</a>
				</p>
			<!-- //Edit comment form -->
			";

		} // access
		else{
			echo"
			<h1>Server error 403</h1>

			<p>Access denied.</p>
			";

		} // access
	} // Comment found
} // logged in
else{
	echo"
	<h1>
	<img src=\"$root/_webdesign/images/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" />
	Loading...</h1>
	<meta http-equiv=\"refresh\" content=\"1;url=$root/users/index.php?page=login&amp;l=$l&amp;refer=$root/recipes/edit_comment.php?comment_id=$comment_id\">
	";	
} // not logged in

/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>