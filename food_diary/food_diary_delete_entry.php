<?php
/**
*
* File: food_diary/food_diary_delete_entry.php
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

/*- Translation ------------------------------------------------------------------------------ */
include("$root/_admin/_translations/site/$l/food_diary/ts_food_diary.php");
include("$root/_admin/_translations/site/$l/food_diary/ts_food_diary_edit_entry.php");


/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_food_diary - $l_edit_entry";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");


/*- Content ---------------------------------------------------------------------------------- */
// Logged in?
if(isset($_SESSION['user_id']) && isset($_SESSION['security']) && isset($_GET['entry_id'])) {

	// Get my profile
	$my_user_id = $_SESSION['user_id'];
	$my_user_id_mysql = quote_smart($link, $my_user_id);
	$query = "SELECT user_id, user_alias, user_email, user_gender, user_height, user_measurement, user_dob FROM $t_users WHERE user_id=$my_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_my_user_id, $get_my_user_alias, $get_my_user_email, $get_my_user_gender, $get_my_user_height, $get_my_user_measurement, $get_my_user_dob) = $row;
	
	// Get entry

	$entry_id = $_GET['entry_id'];
	$entry_id = strip_tags(stripslashes($entry_id));
	$entry_id_mysql = quote_smart($link, $entry_id);

	$query = "SELECT entry_id, entry_user_id, entry_date, entry_meal_id, entry_food_id, entry_recipe_id, entry_name, entry_manufacturer_name, entry_serving_size, entry_serving_size_measurement, entry_energy_per_entry, entry_fat_per_entry, entry_carb_per_entry, entry_protein_per_entry, entry_text FROM $t_food_diary_entires WHERE entry_id=$entry_id_mysql AND entry_user_id=$my_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_entry_id, $get_current_entry_user_id, $get_current_entry_date, $get_current_entry_meal_id, $get_current_entry_food_id, $get_current_entry_recipe_id, $get_current_entry_name, $get_current_entry_manufacturer_name, $get_current_entry_serving_size, $get_current_entry_serving_size_measurement, $get_current_entry_energy_per_entry, $get_current_entry_fat_per_entry, $get_current_entry_carb_per_entry, $get_current_entry_protein_per_entry, $get_current_entry_text) = $row;
	
	if($get_current_entry_id == ""){
		echo"
		<h1>Server error 404</h1>
		<p>Entry not found.</p>
		";
	}
	else{
		if($process == "1"){
			
			$inp_updated = date("Y-m-d H:i:s");
			$inp_updated_mysql = quote_smart($link, $inp_updated);


			$result = mysqli_query($link, "DELETE FROM $t_food_diary_entires WHERE entry_id=$entry_id_mysql AND entry_user_id=$my_user_id_mysql");



			
			// food_diary_totals_meals :: Calcualte :: Get all meals for that day, and update numbers
			$inp_total_meal_energy = 0;
			$inp_total_meal_fat = 0;
			$inp_total_meal_carb = 0;
			$inp_total_meal_protein = 0;
			
			$query = "SELECT entry_id, entry_energy_per_entry, entry_fat_per_entry, entry_carb_per_entry, entry_protein_per_entry FROM $t_food_diary_entires WHERE entry_user_id=$my_user_id_mysql AND entry_date='$get_current_entry_date' AND entry_meal_id='$get_current_entry_meal_id'";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
    				list($get_entry_id, $get_entry_energy_per_entry, $get_entry_fat_per_entry, $get_entry_carb_per_entry, $get_entry_protein_per_entry) = $row;

				
				$inp_total_meal_energy 		= $inp_total_meal_energy+$get_entry_energy_per_entry;
				$inp_total_meal_fat 		= $inp_total_meal_fat+$get_entry_fat_per_entry;
				$inp_total_meal_carb		= $inp_total_meal_carb+$get_entry_carb_per_entry;
				$inp_total_meal_protein 	= $inp_total_meal_protein+$get_entry_protein_per_entry;
			}
			
			$result = mysqli_query($link, "UPDATE $t_food_diary_totals_meals SET 
			total_meal_energy='$inp_total_meal_energy', total_meal_fat='$inp_total_meal_fat', total_meal_carb='$inp_total_meal_carb', total_meal_protein='$inp_total_meal_protein',
			total_meal_updated=$inp_updated_mysql, total_meal_synchronized='0'
			 WHERE total_meal_user_id=$my_user_id_mysql AND total_meal_date='$get_current_entry_date' AND total_meal_meal_id='$get_current_entry_meal_id'");


			// food_diary_totals_days
			$query = "SELECT total_day_id, total_day_user_id, total_day_date, total_day_consumed_energy, total_day_consumed_fat, total_day_consumed_carb, total_day_consumed_protein, total_day_target_sedentary_energy, total_day_target_sedentary_fat, total_day_target_sedentary_carb, total_day_target_sedentary_protein, total_day_target_with_activity_energy, total_day_target_with_activity_fat, total_day_target_with_activity_carb, total_day_target_with_activity_protein, total_day_diff_sedentary_energy, total_day_diff_sedentary_fat, total_day_diff_sedentary_carb, total_day_diff_sedentary_protein, total_day_diff_with_activity_energy, total_day_diff_with_activity_fat, total_day_diff_with_activity_carb, total_day_diff_with_activity_protein FROM $t_food_diary_totals_days WHERE total_day_user_id=$my_user_id_mysql AND total_day_date='$get_current_entry_date'";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_total_day_id, $get_total_day_user_id, $get_total_day_date, $get_total_day_consumed_energy, $get_total_day_consumed_fat, $get_total_day_consumed_carb, $get_total_day_consumed_protein, $get_total_day_target_sedentary_energy, $get_total_day_target_sedentary_fat, $get_total_day_target_sedentary_carb, $get_total_day_target_sedentary_protein, $get_total_day_target_with_activity_energy, $get_total_day_target_with_activity_fat, $get_total_day_target_with_activity_carb, $get_total_day_target_with_activity_protein, $get_total_day_diff_sedentary_energy, $get_total_day_diff_sedentary_fat, $get_total_day_diff_sedentary_carb, $get_total_day_diff_sedentary_protein, $get_total_day_diff_with_activity_energy, $get_total_day_diff_with_activity_fat, $get_total_day_diff_with_activity_carb, $get_total_day_diff_with_activity_protein) = $row;

			$inp_total_day_consumed_energy = 0;
			$inp_total_day_consumed_fat = 0;
			$inp_total_day_consumed_carb = 0;
			$inp_total_day_consumed_protein = 0;
			$query = "SELECT total_meal_id, total_meal_energy, total_meal_fat, total_meal_carb, total_meal_protein FROM $t_food_diary_totals_meals WHERE total_meal_user_id=$my_user_id_mysql AND total_meal_date='$get_current_entry_date'";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
    				list($get_total_meal_id, $get_total_meal_energy, $get_total_meal_fat, $get_total_meal_carb, $get_total_meal_protein) = $row;

				
				$inp_total_day_consumed_energy  = $inp_total_day_consumed_energy+$get_total_meal_energy;
				$inp_total_day_consumed_fat     = $inp_total_day_consumed_fat+$get_total_meal_fat;
				$inp_total_day_consumed_carb    = $inp_total_day_consumed_carb+$get_total_meal_carb;
				$inp_total_day_consumed_protein = $inp_total_day_consumed_protein+$get_total_meal_protein;
			}


			$inp_total_day_diff_sedentary_energy = $get_total_day_target_sedentary_energy-$inp_total_day_consumed_energy;
			$inp_total_day_diff_sedentary_fat = $get_total_day_target_sedentary_fat-$inp_total_day_consumed_fat;
			$inp_total_day_diff_sedentary_carb = $get_total_day_target_sedentary_energy-$inp_total_day_consumed_carb;
			$inp_total_day_diff_sedentary_protein = $get_total_day_target_sedentary_energy-$inp_total_day_consumed_protein;
	

			$inp_total_day_diff_with_activity_energy = $get_total_day_target_with_activity_energy-$inp_total_day_consumed_energy;
			$inp_total_day_diff_with_activity_fat = $get_total_day_target_with_activity_fat-$inp_total_day_consumed_fat;
			$inp_total_day_diff_with_activity_carb = $get_total_day_target_with_activity_energy-$inp_total_day_consumed_carb;
			$inp_total_day_diff_with_activity_protein = $get_total_day_target_with_activity_energy-$inp_total_day_consumed_protein;

			$result = mysqli_query($link, "UPDATE $t_food_diary_totals_days SET 
			total_day_consumed_energy='$inp_total_day_consumed_energy', total_day_consumed_fat='$inp_total_day_consumed_fat', total_day_consumed_carb='$inp_total_day_consumed_carb', total_day_consumed_protein=$inp_total_day_consumed_protein,
			total_day_diff_sedentary_energy='$inp_total_day_diff_sedentary_energy', total_day_diff_sedentary_fat='$inp_total_day_diff_sedentary_fat', total_day_diff_sedentary_carb='$inp_total_day_diff_sedentary_carb', total_day_diff_sedentary_protein='$inp_total_day_diff_sedentary_protein',
			total_day_diff_with_activity_energy='$inp_total_day_diff_with_activity_energy', total_day_diff_with_activity_fat='$inp_total_day_diff_with_activity_fat', total_day_diff_with_activity_carb='$inp_total_day_diff_with_activity_carb', total_day_diff_with_activity_protein='$inp_total_day_diff_with_activity_protein',
			total_day_updated=$inp_updated_mysql, total_day_synchronized='0'
			 WHERE total_day_user_id=$my_user_id_mysql AND total_day_date='$get_current_entry_date'");




			$url = "index.php?date=$get_current_entry_date&l=$l&ft=success&fm=entry_deleted#meal$get_current_entry_meal_id";
			header("Location: $url");
			exit;
		} // process




		// Date
		$year  = substr($get_current_entry_date, 0, 4);
		$month = substr($get_current_entry_date, 5, 2);
		$day   = substr($get_current_entry_date, 8, 2);
			
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

		echo"
		<h1>$get_current_entry_name</h1>

	
		<!-- Feedback -->
		";
		if($ft != "" && $fm != ""){
		if($fm == "changes_saved"){
			$fm = "$l_changes_saved";
		}
		else{
			$fm = ucfirst($fm);
		}
		echo"<div class=\"$ft\"><p>$fm</p></div>";
		}
		echo"
		<!-- //Feedback -->


		<!-- You are here -->
			<p><b>$l_you_are_here</b><br />
			<a href=\"index.php?l=$l\">$l_food_diary</a>
			&gt;
			<a href=\"index.php?date=$get_current_entry_date&amp;l=$l\">$day $month_saying $year</a>
			&gt;
			<a href=\"index.php?date=$get_current_entry_date&amp;l=$l#meal$get_current_entry_meal_id\">";

			if($get_current_entry_meal_id == "0"){
				echo"$l_breakfast";
			}
			elseif($get_current_entry_meal_id == "1"){
				echo"$l_lunch";
			}
			elseif($get_current_entry_meal_id == "2"){
				echo"$l_before_training";
			}
			elseif($get_current_entry_meal_id == "3"){
				echo"$l_after_training";
			}
			elseif($get_current_entry_meal_id == "4"){
				echo"$l_dinner";
			}
			elseif($get_current_entry_meal_id == "5"){
				echo"$l_snacks";
			}
			elseif($get_current_entry_meal_id == "6"){
				echo"$l_supper";
			}
			else{
				echo"??";die;
			}
			echo"</a>
			&gt;
			<a href=\"food_diary_edit_entry.php?entry_id=$entry_id&amp;l=$l\">$get_current_entry_name</a>
			&gt;
			<a href=\"food_diary_delete_entry.php?entry_id=$entry_id&amp;l=$l\">$l_delete</a>
			</p>
		<!-- //You are here -->


		<p>
		$l_are_you_sure
		</p>

		<p>
		<a href=\"food_diary_delete_entry.php?entry_id=$entry_id&amp;l=$l&amp;process=1\">$l_delete</a>
		</p>
		";
		
	} // entry found
}
else{
	echo"
	<h1>
	<img src=\"$root/_webdesign/images/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" />
	Loading...</h1>
	<meta http-equiv=\"refresh\" content=\"1;url=$root/users/login?l=$l&amp;referer=$root/food_diary/index.php\">
	";
}



/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>