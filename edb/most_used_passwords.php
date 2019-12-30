<?php 
/**
*
* File: edb/most_used_passwords.php
* Version 1.0
* Date 22:39 29.08.2019
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

/*- Tables ---------------------------------------------------------------------------- */
$t_edb_most_used_passwords 			= $mysqlPrefixSav . "edb_most_used_passwords";
$t_edb_case_index_usr_psw 			= $mysqlPrefixSav . "edb_case_index_usr_psw";
$t_edb_item_types_available_passwords		= $mysqlPrefixSav . "edb_item_types_available_passwords";
$t_edb_case_index_evidence_items_passwords 	= $mysqlPrefixSav . "edb_case_index_evidence_items_passwords";
$t_edb_most_used_passwords		 	= $mysqlPrefixSav . "edb_most_used_passwords";

/*- Language --------------------------------------------------------------------------- */
include("$root/_admin/_translations/site/$l/edb/ts_edb.php");
include("$root/_admin/_translations/site/$l/edb/ts_cases_board_1_view_district.php");

/*- Variables -------------------------------------------------------------------------- */
if(isset($_GET['show'])) {
	$show = $_GET['show'];
	$show = strip_tags(stripslashes($show));
}
else{
	$show = "";
}
$show = output_html($show);
$show_mysql = quote_smart($link, $show);


if(isset($_GET['available_type'])) {
	$available_type = $_GET['available_type'];
	$available_type = strip_tags(stripslashes($available_type));
}
else{
	$available_type = "";
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
	if($order_method != "asc" && $order_method != "desc"){
		echo"Wrong order method";
		die;
	}
}
else{
	$order_method = "asc";
}



