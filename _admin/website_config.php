<?php
error_reporting(E_ALL & ~E_STRICT);
@session_start();
ini_set('arg_separator.output', '&amp;');

/**
*
* File: _admin/website_config.php
* Version 1.0
* Date 00.53 21.03.2017
* Copyright (c) 2008-2017 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Configs ------------------------------------------------------------------------ */
if(file_exists("$root/_admin/_data/config/meta.php")){
	include("$root/_admin/_data/config/meta.php");
	include("$root/_admin/_data/config/user_system.php");
	include("$root/_admin/_data/webdesign.php");
}



/*- Important functions ---------------------------------------------------------------- */
include("$root/_admin/_functions/output_html.php");
include("$root/_admin/_functions/clean.php");


/*- SSL? ------------------------------------------------------------------------------- */
$server_name = $_SERVER['HTTP_HOST'];
$server_name = clean($server_name);
$ssl_config_file = "ssl_" . $server_name . ".php";
if(file_exists("$root/_admin/_data/config/$ssl_config_file")){
	include("$root/_admin/_data/config/$ssl_config_file");
	if($configSLLActiveSav == "1"){
		include("$root/_admin/_functions/use_ssl.php");
	}
}



/*- Other Functions ------------------------------------------------------------------- */
include("$root/_admin/_functions/clean_dir_reverse.php");
include("$root/_admin/_functions/resize_crop_image.php");
include("$root/_admin/_functions/quote_smart.php");
include("$root/_admin/_functions/page_url.php");
include("$root/_admin/_functions/get_extension.php");

/*- Common variables ----------------------------------------------------------------- */
$server_name = $_SERVER['HTTP_HOST'];
$server_name = clean($server_name);

/*- Check if setup is run ------------------------------------------------------------ */
$check = substr($server_name, 0, 3);
if($check == "www"){
	$server_name = substr($server_name, 3);
}
$setup_finished_file = "setup_finished_" . $server_name . ".php";
if(!(file_exists("$root/_admin/_data/$setup_finished_file"))){
	echo"<p style=\"color:#fff;background:#000;font-size:100px;\">Setup required.</p><meta http-equiv=refresh content=\"1; URL=$root/_admin/index.php\">";
	die;
}



/*- Variables ------------------------------------------------------------------------ */
if (isset($_GET['page'])) {
	$page = $_GET['page'];
	$page = stripslashes(strip_tags($page));
}
else{
	$page = "";
}
if(isset($_GET['action'])) {
	$action = $_GET['action'];
	$action = strip_tags(stripslashes($action));
}
else{
	$action = "";
}
if(isset($_GET['mode'])) {
	$mode = $_GET['mode'];
	$mode = strip_tags(stripslashes($mode));
}
else{
	$mode = "";
}
if(isset($_GET['process'])) {
	$process = $_GET['process'];
	$process = strip_tags(stripslashes($process));
}
else{
	$process = "";
}

if(isset($_GET['print'])) {
	$print = $_GET['print'];
	$print = strip_tags(stripslashes($print));
}
else{
	$print = "";
}
if(isset($_GET['ft'])) {
	$ft = $_GET['ft'];
	$ft = strip_tags(stripslashes($ft));
	if($ft != "error" && $ft != "warning" && $ft != "success" && $ft != "info"){
		echo"Server error 403 feedback error";die;
	}
}
else{
	$ft = "";
}
if(isset($_GET['fm'])) {
	$fm = $_GET['fm'];
	$fm = strip_tags(stripslashes($fm));
}


