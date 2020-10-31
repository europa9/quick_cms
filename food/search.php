<?php 
/**
*
* File: food/search.php
* Version 1.0.0
* Date 15:38 21.01.2018
* Copyright (c) 2018 S. A. Ditlefsen
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
if(isset($_GET['search_query'])) {
	$search_query = $_GET['search_query'];
	$search_query = strip_tags(stripslashes($search_query));

	if($search_query == "$l_search..."){
		$search_query = "";
	}
}
else{
	$search_query = "";
}
if(isset($_GET['order_by'])) {
	$order_by = $_GET['order_by'];
	$order_by = strip_tags(stripslashes($order_by));
}
else{
	$order_by = "food_score";
}
if(isset($_GET['order_method'])) {
	$order_method = $_GET['order_method'];
	$order_method = strip_tags(stripslashes($order_method));
}
else{
	$order_method = "";
}

if(isset($_GET['manufacturer_name'])) {
	$manufacturer_name = $_GET['manufacturer_name'];
	$manufacturer_name = strip_tags(stripslashes($manufacturer_name));
}
else{
	$manufacturer_name = "";
}
if(isset($_GET['store_id'])) {
	$store_id = $_GET['store_id'];
	$store_id = strip_tags(stripslashes($store_id));
}
else{
	$store_id = "";
}
$store_id_mysql = quote_smart($link, $store_id);

if(isset($_GET['barcode'])) {
	$barcode = $_GET['barcode'];
	$barcode = strip_tags(stripslashes($barcode));
}
else{
	$barcode = "";
}

/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_food - $l_search"; 
if($search_query != ""){
	$website_title = $website_title .  " - $search_query"; 
}
if($manufacturer_name != ""){
	$website_title = $website_title .  " - $manufacturer_name"; 
}
if($store_id != ""){
	$website_title = $website_title .  " - $store_id";
}
if($barcode != ""){
	$website_title = $website_title .  " - $barcode";
}

if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");

/*- Content ---------------------------------------------------------------------------------- */
echo"
<!-- Search -->
	<div style=\"float: right;padding-top: 12px;\">
		<form method=\"get\" action=\"search.php\" enctype=\"multipart/form-data\">
		<p>
		<input type=\"text\" name=\"search_query\" value=\"$search_query\" size=\"10\" id=\"nettport_inp_search_query\" />
		<input type=\"hidden\" name=\"l\" value=\"$l\" />
		<input type=\"submit\" value=\"$l_search\" id=\"nettport_search_submit_button\" class=\"btn_default\" />
		<a href=\"#\" class=\"content_left_hide_view_a btn_default\">$l_advanced</a>
		</p>
		</form>	
		<!-- Advanced search hide view -->
			<script>
			\$(document).ready(function(){
				\$(\".content_left_hide_view_a\").click(function () {
					\$(\".advanced_search_hide_show\").toggle();
				});
			});
			</script>
		<!-- //Advanced search hide view -->
	</div>
<!-- //Search -->


<h1>$l_search</h1>

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