/*- Content ---------------------------------------------------------------------------------- */
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){

	// Me
	$my_user_id = $_SESSION['user_id'];
	$my_user_id = output_html($my_user_id);
	$my_user_id_mysql = quote_smart($link, $my_user_id);

	


	/*- Headers ---------------------------------------------------------------------------------- */
	$website_title = "$l_edb - $l_most_used_passwords";
	if(file_exists("./favicon.ico")){ $root = "."; }
	elseif(file_exists("../favicon.ico")){ $root = ".."; }
	elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
	elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
	include("$root/_webdesign/header.php");


	if($action == ""){
		echo"
		<!-- Headline -->
			<h1>$l_most_used_passwords</h1>
		<!-- //Headline -->

		<!-- Where am I? -->
			<p><b>$l_you_are_here:</b><br />
			<a href=\"index.php?l=$l\">$l_edb</a>
			&gt;
			<a href=\"most_used_passwords.php?l=$l\">$l_most_used_passwords</a>
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
					$fm = str_replace("_", " ", $fm);
				}
				echo"<div class=\"$ft\"><span>$fm</span></div>";
			}
			echo"	
		<!-- //Feedback -->

		<!-- Tabs -->
			<div class=\"tabs\">
				<ul>";
				$query_av = "SELECT DISTINCT available_title, available_title_clean, available_type FROM $t_edb_item_types_available_passwords";
				$result_av = mysqli_query($link, $query_av);
				while($row_av = mysqli_fetch_row($result_av)) {
					list($get_available_title, $get_available_title_clean, $get_available_type) = $row_av;
					if($show == ""){
						$show = "$get_available_title_clean";
						$show_mysql = quote_smart($link, $show);
						$available_type = "$get_available_type";
					}
					echo"
					<li><a href=\"most_used_passwords.php?show=$get_available_title_clean&amp;available_type=$get_available_type&amp;l=$l\""; if($show == "$get_available_title_clean"){ echo" class=\"active\""; } echo">$get_available_title</a></li>
					";
				}

				echo"
				</ul>
			</div>
			<div class=\"clear\"></div>

		<!-- //Tabs -->
		
		<!-- Menu -->
			<p>";

			$date = date("y_m_d");
			$file_name = "$show" . "_" . $date . ".txt";
			if(file_exists("$root/_cache/$file_name")){
				echo"<a href=\"$root/_cache/$file_name\" class=\"btn_default\">$l_download_as .txt</a>\n";
			}
			else{
				echo"<a href=\"most_used_passwords.php?action=export_as_txt&amp;show=$show&amp;l=$l&amp;process=1\" class=\"btn_default\">$l_export_as .txt</a>\n";
			}
			echo"
			</p>
			<div style=\"height: 5px;\"></div>
		<!-- //Menu -->


		<!-- List of passwords -->

			<table class=\"hor-zebra\">
			 <thead>
			  <tr>
			   <th scope=\"col\">
				";
				$th_order_by = "password_number";
				$th_title    = "$l_number_abbreviation";
		
				if($order_by == "$th_order_by" && $order_method == "asc"){
					$order_method_link = "desc";
				}
				else{
					$order_method_link = "asc";
				}

				echo"<span><a href=\"most_used_passwords.php?show=$show&amp;l=$l&amp;order_by=$th_order_by&amp;order_method=$order_method_link&amp;l=$l\" style=\"color:black;\"><b>$th_title</b></a>";
				if($order_by == "$th_order_by" && $order_method == "asc"){
					echo"<img src=\"_gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
				}
				if($order_by == "$th_order_by" && $order_method == "desc"){
					echo"<img src=\"_gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
				}
				echo"</span>
			   </th>
			   <th scope=\"col\">
				";
				$th_order_by = "password_pass";
				$th_title    = "$l_password";
		
				if($order_by == "$th_order_by" && $order_method == "asc"){
					$order_method_link = "desc";
				}
				else{
					$order_method_link = "asc";
				}

				echo"<span><a href=\"most_used_passwords.php?show=$show&amp;l=$l&amp;order_by=$th_order_by&amp;order_method=$order_method_link&amp;l=$l\" style=\"color:black;\"><b>$th_title</b></a>";
				if($order_by == "$th_order_by" && $order_method == "asc"){
					echo"<img src=\"_gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
				}
				if($order_by == "$th_order_by" && $order_method == "desc"){
					echo"<img src=\"_gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
				}
				echo"</span>
			   </th>
			   <th scope=\"col\">
				";
				$th_order_by = "password_count";
				$th_title    = "$l_times_used";
		
				if($order_by == "$th_order_by" && $order_method == "asc"){
					$order_method_link = "desc";
				}
				else{
					$order_method_link = "asc";
				}

				echo"<span><a href=\"most_used_passwords.php?show=$show&amp;l=$l&amp;order_by=$th_order_by&amp;order_method=$order_method_link&amp;l=$l\" style=\"color:black;\"><b>$th_title</b></a>";
				if($order_by == "$th_order_by" && $order_method == "asc"){
					echo"<img src=\"_gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
				}
				if($order_by == "$th_order_by" && $order_method == "desc"){
					echo"<img src=\"_gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
				}
				echo"</span>
			   </th>
			   <th scope=\"col\">
				";
				$th_order_by = "password_first_used_datetime";
				$th_title    = "$l_first_used";
		
				if($order_by == "$th_order_by" && $order_method == "asc"){
					$order_method_link = "desc";
				}
				else{
					$order_method_link = "asc";
				}

				echo"<span><a href=\"most_used_passwords.php?show=$show&amp;l=$l&amp;order_by=$th_order_by&amp;order_method=$order_method_link&amp;l=$l\" style=\"color:black;\"><b>$th_title</b></a>";
				if($order_by == "$th_order_by" && $order_method == "asc"){
					echo"<img src=\"_gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
				}
				if($order_by == "$th_order_by" && $order_method == "desc"){
					echo"<img src=\"_gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
				}
				echo"</span>
			   </th>
			   <th scope=\"col\">
				";
				$th_order_by = "password_last_used_datetime";
				$th_title    = "$l_last_used";
		
				if($order_by == "$th_order_by" && $order_method == "asc"){
					$order_method_link = "desc";
				}
				else{
					$order_method_link = "asc";
				}

				echo"<span><a href=\"most_used_passwords.php?show=$show&amp;l=$l&amp;order_by=$th_order_by&amp;order_method=$order_method_link&amp;l=$l\" style=\"color:black;\"><b>$th_title</b></a>";
				if($order_by == "$th_order_by" && $order_method == "asc"){
					echo"<img src=\"_gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
				}
				if($order_by == "$th_order_by" && $order_method == "desc"){
					echo"<img src=\"_gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
				}
				echo"</span>
			   </th>
			   <th scope=\"col\">
			   </th>
			  </tr>
			 </thead>
			 <tbody>
			";
			
			$x = 1;
			$query = "SELECT password_id, password_number, password_pass, password_count, password_last_used_datetime, password_first_used_saying, password_last_used_saying FROM $t_edb_most_used_passwords";
			if($show != ""){
				$query = $query . " WHERE password_available_title_clean=$show_mysql";
			}
			if($order_by == "password_id" OR $order_by == "password_number" OR $order_by == "password_pass" OR $order_by == "password_count" OR $order_by == "password_last_used_datetime" OR $order_by == "password_first_used_datetime" OR $order_by == "password_last_used_datetime"){
				if($order_method == "asc" OR $order_method == "desc"){
					$query = $query . " ORDER BY $order_by $order_method";
				}
			}
			else{
				$query = $query . " ORDER BY password_count DESC";
			}
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_password_id, $get_password_number, $get_password_pass, $get_password_count, $get_password_last_used_datetime, $get_password_first_used_saying, $get_password_last_used_saying) = $row;

				if(isset($style) && $style == ""){
					$style = "odd";
				}
				else{
					$style = "";
				}
				// Number
				if($get_password_number != "$x" && $show != ""){
					$result_update = mysqli_query($link, "UPDATE $t_edb_most_used_passwords SET password_number='$x' WHERE password_id=$get_password_id") or die(mysqli_error($link));
					$get_password_number = "$x";
				}

				echo"
				<tr>
				  <td class=\"$style\">
					<span>$get_password_number</span>
				  </td>
				  <td class=\"$style\">";
					if($available_type == "unlock_pattern"){
						echo"
						<table>
						 <tr>
						  <td style=\"padding-right: 10px;\">
							<img src=\"most_used_passwords_unlock_pattern_drawer_to_image.php?pattern=$get_password_pass\" alt=\"most_used_passwords_unlock_pattern_drawer_to_image.php?pattern=$get_password_pass\" />
						  </td>
						  <td>
							<span>$get_password_pass</span>
						  </td>
						 </tr>
						</table>
						";
					}
					else{
						echo"<span>$get_password_pass</span>";
					}
					echo"
				  </td>
				  <td class=\"$style\">
					<span>$get_password_count</span>
				 </td>
				  <td class=\"$style\">
					<span>$get_password_first_used_saying</span>
				 </td>
				  <td class=\"$style\">
					<span>$get_password_last_used_saying</span>
				 </td>
				  <td class=\"$style\">
					<span><a href=\"most_used_passwords.php?show=$show&amp;action=delete&amp;password_id=$get_password_id&amp;available_type=$available_type&amp;l=$l\">x</a></span>
				 </td>
				</tr>
				";

				$x = $x+1;
				
			} // while passwords
			echo"
			 </tbody>
			</table>
		<!-- List of passwords -->
		";
	} // action == ""
	elseif($action == "export_as_txt"){
		/* Functions */
		include("$root/_admin/_functions/decode_national_letters.php");

		$date = date("y_m_d");
		$file_name = "$show" . "_" . $date . ".txt";

		if(!(file_exists("$root/_cache/$file_name"))){

			// Header
			$inp_header = "";
			$fh = fopen("$root/_cache/$file_name", "w+") or die("can not open file");
			fwrite($fh, $inp_header);
			fclose($fh);


			$x = 1;
			$query = "SELECT password_id, password_number, password_pass, password_count, password_last_used_datetime, password_first_used_saying, password_last_used_saying FROM $t_edb_most_used_passwords";
			if($show != ""){
				$query = $query . " WHERE password_available_title_clean=$show_mysql";
			}
			if($order_by == "password_id" OR $order_by == "password_number" OR $order_by == "password_pass" OR $order_by == "password_count" OR $order_by == "password_last_used_datetime" OR $order_by == "password_first_used_datetime" OR $order_by == "password_last_used_datetime"){
				if($order_method == "asc" OR $order_method == "desc"){
					$query = $query . " ORDER BY $order_by $order_method";
				}
			}
			else{
				$query = $query . " ORDER BY password_count DESC";
			}
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_password_id, $get_password_number, $get_password_pass, $get_password_count, $get_password_last_used_datetime, $get_password_first_used_saying, $get_password_last_used_saying) = $row;
				
				$get_password_pass = decode_national_letters($get_password_pass);

				if(file_exists("$root/_cache/$file_name")){
					$inp_body = "
$get_password_pass";
					$fh = fopen("$root/_cache/$file_name", "a+") or die("can not open file");
					fwrite($fh, $inp_body);
					fclose($fh);
				}
				else{
					$inp_body = "$get_password_pass";
					$fh = fopen("$root/_cache/$file_name", "w+") or die("can not open file");
					fwrite($fh, $inp_body);
					fclose($fh);
				}
			}
		}
		
		header("Location: $root/_cache/$file_name");
		exit;
	} // action == "export_as_txt"
	elseif($action == "delete" && isset($_GET['password_id'])){
		$password_id = $_GET['password_id'];
		$password_id = strip_tags(stripslashes($password_id));
		$password_id_mysql = quote_smart($link, $password_id);
		
		$query = "SELECT password_id, password_number, password_pass, password_count, password_last_used_datetime, password_first_used_saying, password_last_used_saying FROM $t_edb_most_used_passwords WHERE password_id=$password_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_password_id, $get_password_number, $get_password_pass, $get_password_count, $get_password_last_used_datetime, $get_password_first_used_saying, $get_password_last_used_saying) = $row;
		
		if($get_password_id == ""){
			echo"<h1>Server error 404</h1><p>Password not found</p>";
			die;
		}
		else{
			
			if($process == "1"){
				$result = mysqli_query($link, "DELETE FROM $t_edb_most_used_passwords WHERE password_id=$get_password_id");
				

				$url = "most_used_passwords.php?show=$show&available_type=$available_type&l=$l&ft=success&fm=deleted";
				header("Location: $url");
				exit;
			}
			echo"
			<!-- Headline -->
				<h1>$l_most_used_passwords</h1>
			<!-- //Headline -->

			<!-- Where am I? -->
				<p><b>$l_you_are_here:</b><br />
				<a href=\"index.php?l=$l\">$l_edb</a>
				&gt;
				<a href=\"most_used_passwords.php?l=$l\">$l_most_used_passwords</a>
				&gt;
				<a href=\"most_used_passwords.php?show=$show&amp;available_type=$available_type&amp;l=$l\">$show</a>
				&gt;
				<a href=\"most_used_passwords.php?show=$show&amp;available_type=$available_type&amp;action=delete&amp;password_id=$get_password_id&amp;l=$l\">$l_delete $get_password_pass</a>
				</p>
			<!-- //Where am I? -->
			
			<h2>$l_delete $get_password_pass</h2>
			<p>
			$l_are_you_sure
			</p>
				
			<p>
			<a href=\"most_used_passwords.php?show=$show&amp;available_type=$available_type&amp;action=delete&amp;password_id=$get_password_id&amp;l=$l&amp;process=1\" class=\"btn_danger\">$l_confirm</a>
			</p>
			";
		} // pasword found
		
	} // delete
} // logged in
else{
	// Log in
	echo"
	<h1><img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" /> $l_please_log_in...</h1>
	<meta http-equiv=\"refresh\" content=\"1;url=$root/users/login.php?l=$l&amp;referer=$root/edb/tasks.php\">
	";
} // not logged in
/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/$webdesignSav/footer.php");
?>