/*- MySQL ---------------------------------------------------------------------------- */
$mysql_config_file = "$root/_admin/_data/mysql_" . $server_name . ".php";
if(file_exists($mysql_config_file)){
	include("$mysql_config_file");
	$link = mysqli_connect($mysqlHostSav, $mysqlUserNameSav, $mysqlPasswordSav, $mysqlDatabaseNameSav);
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	/*- MySQL Tables -------------------------------------------------- */
	$t_users 	 		= $mysqlPrefixSav . "users";
	$t_users_profile 		= $mysqlPrefixSav . "users_profile";
	$t_users_friends 		= $mysqlPrefixSav . "users_friends";
	$t_users_friends_requests 	= $mysqlPrefixSav . "users_friends_requests";
	$t_users_profile		= $mysqlPrefixSav . "users_profile";
	$t_users_profile_photo 		= $mysqlPrefixSav . "users_profile_photo";
	$t_users_status 		= $mysqlPrefixSav . "users_status";
	$t_users_status_subscriptions	= $mysqlPrefixSav . "users_status_subscriptions";
	$t_users_status_replies 	= $mysqlPrefixSav . "users_status_replies";
	$t_users_status_replies_likes 	= $mysqlPrefixSav . "users_status_replies_likes";
	$t_users_status_likes 		= $mysqlPrefixSav . "users_status_likes";
	$t_users_profile 		= $mysqlPrefixSav . "users_profile";
	$t_users_profile_views 		= $mysqlPrefixSav . "users_profile_views";
	$t_users_professional		= $mysqlPrefixSav . "users_professional";
	$t_users_cover_photos 		= $mysqlPrefixSav . "users_cover_photos";
	$t_users_email_subscriptions 	= $mysqlPrefixSav . "users_email_subscriptions";
	$t_users_notifications 		= $mysqlPrefixSav . "users_notifications";
	$t_users_moderator_of_the_week	= $mysqlPrefixSav . "users_moderator_of_the_week";

	$t_users_antispam_questions	= $mysqlPrefixSav . "users_antispam_questions";
	$t_users_antispam_answers	= $mysqlPrefixSav . "users_antispam_answers";

	$t_users_api_sessions		= $mysqlPrefixSav . "users_api_sessions";

	$t_banned_hostnames	= $mysqlPrefixSav . "banned_hostnames";
	$t_banned_ips	 	= $mysqlPrefixSav . "banned_ips";
	$t_banned_user_agents	= $mysqlPrefixSav . "banned_user_agents";


	$t_stats_bot_ipblock 		= $mysqlPrefixSav . "stats_bot_ipblock";
	$t_stats_human_ipblock 		= $mysqlPrefixSav . "stats_human_ipblock";
	$t_stats_human_online_records	= $mysqlPrefixSav . "stats_human_online_records";
	$t_stats_user_agents 		= $mysqlPrefixSav . "stats_user_agents";
	$t_stats_dayli 			= $mysqlPrefixSav . "stats_dayli";
	$t_stats_monthly		= $mysqlPrefixSav . "stats_monthly";
	$t_stats_browsers 		= $mysqlPrefixSav . "stats_browsers";
	$t_stats_os	 		= $mysqlPrefixSav . "stats_os";
	$t_stats_bots			= $mysqlPrefixSav . "stats_bots";
	$t_stats_accepted_languages	= $mysqlPrefixSav . "stats_accepted_languages";
	$t_stats_referers		= $mysqlPrefixSav . "stats_referers";

	$t_stats_users_registered_weekly  = $mysqlPrefixSav . "stats_users_registered_weekly";
	$t_stats_users_registered_monthly = $mysqlPrefixSav . "stats_users_registered_monthly";
	$t_stats_users_registered_yearly  = $mysqlPrefixSav . "stats_users_registered_yearly";

	$t_stats_comments_weekly  = $mysqlPrefixSav . "stats_comments_weekly";
	$t_stats_comments_monthly = $mysqlPrefixSav . "stats_comments_monthly";
	$t_stats_comments_yearly  = $mysqlPrefixSav . "stats_comments_yearly";
	$t_stats_countries  	= $mysqlPrefixSav . "stats_countries";
	$t_stats_ip_to_country_ipv4 		= $mysqlPrefixSav . "stats_ip_to_country_ipv4";
	$t_stats_ip_to_country_ipv6 		= $mysqlPrefixSav . "stats_ip_to_country_ipv6";
	$t_stats_ip_to_country_geonames 	= $mysqlPrefixSav . "stats_ip_to_country_geonames";


	$t_pages 		= $mysqlPrefixSav . "pages";
	$t_navigation 		= $mysqlPrefixSav . "navigation";

	$t_comments		= $mysqlPrefixSav . "comments";
	$t_comments_users_block	= $mysqlPrefixSav . "comments_users_block";

	$t_images	= $mysqlPrefixSav . "images";
	$t_images_paths	= $mysqlPrefixSav . "images_paths";

	$t_languages		 = $mysqlPrefixSav . "languages";
	$t_languages_active 	= $mysqlPrefixSav . "languages_active";

	$t_liquidbase		  = $mysqlPrefixSav . "liquidbase";

	$t_social_media 	= $mysqlPrefixSav . "social_media";

	$t_analytics 		= $mysqlPrefixSav . "analytics";

	$t_admin_messages_inbox		= $mysqlPrefixSav . "admin_messages_inbox";

	/*- Tables ads -------------------------------------------------------------------- */
	$t_ads_index		= $mysqlPrefixSav . "ads_index";
	$t_ads_advertisers	= $mysqlPrefixSav . "ads_advertisers";


	/*- Tables recipes -------------------------------------------------------------------- */
	$t_recipes 	 			= $mysqlPrefixSav . "recipes";
	$t_recipes_ingredients			= $mysqlPrefixSav . "recipes_ingredients";
	$t_recipes_favorites			= $mysqlPrefixSav . "recipes_favorites";
	$t_recipes_groups			= $mysqlPrefixSav . "recipes_groups";
	$t_recipes_items			= $mysqlPrefixSav . "recipes_items";
	$t_recipes_numbers			= $mysqlPrefixSav . "recipes_numbers";
	$t_recipes_rating			= $mysqlPrefixSav . "recipes_rating";
	$t_recipes_cuisines			= $mysqlPrefixSav . "recipes_cuisines";
	$t_recipes_cuisines_translations	= $mysqlPrefixSav . "recipes_cuisines_translations";
	$t_recipes_seasons			= $mysqlPrefixSav . "recipes_seasons";
	$t_recipes_seasons_translations		= $mysqlPrefixSav . "recipes_seasons_translations";
	$t_recipes_occasions			= $mysqlPrefixSav . "recipes_occasions";
	$t_recipes_occasions_translations	= $mysqlPrefixSav . "recipes_occasions_translations";
	$t_recipes_categories			= $mysqlPrefixSav . "recipes_categories";
	$t_recipes_categories_translations	= $mysqlPrefixSav . "recipes_categories_translations";
	$t_recipes_weekly_special		= $mysqlPrefixSav . "recipes_weekly_special";
	$t_recipes_of_the_day			= $mysqlPrefixSav . "recipes_of_the_day";
	$t_recipes_comments			= $mysqlPrefixSav . "recipes_comments";
	$t_recipes_tags				= $mysqlPrefixSav . "recipes_tags";
	$t_recipes_links			= $mysqlPrefixSav . "recipes_links";
	$t_recipes_comments			= $mysqlPrefixSav . "recipes_comments";
	$t_recipes_searches			= $mysqlPrefixSav . "recipes_searches";
	$t_recipes_age_restrictions 	 	= $mysqlPrefixSav . "recipes_age_restrictions";
	$t_recipes_age_restrictions_accepted	= $mysqlPrefixSav . "recipes_age_restrictions_accepted";

	/*- Tables ---------------------------------------------------------------------------- */
	$t_food_categories		  	= $mysqlPrefixSav . "food_categories";
	$t_food_categories_translations	  	= $mysqlPrefixSav . "food_categories_translations";
	$t_food_index			 	= $mysqlPrefixSav . "food_index";
	$t_food_index_stores		 	= $mysqlPrefixSav . "food_index_stores";
	$t_food_index_ads		 	= $mysqlPrefixSav . "food_index_ads";
	$t_food_index_tags		  	= $mysqlPrefixSav . "food_index_tags";
	$t_food_index_prices		  	= $mysqlPrefixSav . "food_index_prices";
	$t_food_index_contents		 	= $mysqlPrefixSav . "food_index_contents";
	$t_food_index_favorites  	  	= $mysqlPrefixSav . "food_index_favorites";
	$t_food_stores		  	  	= $mysqlPrefixSav . "food_stores";
	$t_food_prices_currencies	  	= $mysqlPrefixSav . "food_prices_currencies";
	$t_food_favorites 		  	= $mysqlPrefixSav . "food_favorites";
	$t_food_measurements	 	  	= $mysqlPrefixSav . "food_measurements";
	$t_food_measurements_translations 	= $mysqlPrefixSav . "food_measurements_translations";
	$t_food_countries_used	 	 	= $mysqlPrefixSav . "food_countries_used";
	$t_food_integration	 	  	= $mysqlPrefixSav . "food_integration";
	$t_food_age_restrictions 	 	= $mysqlPrefixSav . "food_age_restrictions";
	$t_food_age_restrictions_accepted	= $mysqlPrefixSav . "food_age_restrictions_accepted";

	/*- Tables food diary -------------------------------------------------------------------- */
	$t_food_diary_goals   		= $mysqlPrefixSav . "food_diary_goals";
	$t_food_diary_entires 		= $mysqlPrefixSav . "food_diary_entires";
	$t_food_diary_totals_meals  	= $mysqlPrefixSav . "food_diary_totals_meals";
	$t_food_diary_totals_days  	= $mysqlPrefixSav . "food_diary_totals_days";
	$t_food_diary_last_used  	= $mysqlPrefixSav . "food_diary_last_used";

	/*- Tables exercises ---------------------------------------------------------------- */
	$t_exercise_index 				= $mysqlPrefixSav . "exercise_index";
	$t_exercise_index_translations_relations	= $mysqlPrefixSav . "exercise_index_translations_relations";
	$t_exercise_index_images			= $mysqlPrefixSav . "exercise_index_images";
	$t_exercise_index_videos			= $mysqlPrefixSav . "exercise_index_videos";
	$t_exercise_index_muscles			= $mysqlPrefixSav . "exercise_index_muscles";
	$t_exercise_index_muscles_images		= $mysqlPrefixSav . "exercise_index_muscles_images";
	$t_exercise_index_tags				= $mysqlPrefixSav . "exercise_index_tags";
	$t_exercise_tags_cloud				= $mysqlPrefixSav . "exercise_tags_cloud";
	$t_exercise_equipments 				= $mysqlPrefixSav . "exercise_equipments";
	$t_exercise_types				= $mysqlPrefixSav . "exercise_types";
	$t_exercise_types_translations 			= $mysqlPrefixSav . "exercise_types_translations";
	$t_exercise_levels				= $mysqlPrefixSav . "exercise_levels";
	$t_exercise_levels_translations 		= $mysqlPrefixSav . "exercise_levels_translations";

	/*- Tables muscles ---------------------------------------------------------------- */
	$t_muscles				= $mysqlPrefixSav . "muscles";
	$t_muscles_translations 		= $mysqlPrefixSav . "muscles_translations";
	$t_muscle_groups 			= $mysqlPrefixSav . "muscle_groups";
	$t_muscle_groups_translations	 	= $mysqlPrefixSav . "muscle_groups_translations";
	$t_muscle_part_of 			= $mysqlPrefixSav . "muscle_part_of";
	$t_muscle_part_of_translations	 	= $mysqlPrefixSav . "muscle_part_of_translations";

	/*- Workout plans ------------------------------------------------------------- */
	$t_workout_plans_yearly  				= $mysqlPrefixSav . "workout_plans_yearly";
	$t_workout_plans_period  				= $mysqlPrefixSav . "workout_plans_period";
	$t_workout_plans_weekly  				= $mysqlPrefixSav . "workout_plans_weekly";
	$t_workout_plans_weekly_tags  		= $mysqlPrefixSav . "workout_plans_weekly_tags";
	$t_workout_plans_weekly_tags_unique  	= $mysqlPrefixSav . "workout_plans_weekly_tags_unique";
	$t_workout_plans_sessions 				= $mysqlPrefixSav . "workout_plans_sessions";
	$t_workout_plans_sessions_main 				= $mysqlPrefixSav . "workout_plans_sessions_main";
	$t_workout_plans_favorites 				= $mysqlPrefixSav . "workout_plans_favorites";

	/*- Workout diary ------------------------------------------------------------- */
	$t_workout_diary_entries 	= $mysqlPrefixSav . "workout_diary_entries";
	$t_workout_diary_plans 		= $mysqlPrefixSav . "workout_diary_plans";

	/*- Table meal plans -------------------------------------------------------------- */
	$t_meal_plans 		= $mysqlPrefixSav . "meal_plans";
	$t_meal_plans_days	= $mysqlPrefixSav . "meal_plans_days";
	$t_meal_plans_meals	= $mysqlPrefixSav . "meal_plans_meals";
	$t_meal_plans_entries	= $mysqlPrefixSav . "meal_plans_entries";

	/*- Tables blog ---------------------------------------------------------------------------- */
	$t_blog_info 			= $mysqlPrefixSav . "blog_info";
	$t_blog_categories		= $mysqlPrefixSav . "blog_categories";
	$t_blog_posts 			= $mysqlPrefixSav . "blog_posts";
	$t_blog_posts_tags 		= $mysqlPrefixSav . "blog_posts_tags";
	$t_blog_images	 		= $mysqlPrefixSav . "blog_images";
	$t_blog_logos	 		= $mysqlPrefixSav . "blog_logos";
	$t_blog_links_index		= $mysqlPrefixSav . "blog_links_index";
	$t_blog_links_categories	= $mysqlPrefixSav . "blog_links_categories";
	$t_blog_ping_list_per_blog	= $mysqlPrefixSav . "blog_ping_list_per_blog";

	/*- Tables discussion ---------------------------------------------------------------------------- */
	$t_discuss_titles		= $mysqlPrefixSav . "discuss_titles";
	$t_discuss_subscriptions 	= $mysqlPrefixSav . "discuss_subscriptions";

	$t_discuss_topics 		= $mysqlPrefixSav . "discuss_topics";
	$t_discuss_topics_subscribers 	= $mysqlPrefixSav . "discuss_topics_subscribers";
	$t_discuss_topics_read_by_user	= $mysqlPrefixSav . "discuss_topics_read_by_user";
	$t_discuss_topics_read_by_ip	= $mysqlPrefixSav . "discuss_topics_read_by_ip";
	$t_discuss_topics_tags 		= $mysqlPrefixSav . "discuss_topics_tags";
	$t_discuss_replies  		= $mysqlPrefixSav . "discuss_replies";
	$t_discuss_replies_comments	= $mysqlPrefixSav . "discuss_replies_comments";

	$t_discuss_forms		= $mysqlPrefixSav . "discuss_forms";
	$t_discuss_forms_questions	= $mysqlPrefixSav . "discuss_forms_questions";


	$t_discuss_top_users_monthly	= $mysqlPrefixSav . "discuss_top_users_monthly";
	$t_discuss_top_users_yearly	= $mysqlPrefixSav . "discuss_top_users_yearly";
	$t_discuss_top_users_all_time	= $mysqlPrefixSav . "discuss_top_users_all_time";

	$t_discuss_tags_index			= $mysqlPrefixSav . "discuss_tags_index";
	$t_discuss_tags_index_translation	= $mysqlPrefixSav . "discuss_tags_index_translation";
	$t_discuss_tags_watch			= $mysqlPrefixSav . "discuss_tags_watch";
	$t_discuss_tags_ignore			= $mysqlPrefixSav . "discuss_tags_ignore";


	/*- Tables downloads ---------------------------------------------------------------------------- */
	$t_downloads_index 				= $mysqlPrefixSav . "downloads_index";
	$t_downloads_main_categories 			= $mysqlPrefixSav . "downloads_main_categories";
	$t_downloads_main_categories_translations 	= $mysqlPrefixSav . "downloads_main_categories_translations";
	$t_downloads_sub_categories 			= $mysqlPrefixSav . "downloads_sub_categories";
	$t_downloads_sub_categories_translations 	= $mysqlPrefixSav . "downloads_sub_categories_translations";


	/*- Tables contact form ---------------------------------------------------------------------------- */
	$t_contact_forms_index			= $mysqlPrefixSav . "contact_forms_index";
	$t_contact_forms_images			= $mysqlPrefixSav . "contact_forms_images";
	$t_contact_forms_questions		= $mysqlPrefixSav . "contact_forms_questions";
	$t_contact_forms_questions_alternatives	= $mysqlPrefixSav . "contact_forms_questions_alternatives";
	$t_contact_forms_auto_replies		= $mysqlPrefixSav . "contact_forms_auto_replies";
	$t_contact_forms_messages		= $mysqlPrefixSav . "contact_forms_messages";
	$t_contact_forms_messages_index		= $mysqlPrefixSav . "contact_forms_messages_index";
	$t_contact_forms_messages_answers	= $mysqlPrefixSav . "contact_forms_messages_answers";


	/*- Tables courses ---------------------------------------------------------------------------- */
	$t_courses_title_translations	 = $mysqlPrefixSav . "courses_title_translations";
	$t_courses_index		 = $mysqlPrefixSav . "courses_index";
	$t_courses_users_enrolled 	 = $mysqlPrefixSav . "courses_users_enrolled";

	$t_courses_categories		 = $mysqlPrefixSav . "courses_categories";
	$t_courses_modules		 = $mysqlPrefixSav . "courses_modules";
	$t_courses_modules_read		 = $mysqlPrefixSav . "courses_modules_read";

	$t_courses_modules_contents 	 = $mysqlPrefixSav . "courses_modules_contents";
	$t_courses_modules_contents_read = $mysqlPrefixSav . "courses_modules_contents_read";
	$t_courses_modules_contents_comments	= $mysqlPrefixSav . "courses_modules_contents_comments";

	$t_courses_modules_quizzes_index  	= $mysqlPrefixSav . "courses_modules_quizzes_index";
	$t_courses_modules_quizzes_qa 		= $mysqlPrefixSav . "courses_modules_quizzes_qa";
	$t_courses_modules_quizzes_user_records	= $mysqlPrefixSav . "courses_modules_quizzes_user_records";

	$t_courses_exams_index  		= $mysqlPrefixSav . "courses_exams_index";
	$t_courses_exams_qa			= $mysqlPrefixSav . "courses_exams_qa";
	$t_courses_exams_user_tries		= $mysqlPrefixSav . "courses_exams_user_tries";
	$t_courses_exams_user_tries_qa		= $mysqlPrefixSav . "courses_exams_user_tries_qa";

	/*- Howto ---------------------------------------------------------------------------- */
	$t_knowledge_spaces_index			= $mysqlPrefixSav . "knowledge_spaces_index";
	$t_knowledge_spaces_categories			= $mysqlPrefixSav . "knowledge_spaces_categories";
	$t_knowledge_spaces_members			= $mysqlPrefixSav . "knowledge_spaces_members";
	$t_knowledge_spaces_requested_memberships	= $mysqlPrefixSav . "knowledge_spaces_requested_memberships";
	$t_knowledge_spaces_favorites 			= $mysqlPrefixSav . "knowledge_spaces_favorites";

	$t_knowledge_pages_index			= $mysqlPrefixSav . "knowledge_pages_index";
	$t_knowledge_pages_edit_history			= $mysqlPrefixSav . "knowledge_pages_edit_history";
	$t_knowledge_pages_tags	    			= $mysqlPrefixSav . "knowledge_pages_tags";
	$t_knowledge_pages_comments			= $mysqlPrefixSav . "knowledge_pages_comments";
	$t_knowledge_preselected_subscribe		= $mysqlPrefixSav . "knowledge_preselected_subscribe";
	$t_knowledge_pages_favorites    		= $mysqlPrefixSav . "knowledge_pages_favorites";
	$t_knowledge_pages_view_history 		= $mysqlPrefixSav . "knowledge_pages_view_history";
	$t_knowledge_pages_media			= $mysqlPrefixSav . "knowledge_pages_media";
	$t_knowledge_pages_diagrams			= $mysqlPrefixSav . "knowledge_pages_diagrams";

	/*- Evidence database ------------------------------------------------------------------ */
	$t_edb_case_index				= $mysqlPrefixSav . "edb_case_index";
	$t_edb_case_index_events			= $mysqlPrefixSav . "edb_case_index_events";
	$t_edb_case_index_evidence_records		= $mysqlPrefixSav . "edb_case_index_evidence_records";
	$t_edb_case_index_evidence_items		= $mysqlPrefixSav . "edb_case_index_evidence_items";
	$t_edb_case_index_evidence_items_sim_cards	= $mysqlPrefixSav . "edb_case_index_evidence_items_sim_cards";
	$t_edb_case_index_evidence_items_sd_cards	= $mysqlPrefixSav . "edb_case_index_evidence_items_sd_cards";
	$t_edb_case_index_evidence_items_networks	= $mysqlPrefixSav . "edb_case_index_evidence_items_networks";
	$t_edb_case_index_evidence_items_hard_disks	= $mysqlPrefixSav . "edb_case_index_evidence_items_hard_disks";
	$t_edb_case_index_evidence_items_mirror_files	= $mysqlPrefixSav . "edb_case_index_evidence_items_mirror_files";
	$t_edb_case_index_statuses			= $mysqlPrefixSav . "edb_case_index_statuses";
	$t_edb_case_index_human_tasks			= $mysqlPrefixSav . "edb_case_index_human_tasks";
	$t_edb_case_index_human_tasks_responsible_counters = $mysqlPrefixSav . "edb_case_index_human_tasks_responsible_counters";
	$t_edb_case_index_automated_tasks		= $mysqlPrefixSav . "edb_case_index_automated_tasks";
	$t_edb_case_index_notes				= $mysqlPrefixSav . "edb_case_index_notes";
	$t_edb_case_index_reviews			= $mysqlPrefixSav . "edb_case_index_reviews";
	$t_edb_case_index_open_case_menu_counters	= $mysqlPrefixSav . "edb_case_index_open_case_menu_counters";
	$t_edb_case_index_glossaries			= $mysqlPrefixSav . "edb_case_index_glossaries";
	$t_edb_case_index_photos			= $mysqlPrefixSav . "edb_case_index_photos";
	$t_edb_case_codes				= $mysqlPrefixSav . "edb_case_codes";
	$t_edb_case_statuses				= $mysqlPrefixSav . "edb_case_statuses";
	$t_edb_case_statuses_district_case_counter	= $mysqlPrefixSav . "edb_case_statuses_district_case_counter";
	$t_edb_case_statuses_station_case_counter	= $mysqlPrefixSav . "edb_case_statuses_station_case_counter";
	$t_edb_case_statuses_user_case_counter		= $mysqlPrefixSav . "edb_case_statuses_user_case_counter";
	$t_edb_case_priorities				= $mysqlPrefixSav . "edb_case_priorities";
	$t_edb_case_reports				= $mysqlPrefixSav . "edb_case_reports";

	$t_edb_districts_index			= $mysqlPrefixSav . "edb_districts_index";
	$t_edb_districts_members		= $mysqlPrefixSav . "edb_districts_members";
	$t_edb_districts_membership_requests	= $mysqlPrefixSav . "edb_districts_membership_requests";
	$t_edb_districts_jour			= $mysqlPrefixSav . "edb_districts_jour";

	$t_edb_stations_index			= $mysqlPrefixSav . "edb_stations_index";
	$t_edb_stations_members			= $mysqlPrefixSav . "edb_stations_members";
	$t_edb_stations_membership_requests	= $mysqlPrefixSav . "edb_stations_membership_requests";
	$t_edb_stations_directories		= $mysqlPrefixSav . "edb_stations_directories";
	$t_edb_stations_jour			= $mysqlPrefixSav . "edb_stations_jour";
	$t_edb_stations_user_view_method	= $mysqlPrefixSav . "edb_stations_user_view_method";

	$t_edb_item_types		= $mysqlPrefixSav . "edb_item_types";
	$t_edb_glossaries		= $mysqlPrefixSav . "edb_glossaries";

	$t_edb_software_index	= $mysqlPrefixSav . "edb_software_index";

	$t_edb_machines_index				= $mysqlPrefixSav . "edb_machines_index";
	$t_edb_machines_types				= $mysqlPrefixSav . "edb_machines_types";
	$t_edb_machines_all_tasks_available		= $mysqlPrefixSav . "edb_machines_all_tasks_available";
	$t_edb_machines_all_tasks_available_to_item  	= $mysqlPrefixSav . "edb_machines_all_tasks_available_to_item";

	$t_edb_agent_log 			= $mysqlPrefixSav . "edb_agent_log";
	$t_edb_agent_user_active_inactive 	= $mysqlPrefixSav . "edb_agent_user_active_inactive";

	$t_edb_stats_index 			= $mysqlPrefixSav . "edb_stats_index";
	$t_edb_stats_case_codes			= $mysqlPrefixSav . "edb_stats_case_codes";
	$t_edb_stats_case_priorites		= $mysqlPrefixSav . "edb_stats_case_priorites";
	$t_edb_stats_item_types 		= $mysqlPrefixSav . "edb_stats_item_types";
	$t_edb_stats_statuses_per_day		= $mysqlPrefixSav . "edb_stats_statuses_per_day";
	$t_edb_stats_employee_of_the_month	= $mysqlPrefixSav . "edb_stats_employee_of_the_month";

	$t_edb_most_used_passwords_login_users 		= $mysqlPrefixSav . "edb_most_used_passwords_login_users";
	$t_edb_most_used_passwords_login_passwords 	= $mysqlPrefixSav . "edb_most_used_passwords_login_passwords";
	$t_edb_most_used_passwords_startup_passwords  	= $mysqlPrefixSav . "edb_most_used_passwords_startup_passwords";
	$t_edb_most_used_passwords_pins 		= $mysqlPrefixSav . "edb_most_used_passwords_pins";
	$t_edb_most_used_passwords_unlock_patterns  	= $mysqlPrefixSav . "edb_most_used_passwords_unlock_patterns";

	/*- Office calendar ---------------------------------------------------------------------------- */
	$t_office_calendar_locations	= $mysqlPrefixSav . "office_calendar_locations";
	$t_office_calendar_equipments	= $mysqlPrefixSav . "office_calendar_equipments";
	$t_office_calendar_events	= $mysqlPrefixSav . "office_calendar_events";


}
/*- Language ------------------------------------------------------------------------- */
if(isset($_GET['l'])) {
	$l = $_GET['l'];
	$l = strip_tags(stripslashes($l));
	$l_mysql = quote_smart($link, $l);

	// Is that language in list of languages?
	$query = "SELECT language_active_iso_two FROM $t_languages_active WHERE language_active_iso_two=$l_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_language_active_iso_two) = $row;
	if($get_language_active_iso_two  != ""){
		
		$_SESSION['l'] = "$l";
	
	}
	else{
		// Find the pre defined language
		$query = "SELECT language_active_iso_two FROM $t_languages_active WHERE language_active_default='1'";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_language_active_iso_two) = $row;
		if($get_language_active_iso_two == ""){
			$l = "en";
			echo"<div class=\"error\"><a href=\"$root/_admin\">Please select a default language</a></div>"; die;
		}

		$_SESSION['l'] = "$get_language_active_iso_two";
		$l = "$get_language_active_iso_two";
	}
}
else{
	// Look for language in session
	if(isset($_SESSION['l'])){
		$l = $_SESSION['l'];

		// Check if we have that language
		$l_mysql = quote_smart($link, $l);
		$query = "SELECT language_active_iso_two FROM $t_languages_active WHERE language_active_iso_two=$l_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_language_active_iso_two) = $row;
		if($get_language_active_iso_two == ""){
			// That language doesnt exists
			// Find the pre defined language
			$query = "SELECT language_active_iso_two FROM $t_languages_active WHERE language_active_default='1'";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_language_active_iso_two) = $row;
			if($get_language_active_iso_two != ""){
				$_SESSION['l'] = "$get_language_active_iso_two";
				$l = $_SESSION['l'];
			}
		}	
	}
	else{

		if(isset($_COOKIE['l'])) {
	        	$cookie_l = $_COOKIE['l'];
			$l = $cookie_l;
		}
		else{
			// Check my browsers settings for language
			if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])){
				$language = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
				$language = output_html($language);
				$language = strtolower($language);
				$language = substr("$language", 0,2);
				$language_mysql = quote_smart($link, $language);

				// Check if we have that language
				$query = "SELECT language_active_iso_two FROM $t_languages_active WHERE language_active_iso_two=$language_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_language_active_iso_two) = $row;

				if($get_language_active_iso_two != ""){
					$l = $get_language_active_iso_two;
					$_SESSION['l'] = "$l";
				}
			}

			if(!(isset($l))) {
				// Find the pre defined language
				$query = "SELECT language_active_iso_two FROM $t_languages_active WHERE language_active_default='1'";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_language_active_iso_two) = $row;
				if($get_language_active_iso_two == ""){
					$l = "en";
				}

				$_SESSION['l'] = "$get_language_active_iso_two";
				$l = $_SESSION['l'];
			}
		}
		
	}
}



