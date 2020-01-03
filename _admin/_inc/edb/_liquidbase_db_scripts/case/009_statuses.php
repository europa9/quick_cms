<?php
/**
*
* File: _admin/_inc/edb/_liquibase/case/009_statuses.php
* Version 1.0.0
* Date 21:19 28.08.2019
* Copyright (c) 2019 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}




echo"

<!-- edb_case_statuses-->
";

$query = "SELECT * FROM $t_edb_case_statuses LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_statuses: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_case_statuses(
	  status_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(status_id), 
	   status_parent_id INT,
	   status_title VARCHAR(200), 
	   status_title_clean VARCHAR(200), 
	   status_bg_color VARCHAR(200), 
	   status_border_color VARCHAR(200), 
	   status_text_color VARCHAR(200), 
	   status_link_color VARCHAR(200), 
	   status_weight INT, 
	   status_number_of_cases_now INT,
	   status_number_of_cases_max INT,
	   status_show_on_front_page INT,
	   status_on_given_status_do_close_case INT,
	   status_on_person_view_show_without_person INT,
	   status_on_person_view_show_before_person INT,
	   status_show_on_stats_page INT,
	   status_show_as_image INT,
	   status_image_path VARCHAR(200), 
	   status_image_file VARCHAR(200), 
	   status_gives_amount_of_points_to_user INT)")
	   or die(mysqli_error());	
	
	mysqli_query($link, "INSERT INTO $t_edb_case_statuses
	(`status_id`, `status_parent_id`, `status_title`, `status_title_clean`, `status_bg_color`, `status_border_color`, `status_text_color`, `status_link_color`, `status_weight`, `status_number_of_cases_now`, `status_number_of_cases_max`, `status_show_on_front_page`, `status_on_given_status_do_close_case`, `status_on_person_view_show_without_person`, `status_on_person_view_show_before_person`, `status_show_on_stats_page`, `status_show_as_image`, `status_image_path`, `status_image_file`, `status_gives_amount_of_points_to_user`) 
	VALUES 
	(NULL, NULL, 'Uten status', 'uten_status', '', '', '', '', 1, 0, 10, 1, 0, 1, 1, 1, NULL, NULL, NULL, 0),
	(NULL, NULL, 'Sikres', 'sikres', '', '', '', '', 2, 0, 10, 1, 0, 0, 1, 1, NULL, NULL, NULL, 0),
	(NULL, NULL, 'Analyse', 'analyse', '', '', '', '', 3, 0, 10, 1, 0, 0, 1, 1, NULL, NULL, NULL, 0),
	(NULL, NULL, 'P&aring; vent', 'pa_vent', '', '', '', '', 4, 0, 10, 1, 0, 0, 1, 1, NULL, NULL, NULL, 0),
	(NULL, NULL, 'Ferdig sikret', 'ferdig_sikret', '', '', '', '', 5, 0, 10, 1, 0, 1, 1, 1, NULL, NULL, NULL, 0),
	(NULL, NULL, 'Ferdig', 'ferdig', '', '', '', '', 6, 0, 10, 1, 1, 1, 0, 1, NULL, NULL, NULL, 5),
	(NULL, NULL, 'Avvist', 'avvist', '', '', '', '', 7, 0, 0, 0, 1, 1, 1, 1, NULL, NULL, NULL, 0)
	") or die(mysqli_error($link));

}
echo"
<!-- //edb_statuses -->

";
?>