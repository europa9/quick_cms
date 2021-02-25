<?php
/**
*
* File: food_diary/index.php
* Version 1.0.0.
* Date 12:42 21.01.2018
* Copyright (c) 2008-2018 Sindre Andre Ditlefsen
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

/*- Tables --------------------------------------------------------------------------- */
include("_tables.php");


/*- Variables ------------------------------------------------------------------------- */
$l_mysql = quote_smart($link, $l);


if(isset($_GET['date'])) {
	$date = $_GET['date'];
	$date = strip_tags(stripslashes($date));
}
else{
	$date = date("Y-m-d");
}


/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_food_diary";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");


/*- Content ---------------------------------------------------------------------------------- */
// Logged in?
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){

	// Get my profile
	$my_user_id = $_SESSION['user_id'];
	$my_user_id_mysql = quote_smart($link, $my_user_id);
	$query = "SELECT user_id, user_alias, user_email, user_date_format FROM $t_users WHERE user_id=$my_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_my_user_id, $get_my_user_alias, $get_my_user_email, $get_my_user_date_format) = $row;


	// Do I have a goal?
	$query = "SELECT goal_id, goal_user_id, goal_current_weight, goal_current_fat_percentage, goal_target_weight, goal_target_fat_percentage, goal_i_want_to, goal_weekly_goal, goal_date, goal_activity_level, goal_current_bmi, goal_target_bmi, goal_current_bmr_calories, goal_current_bmr_fat, goal_current_bmr_carbs, goal_current_bmr_proteins, goal_current_sedentary_calories, goal_current_sedentary_fat, goal_current_sedentary_carbs, goal_current_sedentary_proteins, goal_current_with_activity_calories, goal_current_with_activity_fat, goal_current_with_activity_carbs, goal_current_with_activity_proteins, goal_target_bmr_calories, goal_target_bmr_fat, goal_target_bmr_carbs, goal_target_bmr_proteins, goal_target_sedentary_calories, goal_target_sedentary_fat, goal_target_sedentary_carbs, goal_target_sedentary_proteins, goal_target_with_activity_calories, goal_target_with_activity_fat, goal_target_with_activity_carbs, goal_target_with_activity_proteins, goal_synchronized, goal_notes FROM $t_food_diary_goals WHERE goal_user_id=$my_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_goal_id, $get_goal_user_id, $get_goal_current_weight, $get_goal_current_fat_percentage, $get_goal_target_weight, $get_goal_target_fat_percentage, $get_goal_i_want_to, $get_goal_weekly_goal, $get_goal_date, $get_goal_activity_level, $get_goal_current_bmi, $get_goal_target_bmi, $get_goal_current_bmr_calories, $get_goal_current_bmr_fat, $get_goal_current_bmr_carbs, $get_goal_current_bmr_proteins, $get_goal_current_sedentary_calories, $get_goal_current_sedentary_fat, $get_goal_current_sedentary_carbs, $get_goal_current_sedentary_proteins, $get_goal_current_with_activity_calories, $get_goal_current_with_activity_fat, $get_goal_current_with_activity_carbs, $get_goal_current_with_activity_proteins, $get_goal_target_bmr_calories, $get_goal_target_bmr_fat, $get_goal_target_bmr_carbs, $get_goal_target_bmr_proteins, $get_goal_target_sedentary_calories, $get_goal_target_sedentary_fat, $get_goal_target_sedentary_carbs, $get_goal_target_sedentary_proteins, $get_goal_target_with_activity_calories, $get_goal_target_with_activity_fat, $get_goal_target_with_activity_carbs, $get_goal_target_with_activity_proteins, $get_goal_synchronized, $get_goal_notes) = $row;
	if($get_goal_id == ""){
		echo"
		<h1>
		<img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" />
		$l_please_set_your_goal...</h1>
		<meta http-equiv=\"refresh\" content=\"1;url=my_goal_new.php?l=$l\">
		";
	}
	else{
		echo"

		<!-- Food diary Quick menu -->
			<div style=\"float: right;padding-top: 8px;\">
				<p>
				<a href=\"$root/food_diary/my_goal.php?l=$l\" class=\"btn_default\">$l_my_goal</a>
				<a href=\"$root/food_diary/my_profile_data.php?l=$l\" class=\"btn_default\">$l_my_profile_data</a>
				</p>
			</div>
		<!-- //Food diary Quick menu -->
	
		<h1>$l_food_diary</h1>


		<!-- Feedback -->
			";
			if($ft != "" && $fm != ""){
				if($fm == "food_added"){
					// What food was added?
					$query = "SELECT entry_id, entry_name, entry_manufacturer_name, entry_serving_size, entry_serving_size_measurement FROM $t_food_diary_entires WHERE entry_user_id=$my_user_id_mysql ORDER BY entry_id DESC LIMIT 0,1";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_entry_id, $get_entry_name, $get_entry_manufacturer_name, $get_entry_serving_size, $get_entry_serving_size_measurement) = $row;
					
					$fm = "$get_entry_serving_size $get_entry_serving_size_measurement";
					if($get_entry_manufacturer_name != ""){
						$fm = $fm . " $get_entry_manufacturer_name ";
					}
					
					$fm = $fm . " $get_entry_name $l_added_to_your_diary_lowercase.";

				}
				echo"<div class=\"$ft\"><p>$fm</p></div>";
			}
			echo"
		<!-- //Feedback -->


		<!-- Yesterday, tomorrow -->
			";
			$today = date("Y-m-d");
			if($date == "$today"){
				$timestamp = time();
			}
			else{
				$timestamp = strtotime($date);
			}

			$yesterday = mktime(0, 0, 0, date("m", $timestamp), date("d", $timestamp)-1, date("Y", $timestamp));
			$yesterday = date('Y-m-d', $yesterday);

			$now_array = explode("-", $date);
			

			$month = $now_array[1];
			if($month > 12 OR !(is_numeric($month))){
				echo"error"; die;
			}
			
			if($month == "01"){
				$month_saying = $l_january;
			}
			elseif($month == "02"){
				$month_saying = $l_february;
			}
			elseif($month == "03"){
				$month_saying = $l_march;
			}
			elseif($month == "04"){
				$month_saying = $l_april;
			}
			elseif($month == "05"){
				$month_saying = $l_may;
			}
			elseif($month == "06"){
				$month_saying = $l_june;
			}
			elseif($month == "07"){
				$month_saying = $l_july;
			}
			elseif($month == "08"){
				$month_saying = $l_august;
			}
			elseif($month == "09"){
				$month_saying = $l_september;
			}
			elseif($month == "10"){
				$month_saying = $l_october;
			}
			elseif($month == "11"){
				$month_saying = $l_november;
			}
			else{
				$month_saying = $l_december;
			}


			if(isset($now_array[2])){
				$day = $now_array[2];
			}
			else{
				echo"error"; die;
			}
			if($day < 10){
				$day = substr($day, 1, 1);
			}
			$year = $now_array[0];

			$tomorrow = mktime(0, 0, 0, date("m", $timestamp), date("d", $timestamp)+1, date("Y", $timestamp));
			$tomorrow = date('Y-m-d', $tomorrow);


			// Print todays date
			

			echo"
			<table style=\"width: 100%;\">
			 <tr>
			  <td style=\"padding: 0px 0px 18px 8px;\">
				<a href=\"index.php?action=food_diary&amp;date=$yesterday\"><img src=\"_gfx/arrow_left.jpg\" alt=\"arrow_left.jpg\" /></a>
			  </td>
			  <td style=\"padding: 0px 0px 18px 0px;text-align: center;\">
				<span>$day $month_saying $year</span>
			  </td>
			  <td style=\"text-align: right;padding: 0px 8px 18px 0px;\">
				<a href=\"index.php?action=food_diary&amp;date=$tomorrow\"><img src=\"_gfx/arrow_right.jpg\" alt=\"arrow_right.jpg\" /></a>
			  </td>
			 </tr>
			</table>
	<!-- //Yesterday, tomorrow -->


	<!-- Todays Totals -->";
		$date_mysql = quote_smart($link, $date);
		$query = "SELECT total_day_id, total_day_user_id, total_day_date, total_day_consumed_energy, total_day_consumed_fat, total_day_consumed_carb, total_day_consumed_protein, total_day_target_sedentary_energy, total_day_target_sedentary_fat, total_day_target_sedentary_carb, total_day_target_sedentary_protein, total_day_target_with_activity_energy, total_day_target_with_activity_fat, total_day_target_with_activity_carb, total_day_target_with_activity_protein, total_day_diff_sedentary_energy, total_day_diff_sedentary_fat, total_day_diff_sedentary_carb, total_day_diff_sedentary_protein, total_day_diff_with_activity_energy, total_day_diff_with_activity_fat, total_day_diff_with_activity_carb, total_day_diff_with_activity_protein, total_day_updated FROM $t_food_diary_totals_days WHERE total_day_user_id=$my_user_id_mysql AND total_day_date=$date_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_total_day_id, $get_total_day_user_id, $get_total_day_date, $get_total_day_consumed_energy, $get_total_day_consumed_fat, $get_total_day_consumed_carb, $get_total_day_consumed_protein, $get_total_day_target_sedentary_energy, $get_total_day_target_sedentary_fat, $get_total_day_target_sedentary_carb, $get_total_day_target_sedentary_protein, $get_total_day_target_with_activity_energy, $get_total_day_target_with_activity_fat, $get_total_day_target_with_activity_carb, $get_total_day_target_with_activity_protein, $get_total_day_diff_sedentary_energy, $get_total_day_diff_sedentary_fat, $get_total_day_diff_sedentary_carb, $get_total_day_diff_sedentary_protein, $get_total_day_diff_with_activity_energy, $get_total_day_diff_with_activity_fat, $get_total_day_diff_with_activity_carb, $get_total_day_diff_with_activity_protein, $get_total_day_updated) = $row;
		if($get_total_day_id == ""){
			// Insert this meal
			$inp_total_day_updated = date("Y-m-d H:i:s");
			mysqli_query($link, "INSERT INTO $t_food_diary_totals_days
			(total_day_id, total_day_user_id, total_day_date, 
			total_day_consumed_energy, total_day_consumed_fat, total_day_consumed_carb, total_day_consumed_protein, 
			total_day_target_sedentary_energy, total_day_target_sedentary_fat, total_day_target_sedentary_carb, total_day_target_sedentary_protein, 
			total_day_target_with_activity_energy, total_day_target_with_activity_fat, total_day_target_with_activity_carb, total_day_target_with_activity_protein, 
			total_day_diff_sedentary_energy, total_day_diff_sedentary_fat, total_day_diff_sedentary_carb, total_day_diff_sedentary_protein, 
			total_day_diff_with_activity_energy, total_day_diff_with_activity_fat, total_day_diff_with_activity_carb, total_day_diff_with_activity_protein,
			total_day_updated) 
			VALUES 
			(NULL, $my_user_id_mysql, $date_mysql, 
			'0', '0', '0', '0',
			'$get_goal_target_sedentary_calories', '$get_goal_target_sedentary_fat', '$get_goal_target_sedentary_carbs', '$get_goal_target_sedentary_proteins',
			'$get_goal_target_with_activity_calories', '$get_goal_target_with_activity_fat', '$get_goal_target_with_activity_carbs', '$get_goal_target_with_activity_proteins',
			'$get_goal_target_sedentary_calories', '$get_goal_target_sedentary_fat', '$get_goal_target_sedentary_carbs', '$get_goal_target_sedentary_proteins',
			'$get_goal_target_with_activity_calories', '$get_goal_target_with_activity_fat', '$get_goal_target_with_activity_carbs', '$get_goal_target_with_activity_proteins',
			'$inp_total_day_updated'
			)")
			or die(mysqli_error($link));
			// echo"Ny dag, nye muligheter";
		}

		echo"
	<!-- //Todays Totals -->

	<!-- Rest -->
		";
		if($get_total_day_id != ""){
			echo"

			<!-- sedentary -->
				<table style=\"width: 100%;\">
				 <tr>
				  <td style=\"text-align:center;\">
					<span style=\"font-weight:bold;\">$l_lifestyle</span>
				  </td>
				  <td style=\"text-align:center;\">
					<span style=\"font-weight:bold;\">$l_target</span>
				  </td>
				  <td>
				  </td>
				  <td style=\"text-align:center;\">
					<span style=\"font-weight:bold;\">$l_food</span>
				  </td>
				  <td>
				  </td>
				  <td style=\"text-align:center;\">
					<span style=\"font-weight:bold;\">$l_remaining</span>
				  </td>
				 </tr>
				 <tr>
				  <td style=\"text-align:center;\">
					<span>
					$l_active<br />
					$l_sedentary<br />
					</span>
				  </td>
				  <td style=\"text-align:center;\">
					<span>
					$get_total_day_target_with_activity_energy<br />
					$get_total_day_target_sedentary_energy<br />
					</span>
				  </td>
				  <td style=\"text-align:center;\">
					<span>-</span>
				  </td>
				  <td style=\"text-align:center;\">
					<span>$get_total_day_consumed_energy</span>
				  </td>
				  <td>
					<span>=</span>
				  </td>
				  <td style=\"text-align:center;\">
					<span";
					if($get_total_day_consumed_energy > "$get_total_day_target_with_activity_energy"){
						echo" style=\"color:red;\"";
					}
					else{
						if($get_total_day_diff_with_activity_energy < 100){
							echo" style=\"color: #996600;\"";
						}
						else{
							echo" style=\"color: green;\"";
						}
					}
					echo">$get_total_day_diff_with_activity_energy<br /></span>

					<span";
					if($get_total_day_consumed_energy > "$get_total_day_target_sedentary_energy"){
						echo" style=\"color:red;\"";
					}
					else{
						if($get_total_day_diff_sedentary_energy < 100){
							echo" style=\"color: #996600;\"";
						}
						else{
							echo" style=\"color: green;\"";
						}
					}
					echo">$get_total_day_diff_sedentary_energy<br /></span>
					
				  </td>
				 </tr>
				</table>


			";
		}
		echo"	
	<!-- //Rest -->

	<!-- Meals -->
	";
	// Start loop
	$meal_title = array("$l_breakfast", "$l_lunch", "$l_before_training", "$l_after_training", "$l_dinner", "$l_snacks", "$l_supper");
	$date_mysql = quote_smart($link, $date);
	for($x=0;$x<7;$x++){
		// Find out how many calories I have eaten for this meal
		$query = "SELECT total_meal_id, total_meal_user_id, total_meal_date, total_meal_meal_id, total_meal_energy, total_meal_fat, total_meal_carb, total_meal_protein FROM $t_food_diary_totals_meals WHERE total_meal_user_id=$my_user_id_mysql AND total_meal_date=$date_mysql AND total_meal_meal_id='$x'";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_total_meal_id, $get_total_meal_user_id, $get_total_meal_date, $get_total_meal_meal_id, $get_total_meal_energy, $get_total_meal_fat, $get_total_meal_carb, $get_total_meal_protein) = $row;
		if($get_total_meal_id == ""){
			// Insert this meal
			mysqli_query($link, "INSERT INTO $t_food_diary_totals_meals
			(total_meal_id, total_meal_user_id, total_meal_date, total_meal_meal_id, total_meal_energy, total_meal_fat, total_meal_carb, total_meal_protein) 
			VALUES 
			(NULL, $my_user_id_mysql, $date_mysql, '$x', '0', '0', '0', '0')")
			or die(mysqli_error($link));
			// echo"Ny dag, nye muligheter";
		}

		echo"
		<div style=\"height: 8px;\"></div>
		<a id=\"meal$x\"></a>
		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\" id=\"thmeal$x\">
			";
			if($date == "$today"){
				echo"
				<span style=\"font-weight: bold;\"><a href=\"food_diary_add.php?date=$date&amp;meal_id=$x&amp;l=$l\"><img src=\"_gfx/list-add.png\" alt=\"list-add.png\" style=\"float: left;padding: 1px 4px 0px 0px;\" /></a></span>  
				  
					<script>
					\$(document).ready(function(){
						\$('#thmeal$x').click(function(){
							window.location= \"food_diary_add.php?date=$date&meal_id=$x&l=$l\";
						});
					});
					</script>


					<span><a href=\"food_diary_add.php?date=$date&amp;meal_id=$x&amp;l=$l\" style=\"font-weight: bold;color: #000;\">$meal_title[$x]</a></span>  
				  ";
			}
			else{
				echo"
				<span style=\"font-weight: bold;color: #000;\">$meal_title[$x]</span>  
				";
			}
			echo"
		   </th>
		   <th style=\"text-align: right;vertical-align: top;padding: 0px 4px 0px 0px;\">
			<span style=\"font-weight: bold;\">$get_total_meal_energy</span>  
		   </th>
		  </tr>
		 </thead>
		 <tbody>
		";
	

		$query = "SELECT entry_id, entry_user_id, entry_date, entry_meal_id, entry_food_id, entry_recipe_id, entry_name, entry_manufacturer_name, entry_serving_size, entry_serving_size_measurement, entry_energy_per_entry, entry_fat_per_entry, entry_carb_per_entry, entry_protein_per_entry, entry_text FROM $t_food_diary_entires WHERE entry_user_id=$my_user_id_mysql AND entry_date=$date_mysql AND entry_meal_id='$x'";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
    		list($get_entry_id, $get_entry_user_id, $get_entry_date, $get_entry_meal_id, $get_entry_food_id, $get_entry_recipe_id, $get_entry_name, $get_entry_manufacturer_name, $get_entry_serving_size, $get_entry_serving_size_measurement, $get_entry_energy_per_entry, $get_entry_fat_per_entry, $get_entry_carb_per_entry, $get_entry_protein_per_entry, $get_entry_text) = $row;
			if(isset($style) && $style == ""){
				$style = "odd";
			}
			else{
				$style = "";
			}


				
			echo"
			  <tr>
			   <td class=\"$style\" id=\"a_entry_$get_entry_id\">
				<script>
				\$(document).ready(function(){
					\$('#a_entry_$get_entry_id').click(function(){
						window.location= \"\";
					});
					\$('#a_entry_$get_entry_id').click(function(){
						window.location= \"food_diary_edit_entry.php?entry_id=$get_entry_id\";
					});
				});
				</script>
					
				<span>
				$get_entry_serving_size  $get_entry_serving_size_measurement
				<a href=\"food_diary_edit_entry.php?entry_id=$get_entry_id\">";
				if($get_entry_manufacturer_name != ""){
					echo"$get_entry_manufacturer_name ";
				}

				echo"$get_entry_name</a>
				</span>
			  </td>
			  <td class=\"$style\" style=\"text-align:right;vertical-align: top;padding: 0px 4px 0px 0px;\"  id=\"b_entry_$get_entry_id\">
				<span>$get_entry_energy_per_entry</span>  
			  </td>
			 </tr>";
		} // entries

		echo"
		 </tbody>
		</table>
		";
		
		
	} // meals
	echo"
	<!-- //Meals -->

	<!-- Summary -->

		<div style=\"height: 8px;\"></div>
		<table style=\"width: 100%\">
		 <tr>
		  <td class=\"outline\">
			<table style=\"border-spacing: 1px;width: 100%;\">
			 <tr>
			  <td class=\"bodycell\" style=\"padding: 4px;\">
				<span style=\"font-weight: bold;\">$l_summary</span>
			  </td>
			 </tr>
			 <tr>
			  <td class=\"subcell\" style=\"padding: 4px;\">
				";

				$total_fat_carb_proteins = $get_total_day_consumed_fat+$get_total_day_consumed_carb+$get_total_day_consumed_protein;
				if($get_total_day_id != "" && $get_total_day_consumed_fat != "0"){
					$get_total_day_consumed_fat_percentage = round(($get_total_day_consumed_fat/$total_fat_carb_proteins)*100, 0);
				}
				else{
					$get_total_day_consumed_fat_percentage = 0;
				}
				if($get_total_day_id != "" && $get_total_day_consumed_carb != "0"){
					$get_total_day_consumed_carb_percentage = round(($get_total_day_consumed_carb/$total_fat_carb_proteins)*100, 0);
				}
				else{
					$get_total_day_consumed_carb_percentage = 0;
				}
				
				if($get_total_day_id != "" && $get_total_day_consumed_protein!= "0"){
					$get_total_day_consumed_protein_percentage = round(($get_total_day_consumed_protein/$total_fat_carb_proteins)*100, 0);
				}
				else{
					$get_total_day_consumed_protein_percentage = 0;
				}
				$sum_total_fat_carb_proteins_percentage  = $get_total_day_consumed_fat_percentage + $get_total_day_consumed_carb_percentage + $get_total_day_consumed_protein_percentage;
				if($sum_total_fat_carb_proteins_percentage != "0" && $sum_total_fat_carb_proteins_percentage != "100"){
					 $get_total_day_consumed_protein_percentage = $get_total_day_consumed_protein_percentage+1;
				}

				echo"
				<table style=\"width: 100%\">
				 <tr>
				  <td style=\"vertical-align: top;\">
					<table>
					 <tr>
					  <td style=\"padding: 0px 4px 0px 0px;\">
						<span style=\"font-weight: bold;\">$l_energy:</span>
					  </td>
					  <td>
						<span>$get_total_day_consumed_energy&nbsp;$l_kcal_lowercase</span>
					  </td>
					 </tr>
					 <tr>
					  <td style=\"padding: 0px 4px 0px 0px;\">
						<span style=\"font-weight: bold;\">$l_fat:</span>
					  </td>
					  <td>
						<span>$get_total_day_consumed_fat</span>
					  </td>
					 </tr>
					 <tr>
					  <td style=\"padding: 0px 4px 0px 0px;\">
						<span style=\"font-weight: bold;\">$l_carb:</span>
					  </td>
					  <td>
						<span>$get_total_day_consumed_carb</span>
					  </td>
					 </tr>
					 <tr>
					  <td style=\"padding: 0px 4px 0px 0px;\">
						<span style=\"font-weight: bold;\">$l_proteins:</span>
					  </td>
					  <td>
						<span>$get_total_day_consumed_protein</span>
					  </td>
					 </tr>
					</table>
				  </td>
				  <td style=\"text-align: right;width:100px;padding-top: 6px;\">
					<span>
					<img src=\"_gfx/pie_chart.php?numbers=$get_total_day_consumed_protein_percentage,$get_total_day_consumed_carb_percentage,$get_total_day_consumed_fat_percentage\" alt=\"pie_chart.php\" style=\"padding-bottom: 4px;\" />
					
					</span>
				  </td>
				  <td style=\"vertical-align: top;text-align: right;width:170px;padding-top: 16px;\">
					<table style=\"width: 100%\">
					 <tr>
					  <td style=\"padding: 0px 4px 0px 0px;\">
						<span>$l_fat ($get_total_day_consumed_fat_percentage %)</span>
					  </td>
					  <td>
						<span style=\"font-weight: bold;\"><img src=\"_gfx/dot_blue.png\" alt=\"dot_blue.png\" /></span>
					  </td>
					 </tr>
					 <tr>
					  <td style=\"padding: 0px 4px 0px 0px;\">
						<span>$l_carbs ($get_total_day_consumed_carb_percentage %)</span>
					  </td>
					  <td>
						<span style=\"font-weight: bold;\"><img src=\"_gfx/dot_red.png\" alt=\"dot_red.png\" /></span>
					  </td>
					 </tr>
					 <tr>
					  <td style=\"padding: 0px 4px 0px 0px;\">
						<span>$l_proteins ($get_total_day_consumed_protein_percentage %)</span>
					  </td>
					  <td>
						<span style=\"font-weight: bold;\"><img src=\"_gfx/dot_green.png\" alt=\"dot_green.png\" /></span>
					  </td>
					 </tr>
					</table>
				  </td>
				 </tr>
				</table>
			  </td>
			 </tr>
			</table>
		  </td>
		 </tr>
		</table>
	<!-- //Summary -->

	";
	} // goal
} // logged in
else{
	include("index_not_logged_in.php");
}



/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>