/*- Translation and CSS -------------------------------------------------------------------------- */
// 1. Common
if(!(file_exists("$root/_admin/_translations/site/$l/common/ts_common.php"))){
	echo"<p>Language not found (missing <a href=\"$root/_admin/_translations/site/$l/common/ts_common.php\">sites common</a> ts_common for $l). Language set to english.</p>";
	echo"<p><a href=\"index.php?l=en\">index.php?l=en</a></p>";
	if($l == ""){
		$l = "en";
		$l = $_SESSION['l'];
	}
	die;
}
include("$root/_admin/_translations/site/$l/common/ts_common.php");

// 2. Site defined by title
if(file_exists("$root/_admin/_translations/site/$l/$configWebsiteTitleCleanSav/ts_$configWebsiteTitleCleanSav.php")){
	include("$root/_admin/_translations/site/$l/$configWebsiteTitleCleanSav/ts_$configWebsiteTitleCleanSav.php");
	$pageCSSFile = "_css/$configWebsiteTitleCleanSav.css";
}

// 3. Special
$self 		= $_SERVER['PHP_SELF'];
$request_url 	= $_SERVER["REQUEST_URI"];
$self_array     = explode("/", $self);
$array_size     = sizeof($self_array);
$minus_one	= $array_size-1;
$minus_two	= $array_size-2;
$minus_three	= $array_size-3;
$url_minus_one	= $self_array[$minus_one];
$url_minus_two	= $self_array[$minus_two];
if(isset($self_array[$minus_three])){ $url_minus_three= $self_array[$minus_three]; }