<!-- Advanced search -->
	<div class=\"advanced_search_hide_show\" style=\"background:#f6f6f6;border: #ccc 1px solid;padding: 0px 20px 0px 20px;margin: 10px 0px 10px 0px;";
	if($manufacturer_name != "" OR $store_id != "" OR $barcode != ""){
		echo"display: inline-block;";
	}
	echo"\">

		<p style=\"margin:0;padding: 10px 0px 0px 0px;\"><b>$l_specific_search</b></p>

        	<form method=\"get\" action=\"search.php\" enctype=\"multipart/form-data\">
		
		<table>
		 <tr>
		  <td style=\"padding-right: 20px;vertical-align:top;\">
			<p>$l_query<br />
			<input type=\"text\" name=\"q\" value=\""; 
				if($search_query != ""){
					echo"$search_query"; 
				}
				else{
					echo"$l_search..."; $q = "";
				} echo"\" size=\"15\" id=\"food_search_q\" />
			<input type=\"submit\" value=\"$l_search\" class=\"btn btn_default\" />
			</p>

			<p>$l_barcode<br />
			<input type=\"text\" name=\"barcode\" value=\""; if($barcode != ""){ echo"$barcode"; } else{  }  echo"\" size=\"15\" class=\"recipe_search_text\" />
			<input type=\"submit\" value=\"$l_search\" class=\"btn btn_default\" />
			</p>
		  </td>
		  <td style=\"padding-right: 20px;vertical-align:top;\">
			<p>$l_manufacturer<br />
			<input type=\"text\" name=\"manufacturer_name\" value=\""; if($manufacturer_name != ""){ echo"$manufacturer_name"; } else{  }  echo"\" size=\"15\" class=\"recipe_search_text\" />
			<input type=\"submit\" value=\"$l_search\" class=\"btn btn_default\" />
			</p>

			<p>$l_store<br />
			<select name=\"store_id\">
				<option value=\"\""; if($store_id == ""){ echo" selected=\"selected\""; } echo"> </option>\n";
			$query = "SELECT store_id, store_name FROM $t_food_stores WHERE store_user_id=$my_user_id_mysql AND store_language=$l_mysql ORDER BY store_name ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_store_id, $get_store_name) = $row;
				echo"	<option value=\"$get_store_id\""; if($store_id == "$get_store_id"){ echo" selected=\"selected\""; } echo">$get_store_name</option>\n";
			}
			echo"</select>
			<input type=\"submit\" value=\"$l_search\" class=\"btn btn_default\" />
			</p>
		  </td>
		 </tr>
		 <tr>
		  <td style=\"padding-right: 20px;vertical-align:top;\">
			<p>$l_order_by<br />
			<select name=\"order_by\">
				<option value=\"\">- $l_order_by -</option>
				<option value=\"food_id\""; if($order_by == "food_id" OR $order_by == ""){ echo" selected=\"selected\""; } echo">$l_date</option>
				<option value=\"food_name\""; if($order_by == "food_name"){ echo" selected=\"selected\""; } echo">$l_name</option>
				<option value=\"recipe_unique_hits\""; if($order_by == "food_unique_hits"){ echo" selected=\"selected\""; } echo">$l_unique_hits</option>
				<option value=\"food_energy\""; if($order_by == "food_energy"){ echo" selected=\"selected\""; } echo">$l_calories</option>
				<option value=\"food_proteins\""; if($order_by == "food_proteins"){ echo" selected=\"selected\""; } echo">$l_fat</option>
				<option value=\"food_carbohydrates\""; if($order_by == "food_carbohydrates"){ echo" selected=\"selected\""; } echo">$l_carbs</option>
				<option value=\"food_fat\""; if($order_by == "food_fat"){ echo" selected=\"selected\""; } echo">$l_proteins</option>
				<option value=\"food_score\""; if($order_by == "food_score"){ echo" selected=\"selected\""; } echo">$l_score</option>
			</select>
			</p>
		  </td>
		  <td style=\"padding-right: 20px;vertical-align:top;\">
			<p>$l_method<br />
			<select name=\"order_method\">
				<option value=\"asc\""; if($order_method == "asc" OR $order_method == ""){ echo" selected=\"selected\""; } echo">$l_asc</option>
				<option value=\"desc\""; if($order_method == "desc"){ echo" selected=\"selected\""; } echo">$l_desc</option>
			</select>
			</p>
		  </td>
		 </tr>
		</table>
		</form>
	</div>

<!-- //Advanced search -->
	

";

