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


	<!-- Todays Consumed Totals -->";
		$date_mysql = quote_smart($link, $date);
		$query = "SELECT consumed_day_id, consumed_day_user_id, consumed_day_year, consumed_day_month, consumed_day_month_saying, consumed_day_day, consumed_day_day_saying, consumed_day_date, consumed_day_energy, consumed_day_fat, consumed_day_saturated_fat, consumed_day_monounsaturated_fat, consumed_day_polyunsaturated_fat, consumed_day_cholesterol, consumed_day_carbohydrates, consumed_day_carbohydrates_of_which_sugars, consumed_day_dietary, consumed_day_proteins, consumed_day_salt, consumed_day_sodium, consumed_day_target_sedentary_energy, consumed_day_target_sedentary_fat, consumed_day_target_sedentary_carb, consumed_day_target_sedentary_protein, consumed_day_target_with_activity_energy, consumed_day_target_with_activity_fat, consumed_day_target_with_activity_carb, consumed_day_target_with_activity_protein, consumed_day_diff_sedentary_energy, consumed_day_diff_sedentary_fat, consumed_day_diff_sedentary_carb, consumed_day_diff_sedentary_protein, consumed_day_diff_with_activity_energy, consumed_day_diff_with_activity_fat, consumed_day_diff_with_activity_carb, consumed_day_diff_with_activity_protein, consumed_day_updated_datetime, consumed_day_synchronized FROM $t_food_diary_consumed_days WHERE consumed_day_user_id=$my_user_id_mysql AND consumed_day_date=$date_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_consumed_day_id, $get_consumed_day_user_id, $get_consumed_day_year, $get_consumed_day_month, $get_consumed_day_month_saying, $get_consumed_day_day, $get_consumed_day_day_saying, $get_consumed_day_date, $get_consumed_day_energy, $get_consumed_day_fat, $get_consumed_day_saturated_fat, $get_consumed_day_monounsaturated_fat, $get_consumed_day_polyunsaturated_fat, $get_consumed_day_cholesterol, $get_consumed_day_carbohydrates, $get_consumed_day_carbohydrates_of_which_sugars, $get_consumed_day_dietary, $get_consumed_day_proteins, $get_consumed_day_salt, $get_consumed_day_sodium, $get_consumed_day_target_sedentary_energy, $get_consumed_day_target_sedentary_fat, $get_consumed_day_target_sedentary_carb, $get_consumed_day_target_sedentary_protein, $get_consumed_day_target_with_activity_energy, $get_consumed_day_target_with_activity_fat, $get_consumed_day_target_with_activity_carb, $get_consumed_day_target_with_activity_protein, $get_consumed_day_diff_sedentary_energy, $get_consumed_day_diff_sedentary_fat, $get_consumed_day_diff_sedentary_carb, $get_consumed_day_diff_sedentary_protein, $get_consumed_day_diff_with_activity_energy, $get_consumed_day_diff_with_activity_fat, $get_consumed_day_diff_with_activity_carb, $get_consumed_day_diff_with_activity_protein, $get_consumed_day_updated_datetime, $get_consumed_day_synchronized) = $row;
		if($get_consumed_day_id == ""){
			// Insert this day
			$year = date("Y");
			$month = date("m");
			$month_saying = date("M");
			$day = date("d");
			$day_saying = date("D");
			$date = date("Y-m-d");
			$datetime = date("Y-m-d H:i:s");
			mysqli_query($link, "INSERT INTO $t_food_diary_consumed_days
			(consumed_day_id, consumed_day_user_id, consumed_day_year, consumed_day_month, consumed_day_month_saying, 
			consumed_day_day, consumed_day_day_saying, consumed_day_date, consumed_day_energy, consumed_day_fat, 
			consumed_day_saturated_fat, consumed_day_monounsaturated_fat, consumed_day_polyunsaturated_fat, consumed_day_cholesterol, consumed_day_carbohydrates, 
			consumed_day_carbohydrates_of_which_sugars, consumed_day_dietary, consumed_day_proteins, consumed_day_salt, consumed_day_sodium, 
			consumed_day_target_sedentary_energy, consumed_day_target_sedentary_fat, consumed_day_target_sedentary_carb, consumed_day_target_sedentary_protein, consumed_day_target_with_activity_energy, 
			consumed_day_target_with_activity_fat, consumed_day_target_with_activity_carb, consumed_day_target_with_activity_protein, consumed_day_diff_sedentary_energy, consumed_day_diff_sedentary_fat, 
			consumed_day_diff_sedentary_carb, consumed_day_diff_sedentary_protein, consumed_day_diff_with_activity_energy, consumed_day_diff_with_activity_fat, consumed_day_diff_with_activity_carb, 
			consumed_day_diff_with_activity_protein, consumed_day_updated_datetime, consumed_day_synchronized) 
			VALUES 
			(NULL, $my_user_id_mysql, $year, $month, '$month_saying',
			$day, '$day_saying', '$date', '0', '0',
			 '0', '0',  '0', '0',  '0',
			 '0', '0',  '0', '0',  '0',
			
			'$get_goal_target_sedentary_calories', '$get_goal_target_sedentary_fat', '$get_goal_target_sedentary_carbs', '$get_goal_target_sedentary_proteins',
			'$get_goal_target_with_activity_calories', '$get_goal_target_with_activity_fat', '$get_goal_target_with_activity_carbs', '$get_goal_target_with_activity_proteins',
			'$get_goal_target_sedentary_calories', '$get_goal_target_sedentary_fat', '$get_goal_target_sedentary_carbs', '$get_goal_target_sedentary_proteins',
			'$get_goal_target_with_activity_calories', '$get_goal_target_with_activity_fat', '$get_goal_target_with_activity_carbs', 
			'$get_goal_target_with_activity_proteins', '$datetime', 0
			)")
			or die(mysqli_error($link));
			// echo"Ny dag, nye muligheter";
		}

		echo"
	<!-- //Todays Consumed Totals -->

	<!-- Rest -->
		";
		if($get_consumed_day_id != ""){
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
					$get_consumed_day_target_with_activity_energy<br />
					$get_consumed_day_target_sedentary_energy<br />
					</span>
				  </td>
				  <td style=\"text-align:center;\">
					<span>-</span>
				  </td>
				  <td style=\"text-align:center;\">
					<span>$get_consumed_day_energy</span>
				  </td>
				  <td>
					<span>=</span>
				  </td>
				  <td style=\"text-align:center;\">
					<span";
					if($get_consumed_day_energy > "$get_consumed_day_target_with_activity_energy"){
						echo" style=\"color:red;\"";
					}
					else{
						if($get_consumed_day_diff_with_activity_energy < 100){
							echo" style=\"color: #996600;\"";
						}
						else{
							echo" style=\"color: green;\"";
						}
					}
					echo">$get_consumed_day_diff_with_activity_energy<br /></span>

					<span";
					if($get_consumed_day_energy > "$get_consumed_day_target_sedentary_energy"){
						echo" style=\"color:red;\"";
					}
					else{
						if($get_consumed_day_diff_sedentary_energy < 100){
							echo" style=\"color: #996600;\"";
						}
						else{
							echo" style=\"color: green;\"";
						}
					}
					echo">$get_consumed_day_diff_sedentary_energy<br /></span>
					
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
	$hour_names = array("breakfast", "lunch", "before_training", "after_training", "dinner", "snacks", "supper");
	$hour_names_translated = array("$l_breakfast", "$l_lunch", "$l_before_training", "$l_after_training", "$l_dinner", "$l_snacks", "$l_supper");
	$date_mysql = quote_smart($link, $date);
	for($x=0;$x<7;$x++){
		// Find out how many calories I have eaten for this meal
		$query = "SELECT consumed_hour_id, consumed_hour_user_id, consumed_hour_date, consumed_hour_name, consumed_hour_energy, consumed_hour_fat, consumed_hour_saturated_fat, consumed_hour_monounsaturated_fat, consumed_hour_polyunsaturated_fat, consumed_hour_cholesterol, consumed_hour_carbohydrates, consumed_hour_carbohydrates_of_which_sugars, consumed_hour_dietary_fiber, consumed_hour_proteins, consumed_hour_salt, consumed_hour_sodium, consumed_hour_updated_datetime, consumed_hour_synchronized FROM $t_food_diary_consumed_hours WHERE consumed_hour_user_id=$my_user_id_mysql AND consumed_hour_date=$date_mysql AND consumed_hour_name='$hour_names[$x]'";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_consumed_hour_id, $get_consumed_hour_user_id, $get_consumed_hour_date, $get_consumed_hour_name, $get_consumed_hour_energy, $get_consumed_hour_fat, $get_consumed_hour_saturated_fat, $get_consumed_hour_monounsaturated_fat, $get_consumed_hour_polyunsaturated_fat, $get_consumed_hour_cholesterol, $get_consumed_hour_carbohydrates, $get_consumed_hour_carbohydrates_of_which_sugars, $get_consumed_hour_dietary_fiber, $get_consumed_hour_proteins, $get_consumed_hour_salt, $get_consumed_hour_sodium, $get_consumed_hour_updated_datetime, $get_consumed_hour_synchronized) = $row;
		if($get_consumed_hour_id == ""){
			// Insert this hour
			mysqli_query($link, "INSERT INTO $t_food_diary_consumed_hours
			(consumed_hour_id, consumed_hour_user_id, consumed_hour_date, consumed_hour_name, consumed_hour_energy, 
			consumed_hour_fat, consumed_hour_saturated_fat, consumed_hour_monounsaturated_fat, consumed_hour_polyunsaturated_fat, consumed_hour_cholesterol, 
			consumed_hour_carbohydrates, consumed_hour_carbohydrates_of_which_sugars, consumed_hour_dietary_fiber, consumed_hour_proteins, consumed_hour_salt, 
			consumed_hour_sodium, consumed_hour_updated_datetime, consumed_hour_synchronized) 
			VALUES 
			(NULL, $my_user_id_mysql, $date_mysql, '$hour_names[$x]', '0', 
			'0', '0', '0', '0', '0',
			'0', '0', '0', '0', '0',
			'0', '$datetime', 0)")
			or die(mysqli_error($link));
		}

		echo"
		<div style=\"height: 8px;\"></div>
		<a id=\"hour_$hour_names[$x]\"></a>
		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\" id=\"thhour_$hour_names[$x]\">
			";
			if($date == "$today"){
				echo"
				<span style=\"font-weight: bold;\"><a href=\"food_diary_add.php?date=$date&amp;hour_name=$hour_names[$x]&amp;l=$l\"><img src=\"_gfx/list-add.png\" alt=\"list-add.png\" style=\"float: left;padding: 1px 4px 0px 0px;\" /></a></span>  
				  
					<script>
					\$(document).ready(function(){
						\$('#thhour_$hour_names[$x]').click(function(){
							window.location= \"food_diary_add.php?date=$date&hour_name=$hour_names[$x]&l=$l\";
						});
					});
					</script>


					<span><a href=\"food_diary_add.php?date=$date&amp;hour_name=$hour_names[$x]&amp;l=$l\" style=\"font-weight: bold;color: #000;\">$hour_names_translated[$x]</a></span>  
				  ";
			}
			else{
				echo"
				<span style=\"font-weight: bold;color: #000;\">$hour_names_translated[$x]</span>  
				";
			}
			echo"
		   </th>
		   <th style=\"text-align: right;vertical-align: top;padding: 0px 4px 0px 0px;\">
			<span style=\"font-weight: bold;\">$get_consumed_hour_energy</span>  
		   </th>
		  </tr>
		 </thead>
		 <tbody>
		";
	

		$query = "SELECT entry_id, entry_user_id, entry_date, entry_hour_name, entry_food_id, entry_recipe_id, entry_name, entry_manufacturer_name, entry_serving_size, entry_serving_size_measurement, entry_energy_per_entry, entry_fat_per_entry, entry_saturated_fat_per_entry, entry_monounsaturated_fat_per_entry, entry_polyunsaturated_fat_per_entry, entry_cholesterol_per_entry, entry_carbohydrates_per_entry, entry_carbohydrates_of_which_sugars_per_entry, entry_dietary_fiber_per_entry, entry_proteins_per_entry, entry_salt_per_entry, entry_sodium_per_entry, entry_text, entry_deleted, entry_updated_datetime, entry_synchronized FROM $t_food_diary_entires WHERE entry_user_id=$my_user_id_mysql AND entry_date=$date_mysql AND entry_hour_name='$hour_names[$x]'";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
    		list($get_entry_id, $get_entry_user_id, $get_entry_date, $get_entry_hour_name, $get_entry_food_id, $get_entry_recipe_id, $get_entry_name, $get_entry_manufacturer_name, $get_entry_serving_size, $get_entry_serving_size_measurement, $get_entry_energy_per_entry, $get_entry_fat_per_entry, $get_entry_saturated_fat_per_entry, $get_entry_monounsaturated_fat_per_entry, $get_entry_polyunsaturated_fat_per_entry, $get_entry_cholesterol_per_entry, $get_entry_carbohydrates_per_entry, $get_entry_carbohydrates_of_which_sugars_per_entry, $get_entry_dietary_fiber_per_entry, $get_entry_proteins_per_entry, $get_entry_salt_per_entry, $get_entry_sodium_per_entry, $get_entry_text, $get_entry_deleted, $get_entry_updated_datetime, $get_entry_synchronized) = $row;
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

				$total_fat_carb_proteins = $get_consumed_day_fat+$get_consumed_day_carbohydrates+$get_consumed_day_proteins;
				if($get_consumed_day_id != "" && $get_consumed_day_fat != "0"){
					$get_consumed_day_fat_percentage = round(($get_consumed_day_fat/$total_fat_carb_proteins)*100, 0);
				}
				else{
					$get_consumed_day_fat_percentage = 0;
				}
				if($get_consumed_day_id != "" && $get_consumed_day_carbohydrates != "0"){
					$get_consumed_day_carb_percentage = round(($get_consumed_day_carbohydrates/$total_fat_carb_proteins)*100, 0);
				}
				else{
					$get_consumed_day_carb_percentage = 0;
				}
				
				if($get_consumed_day_id != "" && $get_consumed_day_proteins != "0"){
					$get_consumed_day_protein_percentage = round(($get_consumed_day_proteins/$total_fat_carb_proteins)*100, 0);
				}
				else{
					$get_consumed_day_protein_percentage = 0;
				}
				$sum_consumed_fat_carb_proteins_percentage  = $get_consumed_day_fat_percentage + $get_consumed_day_carb_percentage + $get_consumed_day_protein_percentage;
				if($sum_consumed_fat_carb_proteins_percentage != "0" && $sum_consumed_fat_carb_proteins_percentage != "100"){
					 $get_consumed_day_protein_percentage = $get_consumed_day_protein_percentage+1;
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
						<span>$get_consumed_day_energy&nbsp;$l_kcal_lowercase</span>
					  </td>
					 </tr>
					 <tr>
					  <td style=\"padding: 0px 4px 0px 0px;\">
						<span style=\"font-weight: bold;\">$l_fat:</span>
					  </td>
					  <td>
						<span>$get_consumed_day_fat</span>
					  </td>
					 </tr>
					 <tr>
					  <td style=\"padding: 0px 4px 0px 0px;\">
						<span style=\"font-weight: bold;\">$l_carb:</span>
					  </td>
					  <td>
						<span>$get_consumed_day_carbohydrates</span>
					  </td>
					 </tr>
					 <tr>
					  <td style=\"padding: 0px 4px 0px 0px;\">
						<span style=\"font-weight: bold;\">$l_proteins:</span>
					  </td>
					  <td>
						<span>$get_consumed_day_proteins</span>
					  </td>
					 </tr>
					</table>
				  </td>
				  <td style=\"text-align: right;width:100px;padding-top: 6px;\">
					<span>
					<img src=\"_gfx/pie_chart.php?numbers=$get_consumed_day_protein_percentage,$get_consumed_day_carb_percentage,$get_consumed_day_fat_percentage\" alt=\"pie_chart.php\" style=\"padding-bottom: 4px;\" />
					
					</span>
				  </td>
				  <td style=\"vertical-align: top;text-align: right;width:170px;padding-top: 16px;\">
					<table style=\"width: 100%\">
					 <tr>
					  <td style=\"padding: 0px 4px 0px 0px;\">
						<span>$l_fat ($get_consumed_day_fat_percentage %)</span>
					  </td>
					  <td>
						<span style=\"font-weight: bold;\"><img src=\"_gfx/dot_blue.png\" alt=\"dot_blue.png\" /></span>
					  </td>
					 </tr>
					 <tr>
					  <td style=\"padding: 0px 4px 0px 0px;\">
						<span>$l_carbs ($get_consumed_day_carb_percentage %)</span>
					  </td>
					  <td>
						<span style=\"font-weight: bold;\"><img src=\"_gfx/dot_red.png\" alt=\"dot_red.png\" /></span>
					  </td>
					 </tr>
					 <tr>
					  <td style=\"padding: 0px 4px 0px 0px;\">
						<span>$l_proteins ($get_consumed_day_protein_percentage %)</span>
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