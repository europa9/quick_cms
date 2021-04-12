<?php
/**
*
* File: _admin/_inc/food/age_restrictions.php
* Version 15:27 12.04.2021
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
$t_food_liquidbase			= $mysqlPrefixSav . "food_liquidbase";
$t_food_age_restrictions 	 	= $mysqlPrefixSav . "food_age_restrictions";
$t_food_age_restrictions_accepted	= $mysqlPrefixSav . "food_age_restrictions_accepted";
$t_food_categories		  	= $mysqlPrefixSav . "food_categories";
$t_food_categories_translations	  	= $mysqlPrefixSav . "food_categories_translations";
$t_food_index			  	= $mysqlPrefixSav . "food_index";
$t_food_index_stores		  	= $mysqlPrefixSav . "food_index_stores";
$t_food_index_ads		  	= $mysqlPrefixSav . "food_index_ads";
$t_food_index_tags		  	= $mysqlPrefixSav . "food_index_tags";
$t_food_index_prices		  	= $mysqlPrefixSav . "food_index_prices";
$t_food_index_contents		  	= $mysqlPrefixSav . "food_index_contents";
$t_food_stores		  	  	= $mysqlPrefixSav . "food_stores";
$t_food_prices_currencies	  	= $mysqlPrefixSav . "food_prices_currencies";
$t_food_favorites 		  	= $mysqlPrefixSav . "food_favorites";
$t_food_measurements	 	  	= $mysqlPrefixSav . "food_measurements";
$t_food_measurements_translations 	= $mysqlPrefixSav . "food_measurements_translations";

/*- Functions ----------------------------------------------------------------------- */

