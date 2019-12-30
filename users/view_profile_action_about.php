<?php

/*- Content --------------------------------------------------------------------------- */


if(isset($can_view_profile)){
	echo"



	<!-- From the data -->
		<table>
		";
		if($get_current_user_dob != "" && $get_current_user_dob != "0000-00-00"){


			// Calculate Age
			$age = date('Y') - substr($get_current_user_dob, 0, 4);
			if (strtotime(date('Y-m-d')) - strtotime(date('Y') . substr($get_current_user_dob, 4, 6)) < 0){
				$age--;
			}
			echo"
			 <tr>
			  <td style=\"padding: 0px 8px 8px 0px;\">
				<span class=\"grey_dark\">$l_age:</span>
			  </td>
			  <td style=\"padding: 0px 0px 8px 0px;\">
				<span style=\"\">$age</span>
			  </td>
			 </tr>
			";


			}
 
			if($get_current_user_gender != ""){
				echo"
				 <tr>
				  <td style=\"padding: 0px 8px 8px 0px;\">
					<span class=\"grey_dark\">$l_gender:</span>
				  </td>
				  <td style=\"padding: 0px 0px 8px 0px;\">
					<span>
					";
					if($get_current_user_gender == "male"){
						echo"<img src=\"_gfx/male.png\" alt=\"male_4b4f56.png\" /> $l_male";
					}
					if($get_current_user_gender == "female"){
						echo"<img src=\"_gfx/female.png\" alt=\"female_4b4f56.png\" /> $l_female";
					}
					echo"</span>
				  </td>
				 </tr>
				";
			}

			echo"
		</table>
	<!-- //From the data -->
	<!-- Professional -->
		<h3>$l_professional</h3>
		<table>
	";

	if($get_current_profile_work != ""){
		echo"
		 <tr>
		  <td style=\"padding: 0px 8px 8px 0px;\">
			<span class=\"grey_dark\">$l_work:</span>
		  </td>
		  <td style=\"padding: 0px 0px 8px 0px;\">
			<span style=\"\">$get_current_profile_work</span>
		  </td>
		 </tr>
		";
	}
	if($get_current_profile_university != ""){
		echo"
		 <tr>
		  <td style=\"padding: 0px 8px 8px 0px;\">
			<span class=\"grey_dark\">$l_university:</span>
		  </td>
		  <td style=\"padding: 0px 0px 8px 0px;\">
			<span style=\"\">$get_current_profile_university</span>
		  </td>
		 </tr>
		";
	}
	if($get_current_profile_high_school != ""){
		echo"
		 <tr>
		  <td style=\"padding: 0px 8px 8px 0px;\">
			<span class=\"grey_dark\">$l_high_school:</span>
		  </td>
		  <td style=\"padding: 0px 0px 8px 0px;\">
			<span style=\"\">$get_current_profile_high_school</span>
		  </td>
		 </tr>";
	}
	echo"
		</table>
	<!-- //Professional -->

	<!-- Contact -->
		<h3>$l_contact</h3>

		<table>
	";

	if($get_current_profile_phone != ""){
		echo"
		 <tr>
		  <td style=\"padding: 0px 8px 8px 0px;\">
			<span class=\"grey_dark\">$l_phone:</span>
		  </td>
		  <td style=\"padding: 0px 0px 8px 0px;\">
			<span style=\"\">$get_current_profile_phone</span>
		  </td>
		 </tr>";
	}
	
	if($get_current_profile_languages != ""){
		echo"
		 <tr>
		  <td style=\"padding: 0px 8px 8px 0px;\">
			<span class=\"grey_dark\">$l_languages:</span>
		  </td>
		  <td style=\"padding: 0px 0px 8px 0px;\">
			<span style=\"\">$get_current_profile_languages</span>
		  </td>
		 </tr>";
	}
	
	if($get_current_profile_website != ""){
		echo"
		 <tr>
		  <td style=\"padding: 0px 8px 8px 0px;\">
			<span class=\"grey_dark\">$l_website:</span>
		  </td>
		  <td style=\"padding: 0px 0px 8px 0px;\">
			<span style=\"\"><a href=\"$get_current_profile_website\">$get_current_profile_website</a></span>
		  </td>
		 </tr>";
	}
	
	echo"
		</table>
	<!-- //Contact -->

	<!-- Personal -->
		<h3>$l_personal</h3>

		<table>
	";

	if($get_current_profile_interested_in != ""){
		$array = explode("|", $get_current_profile_interested_in);
		
		echo"
		 <tr>
		  <td style=\"padding: 0px 8px 8px 0px;\">
			<span class=\"grey_dark\">$l_intrested_in:</span>
		  </td>
		  <td style=\"padding: 0px 0px 8px 0px;\">
			<span style=\"\">";
			if($array[0] == "on" && $array[1] == "on"){
				echo"$l_male_and_female";
			}
			elseif($array[0] == "on" && $array[1] == "off"){
				echo"$l_men";
			}
			elseif($array[0] == "off" && $array[1] == "on"){
				echo"$l_women";
			}
			else{
			}
			echo"</span>
		  </td>
		 </tr>";
	}
	
	if($get_current_profile_relationship != ""){
		
		echo"
		 <tr>
		  <td style=\"padding: 0px 8px 8px 0px;\">
			<span class=\"grey_dark\">$l_status:</span>
		  </td>
		  <td style=\"padding: 0px 0px 8px 0px;\">
			<span style=\"\">";
			if($get_current_profile_relationship == "single"){ 
				echo"$l_single";
			}
			elseif($get_current_profile_relationship == "in_a_relationship"){ 
				echo"$l_in_a_relationship";
			}
			elseif($get_current_profile_relationship == "engaged"){ 
				echo"$l_engaged";
			}
			elseif($get_current_profile_relationship == "married"){ 
				echo"$l_married";
			}
			elseif($get_current_profile_relationship == "in_a_open_relationship"){ 
				echo"$l_in_a_open_relationship";
			}
			elseif($get_current_profile_relationship == "its_complicated"){ 
				echo"$l_its_complicated";
			}
			elseif($get_current_profile_relationship == "seperated"){ 
				echo"$l_seperated";
			}
			elseif($get_current_profile_relationship == "divorced"){ 
				echo"$l_divorced";
			}
			elseif($get_current_profile_relationship == "widow_widower"){ 
				echo"$l_widow_widower";
			}
			else{
			}
			echo"</span>
		  </td>
		 </tr>";
	}
	
	
	echo"
		</table>
	<!-- //Contact -->

	<!-- About -->
		";
		if($get_current_profile_about != ""){
			echo"
			<h3>$l_about</h3>
			<p>$get_current_profile_about</p>
			";
		}
		echo"
		
	<!-- //About -->
	
	";
}
?>