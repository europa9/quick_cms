<?php 
/**
*
* File: food/store_new.php
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
include("_tables_food.php");


/*- Translation ------------------------------------------------------------------------ */
include("$root/_admin/_translations/site/$l/food/ts_food.php");


/*- Variables ------------------------------------------------------------------------- */
$tabindex = 0;
$l_mysql = quote_smart($link, $l);

if(isset($_GET['store_id'])){
	$store_id= $_GET['store_id'];
	$store_id = strip_tags(stripslashes($store_id));
}
else{
	$store_id = "";
}
$store_id_mysql = quote_smart($link, $store_id);

// Fetch store
$query = "SELECT store_id, store_user_id, store_name, store_country, store_language, store_website, store_logo FROM $t_food_stores WHERE store_id=$store_id_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_current_store_id, $get_current_store_user_id, $get_current_store_name, $get_current_store_country, $get_current_store_language, $get_current_store_website, $get_current_store_logo) = $row;





/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_food - $l_edit_store $get_current_store_name";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");

/*- Content ---------------------------------------------------------------------------------- */

// Logged in?
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	
	// My user id
	$my_user_id = $_SESSION['user_id'];
	$my_user_id = output_html($my_user_id);

	if($get_current_store_id == ""){
		echo"
		<p>Store not found</p>
		";
	}
	else{
		if($get_current_store_user_id == "$my_user_id"){

			if($process == "1"){
				$inp_name = $_POST['inp_name'];
				$inp_name = output_html($inp_name);
				$inp_name_mysql = quote_smart($link, $inp_name);
				if(empty($inp_name)){
					$ft = "error";
					$fm = "missing_name";
				}

				$inp_country = $_POST['inp_country'];
				$inp_country = output_html($inp_country);
				$inp_country_mysql = quote_smart($link, $inp_country);
				if(empty($inp_country)){
					$ft = "error";
					$fm = "missing_country";
				}

				$inp_website = $_POST['inp_website'];
				$inp_website = output_html($inp_website);
				$inp_website_mysql = quote_smart($link, $inp_website);
				if(empty($inp_website)){
					$ft = "error";
					$fm = "missing_website";
				}

		


				if($ft == ""){
					if($l == ""){
						echo"Missing l";die;
					}
					$inp_l = output_html($l);
					$inp_l_mysql = quote_smart($link, $inp_l);
					
		
					// IP 
					$inp_my_ip = $_SERVER['REMOTE_ADDR'];
					$inp_my_ip = output_html($inp_my_ip);
					$inp_my_ip_mysql = quote_smart($link, $inp_my_ip);

					// Datetime (notes)
					$datetime = date("Y-m-d H:i:s");
					$datetime_print = date("j M Y");

					mysqli_query($link, "UPDATE $t_food_stores SET
					store_name=$inp_name_mysql, store_country=$inp_country_mysql,  
					store_language=$inp_l_mysql, store_website=$inp_website_mysql, 
					store_updatet_datetime='$datetime', store_updatet_datetime_print='$datetime_print', store_user_ip=$inp_my_ip_mysql
					WHERE store_id=$get_current_store_id") or die(mysqli_error($link));

		

					$url = "my_stores_edit.php?store_id=$store_id&l=$l&ft=success&fm=changes_saved";
					header("Location: $url");
					exit;
				}
				else{
					$url = "my_stores_edit.php?store_id=$store_id&l=$l";
					$url = $url . "&ft=$ft&fm=$fm";
					$url = $url . "&inp_name=$inp_name";
					$url = $url . "&inp_country=$inp_country";
					$url = $url . "&inp_website=$inp_website";

					header("Location: $url");
					exit;
				}	
			} // process == 1

			echo"
			<h1>$get_current_store_name</h1>

			<!-- Feedback -->
			";
			if($ft != "" && $fm != ""){
				if($fm == "missing_energy"){
					$fm = "Please enter energy";
				}
				elseif($fm == "missing_proteins"){
					$fm = "Please enter proteins";
				}
				elseif($fm == "missing_carbohydrates"){
					$fm = "Please enter carbohydrates";
				}
				elseif($fm == "missing_fat"){
					$fm = "Please enter fat";
				}
				else{
						$fm = ucfirst($fm);
				}
				echo"<div class=\"$ft\"><p>$fm</p></div>";	
			}
			echo"
			<!-- //Feedback -->

			<!-- Edit store form -->
				<!-- Focus -->
				<script>
					\$(document).ready(function(){
						\$('[name=\"inp_name\"]').focus();
					});
				</script>
				<!-- //Focus -->
				<form method=\"post\" action=\"my_stores_edit.php?store_id=$store_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">


				<p>$l_name*:<br />
				<input type=\"text\" name=\"inp_name\" value=\"$get_current_store_name\" size=\"25\" /></p>

				<p>$l_country*:<br />
				<select name=\"inp_country\">";
				$prev_country = "";
				$query = "SELECT language_flag FROM $t_languages ORDER BY language_flag ASC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_language_flag) = $row;

					$country = str_replace("_", " ", $get_language_flag);
					$country = ucwords($country);
					if($country != "$prev_country"){
						echo"			";
						echo"<option value=\"$country\""; if($get_current_store_country == "$country"){ echo" selected=\"selected\""; } echo">$country</option>\n";
					}
					$prev_country = "$country";
				}
				echo"
				</select>

				<p>$l_website*:<br />
				<input type=\"text\" name=\"inp_website\" value=\"$get_current_store_website\" size=\"25\" /></p>



				<p><input type=\"submit\" value=\"$l_save\" class=\"btn_default\" /></p>
			<!-- //Edit store form -->

			<p>
			<a href=\"my_stores.php?l=$l\"><img src=\"_gfx/icons/go-previous.png\" alt=\"go-previous.png\" /></a>
			<a href=\"my_stores.php?l=$l\">$l_go_back</a>
			&nbsp;
			<a href=\"my_stores_delete.php?store_id=$get_current_store_id&amp;l=$l\"><img src=\"_gfx/icons/delete.png\" alt=\"delete.png\" /></a>
			<a href=\"my_stores_delete.php?store_id=$get_current_store_id&amp;l=$l\">$l_delete_store</a>
			</p>
			";
		}
		else{
			echo"<p>Access denied</p";
		} // inncorrect user
	} // store found

}
else{
	echo"
	<h1>
	<img src=\"$root/_webdesign/images/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" />
	Loading...</h1>
	<meta http-equiv=\"refresh\" content=\"1;url=$root/users/index.php?page=login&amp;l=$l&amp;refer=$root/food/new_food.php\">
	";
}



/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>