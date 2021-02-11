<?php 
/**
*
* File: recipes/search.php
* Version 1.0.0
* Date 23:59 27.11.2017
* Copyright (c) 2011-2017 Localhost
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

/*- Tables ---------------------------------------------------------------------------- */
include("_tables.php");

/*- Translation ------------------------------------------------------------------------ */
include("$root/_admin/_translations/site/$l/recipes/ts_recipes.php");


/*- Variables ------------------------------------------------------------------------- */
if(isset($_GET['q'])) {
	$q = $_GET['q'];
	$q = strip_tags(stripslashes($q));
}
else{
	$q = "";
}
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
if(isset($_GET['number_serving_calories_from'])) {
	$number_serving_calories_from = $_GET['number_serving_calories_from'];
	$number_serving_calories_from = strip_tags(stripslashes($number_serving_calories_from));
	$number_serving_calories_from = str_replace(",", ".", $number_serving_calories_from);
	if(!(is_numeric($number_serving_calories_from))){
		$number_serving_calories_from = "";
	}
}
else{
	$number_serving_calories_from = "";
}
if(isset($_GET['number_serving_calories_to'])) {
	$number_serving_calories_to = $_GET['number_serving_calories_to'];
	$number_serving_calories_to = strip_tags(stripslashes($number_serving_calories_to));
	$number_serving_calories_to = str_replace(",", ".", $number_serving_calories_to);
	if(!(is_numeric($number_serving_calories_to))){
		$number_serving_calories_to = "";
	}
}
else{
	if(is_numeric($q)){
		$number_serving_calories_to = $q;
		$q = " ";
	}
	else{
		$number_serving_calories_to = "";
	}
}



if(isset($_GET['number_serving_proteins_from'])) {
	$number_serving_proteins_from = $_GET['number_serving_proteins_from'];
	$number_serving_proteins_from = strip_tags(stripslashes($number_serving_proteins_from));
	$number_serving_proteins_from = str_replace(",", ".", $number_serving_proteins_from);
	if(!(is_numeric($number_serving_proteins_from))){
		$number_serving_proteins_from = "";
	}
}
else{
	$number_serving_proteins_from = "";
}
if(isset($_GET['number_serving_proteins_to'])) {
	$number_serving_proteins_to = $_GET['number_serving_proteins_to'];
	$number_serving_proteins_to = strip_tags(stripslashes($number_serving_proteins_to));
	$number_serving_proteins_to = str_replace(",", ".", $number_serving_proteins_to);
	if(!(is_numeric($number_serving_proteins_to))){
		$number_serving_proteins_to = "";
	}
}
else{
	$number_serving_proteins_to = "";
}

if(isset($_GET['number_serving_fat_from'])) {
	$number_serving_fat_from = $_GET['number_serving_fat_from'];
	$number_serving_fat_from = strip_tags(stripslashes($number_serving_fat_from));
	$number_serving_fat_from = str_replace(",", ".", $number_serving_fat_from);
	if(!(is_numeric($number_serving_fat_from))){
		$number_serving_fat_from = "";
	}
}
else{
	$number_serving_fat_from = "";
}
if(isset($_GET['number_serving_fat_to'])) {
	$number_serving_fat_to = $_GET['number_serving_fat_to'];
	$number_serving_fat_to = strip_tags(stripslashes($number_serving_fat_to));
	$number_serving_fat_to = str_replace(",", ".", $number_serving_fat_to);
	if(!(is_numeric($number_serving_fat_to))){
		$number_serving_fat_to = "";
	}
}
else{
	$number_serving_fat_to = "";
}

if(isset($_GET['number_serving_carbs_from'])) {
	$number_serving_carbs_from = $_GET['number_serving_carbs_from'];
	$number_serving_carbs_from = strip_tags(stripslashes($number_serving_carbs_from));
	$number_serving_carbs_from = str_replace(",", ".", $number_serving_carbs_from);
	if(!(is_numeric($number_serving_carbs_from))){
		$number_serving_carbs_from = "";
	}
}
else{
	$number_serving_carbs_from = "";
}
if(isset($_GET['number_serving_carbs_to'])) {
	$number_serving_carbs_to = $_GET['number_serving_carbs_to'];
	$number_serving_carbs_to = strip_tags(stripslashes($number_serving_carbs_to));
	$number_serving_carbs_to = str_replace(",", ".", $number_serving_carbs_to);
	if(!(is_numeric($number_serving_carbs_to))){
		$number_serving_carbs_to = "";
	}
}
else{
	$number_serving_carbs_to = "";
}

