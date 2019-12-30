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


/*- Translation ------------------------------------------------------------------------ */
include("$root/_admin/_translations/site/$l/food/ts_food.php");


/*- Variables ------------------------------------------------------------------------- */
$tabindex = 0;
$l_mysql = quote_smart($link, $l);




/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_food - $l_new_store";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");

/*- Content ---------------------------------------------------------------------------------- */

// Logged in?
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	
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
					
			$inp_my_user_id = $_SESSION['user_id'];
			$inp_my_user_id = output_html($inp_my_user_id);
			$inp_my_user_id_mysql = quote_smart($link, $inp_my_user_id);

			// IP 
			$inp_my_ip = $_SERVER['REMOTE_ADDR'];
			$inp_my_ip = output_html($inp_my_ip);
			$inp_my_ip_mysql = quote_smart($link, $inp_my_ip);

			// Datetime (notes)
			$datetime = date("Y-m-d H:i:s");
			$datetime_print = date("j M Y");

			mysqli_query($link, "INSERT INTO $t_food_stores
				(store_id, store_user_id, store_name, store_country, 
				store_language, store_website, store_logo, store_added_datetime, 
				store_added_datetime_print, store_updatet_datetime, store_updatet_datetime_print, store_user_ip, 
				store_reported, store_reported_checked) 
				VALUES 
				(NULL, $inp_my_user_id_mysql, $inp_name_mysql, $inp_country_mysql,
				$inp_l_mysql, $inp_website_mysql, '', '$datetime',
				'$datetime_print', '$datetime', '$datetime_print', $inp_my_ip_mysql, 
				'0', '')")
				or die(mysqli_error($link));

			// Get _id
			$query = "SELECT store_id FROM $t_food_stores WHERE store_user_id=$inp_my_user_id_mysql AND store_name=$inp_name_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_store_id) = $row;
	

			$url = "my_stores.php?l=$l&ft=success&fm=store_added";
			header("Location: $url");
			exit;
		}
		else{
			$url = "my_stores_new.php?l=$l";
			$url = $url . "&ft=$ft&fm=$fm";
			$url = $url . "&inp_name=$inp_name";
			$url = $url . "&inp_country=$inp_country";
			$url = $url . "&inp_website=$inp_website";

			header("Location: $url");
			exit;
		}	
	} // process == 1

	echo"
	<h1>$l_new_store</h1>
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

	<!-- New store form -->
		<!-- Focus -->
		<script>
			\$(document).ready(function(){
				\$('[name=\"inp_name\"]').focus();
			});
		</script>
		<!-- //Focus -->
		<form method=\"post\" action=\"my_stores_new.php?l=$l&amp;process=1\" enctype=\"multipart/form-data\">


		<p>$l_name*:<br />
		<input type=\"text\" name=\"inp_name\" value=\"";
		if(isset($_GET['inp_name'])){
			$inp_name= $_GET['inp_name'];
			$inp_name = output_html($inp_name);
			echo"$inp_name";
		}
		echo"\" size=\"25\" /></p>

		<p>$l_country*:<br />
		<select name=\"inp_country\">";
			if(isset($_GET['inp_country'])){
				$inp_country = $_GET['inp_country'];
				$inp_country = output_html($inp_country);
			}
			else{
				// Fetch last country used
				$query = "SELECT store_country FROM $t_food_stores ORDER BY store_id DESC LIMIT 0,1";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($inp_country) = $row;
			}
			$prev_country = "";
			$query = "SELECT language_flag FROM $t_languages ORDER BY language_flag ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_language_flag) = $row;

				$country = str_replace("_", " ", $get_language_flag);
				$country = ucwords($country);
				if($country != "$prev_country"){
					echo"			";
					echo"<option value=\"$country\""; if(isset($inp_country) && $inp_country == "$country"){ echo" selected=\"selected\""; } echo">$country</option>\n";
				}
				$prev_country = "$country";
		}
		echo"
		</select>

		<p>$l_website*:<br />
		<input type=\"text\" name=\"inp_website\" value=\"";
		if(isset($_GET['inp_website'])){
			$inp_website= $_GET['inp_website'];
			$inp_website = output_html($inp_website);
			echo"$inp_website";
		}
		echo"\" size=\"25\" /></p>



		<p><input type=\"submit\" value=\"$l_save_store\" class=\"btn_default\" /></p>
	<!-- //New store form -->
		
	";
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