$language_file = "$root/_admin/_translations/site/$l";
$language_case = "";

if($url_minus_one == "index.php"){
	// Either	index.php
	// or    	A: stores/index.php
	// or		C: stores/troms/index.php
	
	if($root == "."){
		// index.php
		$language_case = "A";
		$language_file = $language_file . "/welcome/ts_welcome.php";
		$pageCSSFile = "_css/$configWebsiteTitleCleanSav.css";
	}
	elseif($root == "."){
		// stores/index.php
		$language_case = "A";
		$language_file = $language_file . "/ts_$url_minus_one.php";
		$pageCSSFile = "_css/$url_minus_one.css";
	}
	else{
		$language_case = "C";
		$language_file = $language_file . "/$url_minus_two/ts_$url_minus_two.php";
		$pageCSSFile = "_css/$url_minus_one.css";
	}
	
	// CONTINUE HERE
	
	
}
else{
	// Either B: stores/north.php
	// or     D: stores/troms/tromso.php
	if($root == ".."){
		// index.php
		$language_case = "B";
		$language_file = $language_file . "/$url_minus_two/ts_$url_minus_one";
		$pageCSSFile = "_css/$url_minus_one.css";
	}
	elseif($root == "../.."){
		// index.php
		$language_case = "D";
		$language_file = $language_file . "/$url_minus_two/ts_$url_minus_one";
		$pageCSSFile = "_css/$url_minus_one.css";
	}
	else{
		$pageCSSFile = "";
	}


}
	
