<?php
/**
*
* File: _admin/_inc/ucp/default.php
* Version 02:10 28.12.2011
* Copyright (c) 2008-2012 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}




echo"

		<div style=\"height:20px;\"></div>

		<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
		 <tr>
		  <td style=\"vertical-align: top;width:218px;\">
			<!-- Left user data -->
				<!-- Image 200 x 266 px -->
				
					<table width=\"100%\">
					 <tr>
					  <td class=\"main_right_box_top_left\">
					  </td>
					  <td class=\"main_right_box_top_center\">
					  </td>
					  <td class=\"main_right_box_top_right\">
					  </td>
					 </tr>
					 <tr>
					  <td class=\"main_right_box_middle_left\">
					  </td>
					  <td class=\"main_right_box_middle_center\">
						<div style=\"text-align:center;\">
							";
							if(file_exists("$userPictureSav") && $userPictureSav != ""){
								if(!(file_exists("$userPictureThumbSav"))){
									// Create thumb before display
									$userPictureThumbSav = create_user_thumb($userIdSav);
									include("_data/users/$user_id.php");
								}
								echo"
								<a href=\"$userPictureSav\"><img src=\"$userPictureThumbSav\" alt=\"$userAliasSav\" /></a>
								";
							}
							else{
								echo"
								<img src=\"_gfx/anonymous_200x.jpg\" alt=\"Anonym\" />
								";
							}
							echo"
						</div>
						
						<ul class=\"block\">
							<li><a href=\"mailto:$userEmailSav\" style=\"padding: 4px 3%;\">Send e-post</a></li>
						</ul>
					  </td>
					  <td class=\"main_right_box_middle_right\">
					  </td>
					 </tr>
					 <tr>
					  <td class=\"main_right_box_bottom_left\">
					  </td>
					  <td class=\"main_right_box_bottom_center\">
					  </td>
					  <td class=\"main_right_box_bottom_right\">
					  </td>
					 </tr>
					</table>
				<!-- //Image 200 x 266 px -->


				<!-- Information -->
					<div style=\"height:10px;\"></div>
					<table width=\"100%\">
					 <tr>
					  <td class=\"main_right_box_top_left\">
					  </td>
					  <td class=\"main_right_box_top_center\">
					  </td>
					  <td class=\"main_right_box_top_right\">
					  </td>
					 </tr>
					 <tr>
					  <td class=\"main_right_box_middle_left\">
					  </td>
					  <td class=\"main_right_box_middle_center\">
						<span><b>Informasjon</b></span>
						
						";
						if($userAliasSav != ""){
							echo"
							<p><span class=\"grey\">Alias</span><br />
							$userAliasSav
							</p>
							";
						}
						if($userBirthdaySav != "" && $userBirthdaySav != "0000-00-00"){
							$today = date('d-m-Y');

							$a_birthday = explode('-', $userBirthdaySav);
							$a_today = explode('-', $today);

							$day_birthday = $a_birthday[2];
							$month_birthday = $a_birthday[1];
							$year_birthday = $a_birthday[0];
							$day_today = $a_today[0];
							$month_today = $a_today[1];
							$year_today = $a_today[2];

							$age = $year_today - $year_birthday;

							if (($month_today < $month_birthday) || ($month_today == $month_birthday && $day_today < $day_birthday)){							
								$age--;
							}

							echo"
							<p><span class=\"grey\">Alder</span><br />
							$age
							</p>
							";
						}
						if($userCitySav != "" OR $userMunicipalitySav != "" OR $userCountySav != ""){
							echo"
							<p><span class=\"grey\">Bosted</span><br />
							";
							if($userCitySav != ""){
								echo ucfirst(strtolower($userCitySav));
								if($userCountrySav != ""){
									echo", ";
									echo ucfirst(strtolower($userCountrySav));
								}
							}
							elseif($userCitySav == "" && $userMunicipalitySav != ""){
								echo ucfirst(strtolower($userMunicipalitySav));
								if($userCountrySav != ""){
									echo", ";
									echo ucfirst(strtolower($userCountrySav));
								}
							}
							elseif($userCitySav == "" && $userMunicipalitySav == ""){
								echo ucfirst(strtolower($userCountySav));
								if($userCountrySav != ""){
									echo", ";
									echo ucfirst(strtolower($userCountrySav));
								}
							}
							echo"
							</p>
							";
						}
						if($userOccupationSav != ""){
							echo"
							<p><span class=\"grey\">Yrke</span><br />
							$userOccupationSav
							</p>
							";
						}
						if($userInterestsSav != ""){
							echo"
							<p><span class=\"grey\">Interesser</span><br />
							$userInterestsSav
							</p>
							";
						}
						echo"
					  </td>
					  <td class=\"main_right_box_middle_right\">
					  </td>
					 </tr>
					 <tr>
					  <td class=\"main_right_box_bottom_left\">
					  </td>
					  <td class=\"main_right_box_bottom_center\">
					  </td>
					  <td class=\"main_right_box_bottom_right\">
					  </td>
					 </tr>
					</table>
				<!-- //Information -->
			<!-- //Left user data -->
		  </td>
		  <td style=\"padding: 0px 0px 0px 15px;vertical-align: top;\">
			<!-- Right user data -->
				
				";
				echo"<h3 style=\"padding: 7px 0px 10px 0px;margin:0;\">$userAliasSav</h3>";
				$free_text = "_data/users_free_text/$userIdSav.txt";
				if(file_exists("$free_text")){
					include("$free_text");
				}
				echo"
			<!-- //Right user data -->
		  </td>
		 </tr>
		</table>

";
?>