/*- Check if setup is run ------------------------------------------------------------- */
if($action == ""){
	echo"
	<h1>Age Restrictions</h1>


	<!-- Get all age restrictions -->
		<div class=\"vertical\">
			<ul>";
			$query = "SELECT restriction_id, restriction_country_name, restriction_country_flag_path_16x16, restriction_country_flag_16x16 FROM $t_food_age_restrictions ORDER BY restriction_country_name ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_restriction_id, $get_restriction_country_name, $get_restriction_country_flag_path_16x16, $get_restriction_country_flag_16x16) = $row;

				echo"				";
				echo"<li><a href=\"index.php?open=food&amp;page=age_restrictions&amp;action=edit&amp;restriction_id=$get_restriction_id&amp;editor_language=$editor_language&amp;l=$l\"><img src=\"../$get_restriction_country_flag_path_16x16/$get_restriction_country_flag_16x16\" alt=\"$get_restriction_country_flag_16x16\" /> $get_restriction_country_name</a>\n";
			}
			echo"
			</ul>
		</div>
	<!-- //Get all age restrictions -->
	";
}
elseif($action == "edit"){
	// Variables
	$restriction_id = $_GET['restriction_id'];
	$restriction_id = output_html($restriction_id);
	if(!(is_numeric($restriction_id))){
		echo"Restriction id not numeric";
		die;
	}
	$restriction_id_mysql = quote_smart($link, $restriction_id);
	
	// Select restriction
	$query = "SELECT restriction_id, restriction_country_iso_two, restriction_country_name, restriction_country_flag_path_16x16, restriction_country_flag_16x16, restriction_language, restriction_age_limit, restriction_title, restriction_text, restriction_can_view_food, restriction_can_view_images FROM $t_food_age_restrictions WHERE restriction_id=$restriction_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_restriction_id, $get_current_restriction_country_iso_two, $get_current_restriction_country_name, $get_current_restriction_country_flag_path_16x16, $get_current_restriction_country_flag_16x16, $get_current_restriction_language, $get_current_restriction_age_limit, $get_current_restriction_title, $get_current_restriction_text, $get_current_restriction_can_view_food, $get_current_restriction_can_view_images) = $row;

	if($get_current_restriction_id == ""){
		echo"
		<h1>Server error 404</h1>
		<p>Restriction not found.</p>
		";
	}
	else{
		if($process == "1"){
			$inp_age_limit = $_POST['inp_age_limit'];
			$inp_age_limit = output_html($inp_age_limit);
			$inp_age_limit_mysql = quote_smart($link, $inp_age_limit);

			$inp_title = $_POST['inp_title'];
			$inp_title = output_html($inp_title);
			$inp_title_mysql = quote_smart($link, $inp_title);

			$inp_text = $_POST['inp_text'];
			$inp_text = output_html($inp_text);
			$inp_text_mysql = quote_smart($link, $inp_text);

			$inp_can_view_food = $_POST['inp_can_view_food'];
			$inp_can_view_food= output_html($inp_can_view_food);
			$inp_can_view_food_mysql = quote_smart($link, $inp_can_view_food);


			$inp_can_view_images = $_POST['inp_can_view_images'];
			$inp_can_view_images = output_html($inp_can_view_images);
			$inp_can_view_images_mysql = quote_smart($link, $inp_can_view_images);


			$result = mysqli_query($link, "UPDATE $t_food_age_restrictions SET 
							restriction_age_limit=$inp_age_limit_mysql,
							restriction_title=$inp_title_mysql,
							restriction_text=$inp_text_mysql,
							restriction_can_view_food=$inp_can_view_food_mysql,
							restriction_can_view_images=$inp_can_view_images_mysql
							WHERE restriction_id=$get_current_restriction_id") or die(mysqli_error($link));

			$url = "index.php?open=$open&page=$page&action=edit&restriction_id=$get_current_restriction_id&editor_language=$editor_language&l=$l&ft=success&fm=changes_saved";
			header("Location: $url");
			exit;
		}


		echo"
		<h1>$get_current_restriction_country_name</h1>

		<!-- Where am I ? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=$open&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Age restrictions</a>
			&gt;
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=edit&amp;restriction_id=$get_current_restriction_id&amp;editor_language=$editor_language&amp;l=$l\">Edit $get_current_restriction_country_name</a>
			</p>
		<!-- //Where am I ? -->


		<!-- Feedback -->
		";
		if($ft != ""){
			$fm = str_replace("_", " ", $fm);
			$fm = ucfirst($fm);
			echo"<div class=\"$ft\"><span>$fm</span></div>";
		}
		echo"	
		<!-- //Feedback -->

		<!-- Edit restriction form -->
			<!-- Focus -->
				<script>
				\$(document).ready(function(){
					\$('[name=\"inp_age_limit\"]').focus();
				});
				</script>
			<!-- //Focus -->

			<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=edit&amp;restriction_id=$get_current_restriction_id&amp;editor_language=$editor_language&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
			
			<p>
			<a href=\"index.php?open=settings&amp;page=languages&amp;action=edit_countries&amp;editor_language=$editor_language&amp;l=$l\">Edit country</a>
			</p>

			<p>Age limit:<br />
			<input type=\"text\" name=\"inp_age_limit\" value=\"$get_current_restriction_age_limit\" size=\"25\" />
			</p>

			<p>Title:<br />
			<input type=\"text\" name=\"inp_title\" value=\"$get_current_restriction_title\" size=\"25\" />
			</p>

			<p>Text:<br />
			<textarea name=\"inp_text\" cols=\"100\" rows=\"20\">$get_current_restriction_text</textarea>
			</p>

			<p>Can view food<br />
			<input type=\"radio\" name=\"inp_can_view_food\" value=\"1\""; if($get_current_restriction_can_view_food == "1"){ echo" checked=\"checked\""; } echo" /> Yes
			<input type=\"radio\" name=\"inp_can_view_food\" value=\"0\""; if($get_current_restriction_can_view_food == "0"){ echo" checked=\"checked\""; } echo" /> No
			</p>

			<p>Can view images<br />
			<input type=\"radio\" name=\"inp_can_view_images\" value=\"1\""; if($get_current_restriction_can_view_images == "1"){ echo" checked=\"checked\""; } echo" /> Yes
			<input type=\"radio\" name=\"inp_can_view_images\" value=\"0\""; if($get_current_restriction_can_view_images == "0"){ echo" checked=\"checked\""; } echo" /> No
			</p>

			<p> 
			<input type=\"submit\" value=\"Save changes\" class=\"btn\" />
			</p>
			</form>
					
		<!-- //Edit restriction form -->
		";
	} // found
} // action == edit


?>