// Include language
if(file_exists("$language_file") && !(is_dir($language_file))){
	include("$language_file");
	// echo"L: ($root) ($language_case) $language_file<br />";
}
else{
	// echo"Not found: ($root) ($language_case) $language_file<br />";
}

// Remove PHP from css
$pageCSSFile = str_replace(".php", "", $pageCSSFile);


/*- Website title ---------------------------------------------------------------------------- */
if(isset($website_title)){
	// Well keep that title
}
else{
	$website_title = "";

	// Page
	$page = $array_size-2;
	$page = $self_array[$page];
	$page = clean_dir_reverse($page);
	$page = str_replace(".php", "", $page);

	if($page == "" OR $page == "$configWebsiteTitleSav"){
		if(file_exists("$root/_admin/_data/slogan/$l.php")){
			include("$root/_admin/_data/slogan/$l.php");
			$website_title = "$SloganSav";
		}
	}
	else {
		$website_title = "$page";
	}
}






/*- Stats ---------------------------------------------------------------------------- */
include("$root/_admin/_functions/page_url.php");
include("$root/_admin/_functions/registrer_stats.php");

/*- Cookie? -------------------------------------------------------------------------- */
if(isset($_SESSION['user_id'])) {
	// Last seend
	$my_user_id = $_SESSION['user_id'];
	$my_user_id = output_html($my_user_id);
	$my_user_id_mysql = quote_smart($link, $my_user_id);

	$user_last_ip = $_SERVER['REMOTE_ADDR'];
	$user_last_ip = output_html($user_last_ip);
	$user_last_ip_mysql = quote_smart($link, $user_last_ip);

	$datetime = date("Y-m-d H:i:s");
	$time = time();

	$result = mysqli_query($link, "UPDATE $t_users SET user_last_online='$datetime', user_last_online_time='$time', user_last_ip=$user_last_ip_mysql WHERE user_id=$my_user_id_mysql");
				
}
else{

	if(isset($_COOKIE['remember_user'])) {
	        $cookie_encoded = $_COOKIE['remember_user'];
		// $salt = substr (md5($get_user_password), 0, 2);
		// $cookie = base64_encode ("$get_user_id:" . md5 ($get_user_password, $salt));		

		$cookie_decoded = base64_decode($cookie_encoded);

		$cookie_array = explode(":", $cookie_decoded);
		$cookie_user_id = output_html($cookie_array[0]);
		$cookie_user_id_mysql = quote_smart($link, $cookie_user_id);
		if(isset($cookie_array[1])){
			$cookie_password = $cookie_array[1];

			// Get that user
			$query = "SELECT user_id, user_password, user_salt, user_language, user_verified_by_moderator FROM $t_users WHERE user_id=$cookie_user_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_user_id, $get_user_password, $get_user_salt, $get_user_language, $get_user_verified_by_moderator) = $row;

			if($get_user_id == ""){
				// echo"<p style=\"color: red;\">Cookie error. User not found.</p>";
			}
			else{
				$salt = substr (md5($get_user_password), 0, 2);
				$user_cookie_password = md5 ($get_user_password, $salt);


				if($cookie_password == "$user_cookie_password"){
					
					// -> Logg brukeren inn
					$security = rand(0,9999);
					$_SESSION['user_id'] = "$get_user_id";
					$_SESSION['security'] = "$security";
					$user_last_ip = $_SERVER['REMOTE_ADDR'];
					$user_last_ip = output_html($user_last_ip);
					$user_last_ip_mysql = quote_smart($link, $user_last_ip);

					// Update last logged in + security pin code
					$inp_user_last_online = date("Y-m-d H:i:s");
					$time = time();
					$result = mysqli_query($link, "UPDATE $t_users SET user_security='$security', user_last_online='$inp_user_last_online', user_last_online_time='$time', user_last_ip=$user_last_ip_mysql WHERE user_id='$get_user_id'");
				
				}
				else{
					// echo"<p style=\"color: red;\">Cookie error: Uncorrect password.</p>";
				}
			}
		}
	}
}
?>