if($search_query != "" OR $manufacturer_name != "" OR $store_id != "" OR $barcode != ""){
	
	$search_results_count = 0;

	
	// Set layout
	$x = 0;
	$show_food = "true";

	$query = "SELECT food_id, food_user_id, food_name, food_manufacturer_name, food_description, food_serving_size_gram, food_serving_size_gram_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, food_energy, food_proteins, food_carbohydrates, food_fat, food_energy_calculated, food_proteins_calculated, food_carbohydrates_calculated, food_fat_calculated, food_barcode, food_main_category_id, food_sub_category_id, food_image_path, food_image_a, food_thumb_a_small FROM $t_food_index";
	$query = $query . "  WHERE food_language=$l_mysql";

	if($search_query != ""){
		$search_query = "%" . $search_query . "%";
		$search_query_mysql = quote_smart($link, $search_query);
		$query = $query . " AND ($t_food_index.food_name LIKE $search_query_mysql OR $t_food_index.food_manufacturer_name LIKE $search_query_mysql)";
	}

	if($manufacturer_name != ""){
		$manufacturer_name_q = "%" . $manufacturer_name . "%";
		$manufacturer_name_mysql = quote_smart($link, $manufacturer_name_q);
		$query = $query . " AND $t_food_index.food_manufacturer_name LIKE $manufacturer_name_mysql";
	}

	if($barcode != ""){
		$barcode_mysql = quote_smart($link, $barcode);
		$query = $query . " AND $t_food_index.food_barcode=$barcode_mysql";
	}

	// Order
	if($order_by != ""){
		if($order_method == "desc"){
			$order_method_mysql = "DESC";
		}
		else{
			$order_method_mysql = "ASC";
		}

		if($order_by == "food_id" OR $order_by == "food_name" OR $order_by == "food_unique_hits" OR $order_by == "food_score"){
			$order_by_mysql = "$order_by";
		}
		else{
			$order_by_mysql = "food_id";
		}
		$query = $query . " ORDER BY $order_by_mysql $order_method_mysql";
		

	}
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_food_id, $get_food_user_id, $get_food_name, $get_food_manufacturer_name, $get_food_description, $get_food_serving_size_gram, $get_food_serving_size_gram_measurement, $get_food_serving_size_pcs, $get_food_serving_size_pcs_measurement, $get_food_energy, $get_food_proteins, $get_food_carbohydrates, $get_food_fat, $get_food_energy_calculated, $get_food_proteins_calculated, $get_food_carbohydrates_calculated, $get_food_fat_calculated, $get_food_barcode, $get_food_main_category_id, $get_food_sub_category_id, $get_food_image_path, $get_food_thumb_medium, $get_food_thumb_a_small) = $row;

		if(file_exists("$root/$get_food_image_path/$get_food_thumb_a_small") && $get_food_thumb_a_small != ""){
			// Store?
			if($store_id != ""){
				$query_store = "SELECT food_store_id FROM $t_food_index_stores WHERE food_store_food_id=$get_food_id AND food_store_store_id=$store_id_mysql";
				$result_store = mysqli_query($link, $query_store);
				$row_store = mysqli_fetch_row($result_store);
				list($get_food_store_id) = $row_store;
				if($get_food_store_id == ""){
					$show_food = "false";
				}
				else{
					$show_food = "true";
				}
			}


			if($show_food == "true"){
			
				// 3 divs

				// 600 / 4 = 150
				// 600 / 3 = 200




				if($x == 0){
					echo"
					<div class=\"clear\"></div>
					<div class=\"left_center_center_right_left\" style=\"text-align: center;padding-bottom: 20px;\">
					";
				}
				elseif($x == 1){
					echo"
					<div class=\"left_center_center_left_right_center\" style=\"text-align: center;padding-bottom: 20px;\">
					";
				}
				elseif($x == 2){
					echo"
					<div class=\"left_center_center_right_right_center\" style=\"text-align: center;padding-bottom: 20px;\">
					";
				}
				elseif($x == 3){
					echo"
					<div class=\"left_center_center_right_right\" style=\"text-align: center;padding-bottom: 20px;\">
					";
				}
		
				echo"
						<div style=\"text-align: center;\">
							<p class=\"recipe_open_category_img_p\">
							<a href=\"view_food.php?main_category_id=$get_food_main_category_id&amp;sub_category_id=$get_food_sub_category_id&amp;food_id=$get_food_id&amp;l=$l\"><img src=\"$root/$get_food_image_path/$get_food_thumb_a_small\" alt=\"$get_food_thumb_a_small\" /></a><br />
							</p>
		
							<p class=\"recipe_open_category_p\">
							<a href=\"view_food.php?main_category_id=$get_food_main_category_id&amp;sub_category_id=$get_food_sub_category_id&amp;food_id=$get_food_id&amp;l=$l\" class=\"recipe_open_category_a\">$get_food_name</a>
							</p>

						</div>
						<div style=\"width: 127px; margin: 0 auto;padding-bottom: 10px;\">
							<table>
							 <tr>
							  <td style=\"text-align:center;padding-right: 10px\">
								<span class=\"smal\">$get_food_energy kcal</span>
							  </td>
							  <td style=\"text-align:center;padding-right: 10px\">
								<span class=\"smal\">$get_food_fat fat</span>
							  </td>
							  <td style=\"text-align:center;padding-right: 10px\">
								<span class=\"smal\">$get_food_carbohydrates carb</span>
							  </td>
							  <td style=\"text-align:center;\">
								<span class=\"smal\">$get_food_proteins proteins</span>
							  </td>
							 </tr>
							</table>
						</div>
				</div>
				";

				// Increment
				$x++;
		
				// Reset
				if($x == 4){
					$x = 0;
				}

				$search_results_count++;
			} // show food
		} // get_recipe_image

	} // while

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


	if($search_results_count == 0){
		echo"
		<p>$l_no_food_found</p>
		";

		// Send email to moderator
		$search_query = str_replace("%", "", $search_query);
		$search_query_encrypted = md5("$search_query");
		$search_query_antispam_file = "$root/_cache/recipe_search_no_results_" . $search_query_encrypted . ".txt";
		
		if(!(file_exists("$search_query_antispam_file"))){
			
			$fh = fopen($search_query_antispam_file, "w") or die("can not open file");
			fwrite($fh, "$search_query");
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
			$host = $_SERVER['HTTP_HOST'];
			$from = "$configFromEmailSav";
			$reply = "$configFromEmailSav";
			
			$search_link = $configSiteURLSav . "/food/search.php?q=$q&amp;l=$l";
			$subject = "No search result for $search_query at $host";

			$message = "<html>\n";
			$message = $message. "<head>\n";
			$message = $message. "  <title>$subject</title>\n";
			$message = $message. " </head>\n";
			$message = $message. "<body>\n";

			$message = $message . "<p>Hi $get_moderator_user_name,</p>\n\n";
			$message = $message . "<p><b>Summary:</b><br />A user has searched for <em>$search_query</em> and got no search results at $host for lanugage $l.\n";
			$message = $message . "Please consider to add a recipe for that query.</p>\n\n";

			$message = $message . "<p style='padding-bottom:0;margin-bottom:0'><b>Search information:</b></p>\n";
			$message = $message . "<table>\n";
			$message = $message . " <tr><td><span>Query:</span></td><td><span>$search_query</span></td></tr>\n";
			$message = $message . " <tr><td><span>Link:</span></td><td><span><a href=\"$search_link\">$search_link</a></span></td></tr>\n";
			$message = $message . "</table>\n";

			$message = $message . "<p>\n\n--<br />\nBest regards<br />\n$host</p>";
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
			$header .= "From: ".$host." <".$from."> \r\n";
			$header .= "MIME-Version: 1.0 \r\n";
			$header .= "Content-Transfer-Encoding: 8bit \r\n";
			$header .= "Date: ".date("r (T)")." \r\n";
			$header .= iconv_mime_encode("Subject", $subject, $subject_preferences);

			mail($get_moderator_user_email, $subject, $message, $header);

			// echo"<p>Our moderator $get_moderator_user_name will look at this query and maybe add a recipe for it later.</p>";
		}
	}
}
else{
	echo"
	<p>$l_type_your_search_in_the_search_field</p>
	";
}
echo"

";



/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>