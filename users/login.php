<?php
/**
*
* File: users/index.php
* Version 17.46 18.02.2017
* Copyright (c) 2009-2017 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/*- Configuration ---------------------------------------------------------------------------- */
$pageIdSav            = "0";
$pageNoColumnSav      = "2";
$pageAllowCommentsSav = "0";

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

/*- Translation ------------------------------------------------------------------------------ */
include("$root/_admin/_translations/site/$l/users/ts_users.php");

/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_users";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");



/*- Content --------------------------------------------------------------------------- */




if($action == "check"){

	if(isset($_POST['inp_referer'])){
		$inp_referer = $_POST['inp_referer'];
		$inp_referer = stripslashes(strip_tags($inp_referer));

	}
	else{
		$inp_referer = "";
	}


	if(isset($_POST['inp_email'])){
		$inp_email = $_POST['inp_email'];
	}
	else{
		$inp_email = "";
	}
	$inp_email = output_html($inp_email);
	$inp_email = strtolower($inp_email);
	$inp_email_mysql = quote_smart($link, $inp_email);
	

	if(isset($_POST['inp_password'])){
		$inp_password = $_POST['inp_password'];
	}
	else{
		$inp_password = "";
	}

	if(isset($_POST['inp_remember'])) {
		$inp_remember = $_POST['inp_remember'];
		if($inp_remember != "on"){
			$inp_remember = "off";
		}
	}
	else{
		$inp_remember = "off";
	}

	
	if(empty($inp_email)){
		$url = "login.php?l=$l";
		
						
		$url = $url . "&referer=$inp_referer&ft=warning&fm=please_enter_your_email_address";

		if($process == "1"){
			header("Location: $url");
		}
		else{
			echo"<meta http-equiv=\"refresh\" content=\"1;url=$url\">";
		}
		exit;
	}
	if(empty($inp_password)){
		$url = "login.php?l=$l";
						
		$url = $url . "&referer=$inp_referer&ft=warning&fm=please_enter_your_password&inp_email=$inp_email";

		if($process == "1"){
			header("Location: $url");
		}
		else{
			echo"<meta http-equiv=\"refresh\" content=\"1;url=$url\">";
		}
		exit;
	}
	
	if($action == "check"){
		// Find
		
		$query = "SELECT user_id, user_password, user_salt, user_language, user_verified_by_moderator FROM $t_users WHERE user_email=$inp_email_mysql OR user_name=$inp_email_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_user_id, $get_user_password, $get_user_salt, $get_user_language, $get_user_verified_by_moderator) = $row;

		if($get_user_id == ""){
			// Email not found
			$url = "login.php?l=$l";
			if(isset($r_action) && $r_action != ""){ $url = $url . "&r_action=$r_action"; } 
						
			$url = $url . "&referer=$inp_referer&ft=warning&fm=email_address_not_found";

			if($process == "1"){
				header("Location: $url");
			}
			else{
				echo"<meta http-equiv=\"refresh\" content=\"1;url=$url\">";
			}
			exit;

		}
		else{

			// Check password 
			$inp_password_encrypted = sha1($inp_password);

			// $test = "x5E3EMI";
			// $test_e = sha1($test);
			// echo"$inp_password_encrypted == $get_user_password<br />$test_e";
			// die;

			if($inp_password_encrypted == "$get_user_password"){
				// Correct password
				$host = $_SERVER['HTTP_HOST'];


				// I am approved?
				if($get_user_verified_by_moderator == "1"){

					// -> Cookie
					if($inp_remember == "on"){
						$salt = substr (md5($get_user_password), 0, 2);
						$cookie = base64_encode ("$get_user_id:" . md5 ($get_user_password, $salt));


						setcookie ('remember_user', $cookie, strtotime( '+10 months' ), '/', $host);
					}

					// Set security pin
					$security = rand(0,9999);

					// -> Logg brukeren inn
					$_SESSION['user_id'] = "$get_user_id";
					$_SESSION['security'] = "$security";
					$_SESSION['l'] = "$get_user_language";
					$user_last_ip = $_SERVER['REMOTE_ADDR'];
					$user_last_ip = output_html($user_last_ip);
					$user_last_ip_mysql = quote_smart($link, $user_last_ip);

					// Update last logged in
					$inp_user_last_online = date("Y-m-d H:i:s");
					$inp_user_last_online_time = time();
					$result = mysqli_query($link, "UPDATE $t_users SET 
									user_security='$security', 
									user_last_online='$inp_user_last_online', 
									user_last_online_time='$inp_user_last_online_time', 
									user_last_ip=$user_last_ip_mysql WHERE user_id='$get_user_id'");

				

					// Refer?
					if(isset($_POST['inp_referer'])){
						$inp_referer = $_POST['inp_referer'];
						$inp_referer = stripslashes(strip_tags($inp_referer));
						$inp_referer = str_replace("&amp;", "&", $inp_referer);
						$inp_referer = str_replace("amp;", "&", $inp_referer);
						$url = "$inp_referer";
					}
					else{
						$url = "my_profile.php?l=$get_user_language"; 
					}

					if($process == "1"){
						header("Location: $url");
					}
					else{
						echo"
						<table>
						 <tr> 
						  <td style=\"padding-right: 6px;vertical-align: top;\">
							<span>
							<img src=\"$root/users/_gfx/loading_22.gif\" alt=\"loading_22.gif\" style=\"margin:0;padding: 23px 0px 0px 0px;\" />
							</span>
						  </td>
						  <td>
							<h1 style=\"border:0;margin:0;padding: 20px 0px 0px 0px;\">$l_users_loading...</h1>
					 	 </td>
						 </tr>
						</table>

						<meta http-equiv=\"refresh\" content=\"1;url=$url\">";
					}
					exit;
				}
				else{
					// Not approved yet
					$url = "create_free_account_awaiting_approvement.php?l=$l"; 
					if($process == "1"){
						header("Location: $url");
					}
					else{
						echo"
						<table>
						 <tr> 
						  <td style=\"padding-right: 6px;vertical-align: top;\">
							<span>
							<img src=\"$root/users/_gfx/loading_22.gif\" alt=\"loading_22.gif\" style=\"margin:0;padding: 23px 0px 0px 0px;\" />
							</span>
						  </td>
						  <td>
							<h1 style=\"border:0;margin:0;padding: 20px 0px 0px 0px;\">$l_users_loading...</h1>
					 	 </td>
						 </tr>
						</table>

						<meta http-equiv=\"refresh\" content=\"1;url=$url\">";
					}
					exit;

				}
			}
			else{
				// Wrong password
				$url = "login.php?l=$l";
				if(isset($r_action) && $r_action != ""){ $url = $url . "&r_action=$r_action"; } 
				$url = $url . "&referer=$inp_referer&ft=warning&fm=wrong_password&inp_email=$inp_email";

				if($process == "1"){
					header("Location: $url");
				}
				else{
					echo"<meta http-equiv=\"refresh\" content=\"1;url=$url\">";
				}
				exit;

			}
		}
	}
}
if($action == ""){
	if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
		echo"

		<table>
		 <tr> 
		  <td style=\"padding-right: 6px;vertical-align: top;\">
			<span>
			<img src=\"$root/users/_gfx/loading_22.gif\" alt=\"loading_22.gif\" style=\"margin:0;padding: 23px 0px 0px 0px;\" />
			</span>
		  </td>
		  <td>
			<h1 style=\"border:0;margin:0;padding: 20px 0px 0px 0px;\">$l_users_loading...</h1>
		  </td>
		 </tr>
		</table>



		<p>$l_users_you_are_beeing_transfered_back.</p>

			
		<meta http-equiv=\"refresh\" content=\"1;url=index.php?l=$l\">
				
		";

	}
	else{
		echo"


		<div id=\"login_page\">
			<h1>$l_users_login</h1>



			<!-- Feedback -->
				";
				if($ft != "" && $fm != ""){
					if($fm == "please_enter_your_email_address"){
						$fm = "$l_please_enter_your_email_address";
					}
					elseif($fm == "please_enter_your_password"){
						$fm = "$l_please_enter_your_password";
					}
					elseif($fm == "email_address_not_found"){
						$fm = "$l_email_address_not_found";
					}
					elseif($fm == "wrong_password"){
						$fm = "$l_wrong_password";
					}
					else{
						$fm = ucfirst($fm);
						$fm = str_replace("_", " ", $fm);
					}
					echo"<div class=\"$ft\"><p>$fm</p></div>";
				}
				echo"
			<!-- //Feedback -->

				<form method=\"POST\" action=\"login.php?action=check&amp;process=1&amp;l=$l\" enctype=\"multipart/form-data\">


				<!-- Referer -->
				";
				if(isset($_GET['referer'])) {
					// Get refer
					$referer = $_GET["referer"];
					$referer = strip_tags(stripslashes($referer));
					echo"
					<span>
					<input type=\"hidden\" name=\"inp_referer\" value=\"$referer\" />
					</span>
					";
				}
				else{
					$referer = "";
				}

				echo"
				<!-- //Referer -->
				$l_email_address:<br /></span>
				<p>
				<input type=\"text\" name=\"inp_email\" size=\"30\" style=\"width: 240px;\" value=\""; 
				if(isset($_GET['inp_email'])) {
					$inp_email = $_GET['inp_email'];
					$inp_email = output_html($inp_email);
					$inp_email = strtolower($inp_email); echo"$inp_email"; 
				} echo"\" tabindex=\"1\" />
				</p>

				<div id=\"login_page_password_left\">
					<span>$l_password:</span>
				</div>
				<div id=\"login_page_password_right\">
					<span><a href=\"forgot_password.php?l=$l\">$l_forgot_password_question</a></span>
				</div>
				<div class=\"clear\"></div>
				<p>
				<input type=\"password\" name=\"inp_password\" size=\"30\" style=\"width: 240px;\" value=\""; if(isset($inp_password)){ echo"$inp_password"; } echo"\" tabindex=\"2\" /><br />
				</p>

				<p>
				<input type=\"checkbox\" name=\"inp_remember\" "; if(isset($inp_remember)){ if($inp_remember == "on"){ echo" checked=\"checked\""; } } else{ echo" checked=\"checked\""; } echo" />
				$l_remember_me<br />
				</p>


				<p>
				<input type=\"submit\" value=\"$l_login\" class=\"btn_default\" tabindex=\"3\" style=\"width: 240px;\" />
				</p>
				</form>
			<p class=\"login_page_create_free_account\"><a href=\"create_free_account.php?l=$l\" class=\"btn_default\" style=\"width: 240px;\">$l_new_user &dash; $l_create_free_account</a></p>

			<!-- Focus -->
				<script>
				\$(document).ready(function(){
					\$('[name=\"inp_email\"]').focus();
				});
				</script>
			<!-- //Focus -->


			

		</div> <!-- //login_page -->
		";
	}
}
/*- Footer ---------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");

?>