/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_recipes - $l_search"; 
if($q != ""){
	$website_title = $website_title .  " - $q"; 
}
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");

/*- Content ---------------------------------------------------------------------------------- */
echo"
<h1>";
if($q == ""){ echo"$l_search"; } 
else{ echo"$l_search_for $q"; }
echo"</h1>

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


	<!-- Left and right -->
		<!-- Content left hide view -->
			<script>
			\$(document).ready(function(){
				\$(\".content_left_hide_view_a\").click(function () {
					\$(\".recipe_search_left\").toggle();
				});
			});
			</script>


			<div class=\"content_left_hide_view_div\">
				<a href=\"#\" class=\"content_left_hide_view_a\"><img src=\"_gfx/icons/ic_list_black_18dp_1x.png\" alt=\"ic_list_black_18dp_1x.png\" /></a>
			</div>
			<div class=\"clear\"></div>
			
		<!-- Content left hide view -->
		<div class=\"recipe_search_left\">
			<!-- Search form -->
        			<form method=\"get\" action=\"search.php\" enctype=\"multipart/form-data\">
				<p>
				<input type=\"text\" name=\"q\" value=\""; if($q == ""){ echo"$l_search..."; } else{ echo"$q"; } echo"\" size=\"15\" class=\"recipe_search_text\" />
				<input type=\"submit\" value=\"$l_search\" class=\"btn btn_default\" />
				</p>
				<div class=\"clear\"></div>
			<!-- //Search form -->


			<!-- Max calories -->

				<script>
				\$(document).ready(function(){
   				 \$(\".recipe_search_text\").focusin(
    				    function () {
    				        \$(this).val(\"\");
   				     }
 				   );
				});
				</script>


				<p style=\"margin:0;padding: 26px 0px 0px 0px;\"><b>$l_max</b></p>

				<p>$l_calories<br />
				<input type=\"text\" name=\"number_serving_calories_from\" value=\""; if($number_serving_calories_from != ""){ echo"$number_serving_calories_from"; } else{ echo"$l_from"; }  echo"\" size=\"5\" class=\"recipe_search_text\" />
				<input type=\"text\" name=\"number_serving_calories_to\" value=\""; if($number_serving_calories_to != ""){ echo"$number_serving_calories_to"; } else{ echo"$l_to"; }  echo"\" size=\"5\" class=\"recipe_search_text\" />
				<input type=\"submit\" value=\"$l_search\" class=\"btn btn_default\" />
				</p>

				<p>$l_fat<br />
				<input type=\"text\" name=\"number_serving_fat_from\" value=\""; if($number_serving_fat_from != ""){ echo"$number_serving_fat_from"; } else{ echo"$l_from"; }  echo"\" size=\"5\" class=\"recipe_search_text\" />
				<input type=\"text\" name=\"number_serving_fat_to\" value=\""; if($number_serving_fat_to != ""){ echo"$number_serving_fat_to"; } else{ echo"$l_to"; }  echo"\" size=\"5\" class=\"recipe_search_text\" />
				<input type=\"submit\" value=\"$l_search\" class=\"btn btn_default\" />
				</p>

				<p>$l_carbs<br />
				<input type=\"text\" name=\"number_serving_carbs_from\" value=\""; if($number_serving_carbs_from != ""){ echo"$number_serving_carbs_from"; } else{ echo"$l_from"; }  echo"\" size=\"5\" class=\"recipe_search_text\" />
				<input type=\"text\" name=\"number_serving_carbs_to\" value=\""; if($number_serving_carbs_to != ""){ echo"$number_serving_carbs_to"; } else{ echo"$l_to"; }  echo"\" size=\"5\" class=\"recipe_search_text\" />
				<input type=\"submit\" value=\"$l_search\" class=\"btn btn_default\" />
				</p>

				<p>$l_proteins<br />
				<input type=\"text\" name=\"number_serving_proteins_from\" value=\""; if($number_serving_proteins_from != ""){ echo"$number_serving_proteins_from"; } else{ echo"$l_from"; }  echo"\" size=\"5\" class=\"recipe_search_text\" />
				<input type=\"text\" name=\"number_serving_proteins_to\" value=\""; if($number_serving_proteins_to != ""){ echo"$number_serving_proteins_to"; } else{ echo"$l_to"; }  echo"\" size=\"5\" class=\"recipe_search_text\" />
				<input type=\"submit\" value=\"$l_search\" class=\"btn btn_default\" />
				</p>


				</form>
			<!-- //Max calories -->


			<!-- Order -->
				<p style=\"margin:0;padding: 26px 0px 0px 0px;\"><b>$l_order</b></p>
				
					<script>
					\$(function(){
						\$('#inp_order_by_select').on('change', function () {
							var url = \$(this).val();
							if (url) { // require a URL
 								window.location = url;
							}
						return false;
					});
					\$('#inp_order_method_select').on('change', function () {
							var url = \$(this).val();
							if (url) { // require a URL
 								window.location = url;
							}
							return false;
						});
					});
					</script>
					";
					$order_url = "search.php?q=$q";
					if($number_serving_calories_from != ""){
						$order_url = $order_url . "&amp;number_serving_calories_from=$number_serving_calories_from";
					}
					if($number_serving_calories_to != ""){
						$order_url = $order_url . "&amp;number_serving_calories_to=$number_serving_calories_to";
					}

					if($number_serving_proteins_from != ""){
						$order_url = $order_url . "&amp;number_serving_proteins_from=$number_serving_proteins_from";
					}
					if($number_serving_proteins_to != ""){
						$order_url = $order_url . "&amp;number_serving_proteins_to=$number_serving_proteins_to";
					}


					if($number_serving_fat_from != ""){
						$order_url = $order_url . "&amp;number_serving_fat_from=$number_serving_fat_from";
					}
					if($number_serving_fat_to != ""){
						$order_url = $order_url . "&amp;number_serving_fat_to=$number_serving_fat_to";
					}


					if($number_serving_carbs_from != ""){
						$order_url = $order_url . "&amp;number_serving_carbs_from=$number_serving_carbs_from";
					}
					if($number_serving_carbs_to != ""){
						$order_url = $order_url . "&amp;number_serving_carbs_to=$number_serving_carbs_to";
					}

			
				echo"
				
        			<form method=\"get\" action=\"search.php\" enctype=\"multipart/form-data\">
				<p>
				<select name=\"inp_order_by\" id=\"inp_order_by_select\">
					<option value=\"$order_url\">- $l_order_by -</option>
					<option value=\"$order_url&amp;order_by=recipe_id&amp;order_method=$order_method\""; if($order_by == "recipe_id" OR $order_by == ""){ echo" selected=\"selected\""; } echo">$l_date</option>
					<option value=\"$order_url&amp;order_by=recipe_title&amp;order_method=$order_method\""; if($order_by == "recipe_title"){ echo" selected=\"selected\""; } echo">$l_title</option>
					<option value=\"$order_url&amp;order_by=recipe_unique_hits&amp;order_method=$order_method\""; if($order_by == "recipe_unique_hits"){ echo" selected=\"selected\""; } echo">$l_unique_hits</option>
					<option value=\"$order_url&amp;order_by=number_serving_calories&amp;order_method=$order_method\""; if($order_by == "number_serving_calories"){ echo" selected=\"selected\""; } echo">$l_calories</option>
					<option value=\"$order_url&amp;order_by=number_serving_fat&amp;order_method=$order_method\""; if($order_by == "number_serving_fat"){ echo" selected=\"selected\""; } echo">$l_fat</option>
					<option value=\"$order_url&amp;order_by=number_serving_carbs&amp;order_method=$order_method\""; if($order_by == "number_serving_carbs"){ echo" selected=\"selected\""; } echo">$l_carbs</option>
					<option value=\"$order_url&amp;order_by=number_serving_proteins&amp;order_method=$order_method\""; if($order_by == "number_serving_proteins"){ echo" selected=\"selected\""; } echo">$l_proteins</option>
				</select>
				<select name=\"inp_order_method\" id=\"inp_order_method_select\">
					<option value=\"$order_url&amp;order_by=$order_by&amp;order_method=asc\""; if($order_method == "asc" OR $order_method == ""){ echo" selected=\"selected\""; } echo">$l_asc</option>
					<option value=\"$order_url&amp;order_by=$order_by&amp;order_method=desc\""; if($order_method == "desc"){ echo" selected=\"selected\""; } echo">$l_desc</option>
				</select>
				</p>
        			</form>
			<!-- //Order -->
		</div>
		<div class=\"recipe_search_right\">
	

";

if($q != ""){
	



	$search_results_count = 0;

	$q = "%" . $q . "%";
	$q_mysql = quote_smart($link, $q);

	$x = 0;
	$query = "SELECT $t_recipes.recipe_id, $t_recipes.recipe_title, $t_recipes.recipe_introduction, $t_recipes.recipe_image_path, $t_recipes.recipe_image, $t_recipes.recipe_unique_hits, $t_recipes_numbers.number_serving_calories, $t_recipes_numbers.number_serving_proteins, $t_recipes_numbers.number_serving_fat, $t_recipes_numbers.number_serving_carbs FROM $t_recipes JOIN $t_recipes_numbers ON $t_recipes.recipe_id=$t_recipes_numbers.number_recipe_id WHERE $t_recipes.recipe_title LIKE $q_mysql AND $t_recipes.recipe_language=$l_mysql";
	
	if($number_serving_calories_from != ""){
		$number_serving_calories_from_mysql = quote_smart($link, $number_serving_calories_from);
		$query = $query . " AND number_serving_calories > $number_serving_calories_from_mysql";
	}
	if($number_serving_calories_to != ""){
		$number_serving_calories_to_mysql = quote_smart($link, $number_serving_calories_to);
		$query = $query . " AND number_serving_calories < $number_serving_calories_to_mysql";
	}

	if($number_serving_proteins_from != ""){
		$number_serving_proteins_from_mysql = quote_smart($link, $number_serving_proteins_from);
		$query = $query . " AND number_serving_proteins > $number_serving_proteins_from_mysql";
	}
	if($number_serving_proteins_to != ""){
		$number_serving_proteins_to_mysql = quote_smart($link, $number_serving_proteins_to);
		$query = $query . " AND number_serving_proteins < $number_serving_proteins_to_mysql";
	}


	if($number_serving_fat_from != ""){
		$number_serving_fat_from_mysql = quote_smart($link, $number_serving_fat_from);
		$query = $query . " AND number_serving_fat > $number_serving_fat_from_mysql";
	}
	if($number_serving_fat_to != ""){
		$number_serving_fat_to_mysql = quote_smart($link, $number_serving_fat_to);
		$query = $query . " AND number_serving_fat < $number_serving_fat_to_mysql";
	}


	if($number_serving_carbs_from != ""){
		$number_serving_carbs_from_mysql = quote_smart($link, $number_serving_carbs_from);
		$query = $query . " AND number_serving_carbs > $number_serving_carbs_from_mysql";
	}
	if($number_serving_carbs_to != ""){
		$number_serving_carbs_to_mysql = quote_smart($link, $number_serving_carbs_to);
		$query = $query . " AND number_serving_carbs < $number_serving_carbs_to_mysql";
	}

	// Order
	if($order_by != ""){
		if($order_method == "desc"){
			$order_method_mysql = "DESC";
		}
		else{
			$order_method_mysql = "ASC";
		}

		if($order_by == "recipe_id" OR $order_by == "recipe_title" OR $order_by == "recipe_unique_hits"){
			$order_by_mysql = "$t_recipes.$order_by";
		}
		elseif($order_by == "number_serving_calories" OR $order_by == "number_serving_fat" OR $order_by == "number_serving_carbs" OR $order_by == "number_serving_proteins"){
			$order_by_mysql = "$t_recipes_numbers.$order_by";
		}
		else{
			$order_by_mysql = "$t_recipes.recipe_id";
		}
		$query = $query . " ORDER BY $order_by_mysql $order_method_mysql";
		


	}

	//echo 	$query;
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_recipe_id, $get_recipe_title, $get_recipe_introduction, $get_recipe_image_path, $get_recipe_image, $get_recipe_unique_hits, $get_number_serving_calories, $get_number_serving_proteins, $get_number_serving_fat, $get_number_serving_carbs) = $row;

		if($get_recipe_image != ""){
		

			// 3 divs

			// 600 / 4 = 150
			// 600 / 3 = 200

			// Thumb

			$inp_new_x = 190;
			$inp_new_y = 98;
			$thumb = "recipe_" . $get_recipe_id . "-" . $inp_new_x . "x" . $inp_new_y . ".png";

			if(!(file_exists("$root/_cache/$thumb"))){
				resize_crop_image($inp_new_x, $inp_new_y, "$root/$get_recipe_image_path/$get_recipe_image", "$root/_cache/$thumb");
			}





			if($x == 0){
				echo"
				<div class=\"clear\"></div>
				<div class=\"left_center_right_left\">
				";
			}
			elseif($x == 1){
				echo"
				<div class=\"left_center_right_center\">
				";
			}
			elseif($x == 2){
				echo"
				<div class=\"left_center_right_right\">
				";
			}
		
			echo"
					<p class=\"recipe_open_category_img_p\">
					<a href=\"$root/recipes/view_recipe.php?recipe_id=$get_recipe_id\"><img src=\"$root/_cache/$thumb\" alt=\"$get_recipe_image\" width=\"$inp_new_x\" height=\"$inp_new_y\" /></a><br />
					</p>
					<p class=\"recipe_open_category_p\">
					<a href=\"$root/recipes/view_recipe.php?recipe_id=$get_recipe_id\" class=\"recipe_open_category_a\">$get_recipe_title</a>
					</p>

					<div class=\"recipe_open_category_unique_hits\">
						<img src=\"$root/recipes/_gfx/icons/ic_eye_grey_18px.png\" alt=\"eye.png\" style=\"float:left;padding-right: 5px;\" /> 
						<span class=\"recipe_open_category_unique_hits_span\">
						$get_recipe_unique_hits 
						</span>
					</div>



				</div>
			";

			// Increment
			$x++;
		
			// Reset
			if($x == 3){
				$x = 0;
			}

			$search_results_count++;
		} // get_recipe_image

	}

	if($x == 1){
		echo"
			<div class=\"left_center_right_center\">
			</div>
			<div class=\"left_center_right_right\">
			</div>
		";
	
	}
	elseif($x == 2){
		echo"
			<div class=\"left_center_right_right\">
			</div>
		";

	}

	// Search into database
	$my_ip = $_SERVER['REMOTE_ADDR'];
	$my_ip = output_html($my_ip);
	$my_ip_mysql = quote_smart($link, $my_ip);

	$datetime = date("Y-m-d H:i:s");
	$datetime_saying = date("j M Y");

	$search_query = str_replace("%", "", $q);
	$search_query_mysql = quote_smart($link, $search_query);
	$query = "SELECT search_id, search_unique_count, search_unique_ip_block FROM $t_recipes_searches WHERE search_query=$search_query_mysql AND search_language=$l_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_search_id, $get_search_unique_count, $get_search_unique_ip_block) = $row;

	if($get_search_id == ""){
		mysqli_query($link, "INSERT INTO $t_recipes_searches 
		(search_id, search_query, search_language, search_unique_count, search_unique_ip_block, search_first_datetime, search_first_saying, search_last_datetime, search_last_saying, search_found_recipes) 
		VALUES 
		(NULL, $search_query_mysql, $l_mysql, 1, $my_ip_mysql, '$datetime', '$datetime_saying', '$datetime', '$datetime_saying', $search_results_count)")
		or die(mysqli_error($link));
	}
	else{
		$unique_ip_block_array = explode("\n", $get_search_unique_ip_block);
		$size = sizeof($unique_ip_block_array);
		if($size > 10){
			$size = 1;
		}
		
		$count_me = 1;

		for($x=0;$x<$size;$x++){
			$ip = $unique_ip_block_array[$x];
			if($ip == "$my_ip"){
				$count_me = 0;
				break;
			}
		}
		
		if($count_me == "1"){
			$inp_search_unique_count = $get_search_unique_count+1;
			$inp_search_unique_ip_block = $get_search_unique_ip_block . "\n" . $my_ip;
		}
		else{
			$inp_search_unique_count = $get_search_unique_count;
			$inp_search_unique_ip_block = $get_search_unique_ip_block . "\n" . $my_ip;
		}
		$inp_search_unique_ip_block_mysql = quote_smart($link, $inp_search_unique_ip_block);


		$result = mysqli_query($link, "UPDATE $t_recipes_searches SET search_unique_count=$inp_search_unique_count, search_unique_ip_block=$inp_search_unique_ip_block_mysql, search_last_datetime='$datetime', search_last_saying='$datetime_saying', search_found_recipes=$search_results_count WHERE search_id=$get_search_id") or die(mysqli_error($link));

	}

	if($search_results_count == 0){
		echo"
		<p>$l_no_recipes_found</p>
		";

		// Send email to moderator
		$q = str_replace("%", "", $q);
		$q_encrypted = md5("$q");
		$q_antispam_file = "$root/_cache/recipe_search_no_results_" . $q_encrypted . ".txt";
		
		if(!(file_exists("$q_antispam_file"))){
			
			$fh = fopen($q_antispam_file, "w") or die("can not open file");
			fwrite($fh, "$q");
			fclose($fh);
			
		
			// Who is moderator of the week?
			$week = date("W");
			$year = date("Y");
	
			$query = "SELECT moderator_user_id, moderator_user_email, moderator_user_name FROM $t_users_moderator_of_the_week WHERE moderator_week=$week AND moderator_year=$year";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_moderator_user_id, $get_moderator_user_email, $get_moderator_user_name) = $row;
			if($get_moderator_user_id == ""){
				// Create moderator of the week
				include("$root/_admin/_functions/create_moderator_of_the_week.php");
					
				$query = "SELECT moderator_user_id, moderator_user_email, moderator_user_name FROM $t_users_moderator_of_the_week WHERE moderator_week=$week AND moderator_year=$year";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_moderator_user_id, $get_moderator_user_email, $get_moderator_user_name) = $row;
			}




			// Mail from
			$search_link = $configSiteURLSav . "/recipes/search.php?q=$q&amp;l=$l";
			$subject = "No search result for $q at $configWebsiteTitleSav";

			$message = "<html>\n";
			$message = $message. "<head>\n";
			$message = $message. "  <title>$subject</title>\n";
			$message = $message. " </head>\n";
			$message = $message. "<body>\n";

			$message = $message . "<p>Hi $get_moderator_user_name,</p>\n\n";
			$message = $message . "<p><b>Summary:</b><br />A user has searched for <em>$q</em> and got no search results at $configWebsiteTitleSav for lanugage $l.\n";
			$message = $message . "Please consider to add a recipe for that query.</p>\n\n";

			$message = $message . "<p style='padding-bottom:0;margin-bottom:0'><b>Search information:</b></p>\n";
			$message = $message . "<table>\n";
			$message = $message . " <tr><td><span>Query:</span></td><td><span>$q</span></td></tr>\n";
			$message = $message . " <tr><td><span>Link:</span></td><td><span><a href=\"$search_link\">$search_link</a></span></td></tr>\n";
			$message = $message . "</table>\n";

			$message = $message . "<p>\n\n--<br />\nBest regards<br />\n$configWebsiteTitleSav</p>";
			$message = $message. "</body>\n";
			$message = $message. "</html>\n";


			$encoding = "utf-8";

			// Preferences for Subject field
			$subject_preferences = array(
			       "input-charset" => $encoding,
			       "output-charset" => $encoding,
			       "line-length" => 76,
			       "line-break-chars" => "\r\n"
			);
			$header = "Content-type: text/html; charset=".$encoding." \r\n";
			$header .= "From: ".$configFromNameSav." <".$configFromEmailSav."> \r\n";
			$header .= "MIME-Version: 1.0 \r\n";
			$header .= "Content-Transfer-Encoding: 8bit \r\n";
			$header .= "Date: ".date("r (T)")." \r\n";
			$header .= iconv_mime_encode("Subject", $subject, $subject_preferences);

			mail($get_moderator_user_email, $subject, $message, $header);

			echo"<p>Our moderator $get_moderator_user_name will look at this query and maybe add a recipe for it later.</p>";
		}
	}
}
else{
	echo"
	<p>$l_type_your_search_in_the_search_field</p>
	";
}
echo"
		</div>
	<!-- Left and right -->

";



/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>