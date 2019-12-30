<?php
/**
*
* File: courses/_includes/course.php
* Version 2.0.0
* Date 22:38 03.05.2019
* Copyright (c) 2011-2019 Localhost
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

// Find course
$course_dir_name_mysql = quote_smart($link, $courseDirNameSav);
$query = "SELECT course_id, course_title, course_is_active, course_short_introduction, course_long_introduction, course_contents, course_language, course_dir_name, course_category_id, course_category_dir_name, course_intro_video_embedded, course_icon_48, course_icon_64, course_icon_96, course_modules_count, course_lessons_count, course_quizzes_count, course_users_enrolled_count, course_read_times, course_created, course_updated FROM $t_courses_index WHERE course_dir_name=$course_dir_name_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_current_course_id, $get_current_course_title, $get_current_course_is_active, $get_current_course_short_introduction, $get_current_course_long_introduction, $get_current_course_contents, $get_current_course_language, $get_current_course_dir_name, $get_current_course_category_id, $get_current_course_category_dir_name, $get_current_course_intro_video_embedded, $get_current_course_icon_48, $get_current_course_icon_64, $get_current_course_icon_96, $get_current_course_modules_count, $get_current_course_lessons_count, $get_current_course_quizzes_count, $get_current_course_users_enrolled_count, $get_current_course_read_times, $get_current_course_created, $get_current_course_updated) = $row;

if($get_current_course_id == ""){

	/*- Functions ------------------------------------------------------------------------ */
	function get_string_between($string, $start, $end){
	    $string = ' ' . $string;
	    $ini = strpos($string, $start);
	    if ($ini == 0) return '';
	    $ini += strlen($start);
	    $len = strpos($string, $end, $ini) - $ini;
	    return substr($string, $ini, $len);
	}


	if(file_exists("_course.txt")){
		$fh = fopen("_course.txt", "r");
		$data = fread($fh, filesize("_course.txt"));
		fclose($fh);


		$inp_title = trim(get_string_between($data, "course_title:", "course_short_introduction:"));
		$inp_title = str_replace("\n", "", $inp_title);
		$inp_title = str_replace("\r", "", $inp_title);
		$inp_title_mysql = quote_smart($link, $inp_title);

		$inp_short_introduction = trim(get_string_between($data, "course_short_introduction:", "course_long_introduction:"));
		$inp_short_introduction_mysql = quote_smart($link, $inp_short_introduction);

		$inp_long_introduction = trim(get_string_between($data, "course_long_introduction:", "course_contents:"));
		$inp_long_introduction_mysql = quote_smart($link, $inp_long_introduction);

		$inp_contents = trim(get_string_between($data, "course_contents:", "course_language:"));
		$inp_contents_mysql = quote_smart($link, $inp_contents);

		$inp_language = trim(get_string_between($data, "course_language:", "course_dir_name:"));
		$inp_language = str_replace("\n", "", $inp_language);
		$inp_language = str_replace("\r", "", $inp_language);
		$inp_language_mysql = quote_smart($link, $inp_language);

		$inp_course_dir_name = trim(get_string_between($data, "course_dir_name:", "course_category_dir_name:"));
		$inp_course_dir_name = str_replace("\n", "", $inp_course_dir_name);
		$inp_course_dir_name = str_replace("\r", "", $inp_course_dir_name);
		$inp_course_dir_name_mysql = quote_smart($link, $inp_course_dir_name);

		$inp_category_dir_name = trim(get_string_between($data, "course_category_dir_name:", "course_intro_video_embedded:"));
		$inp_category_dir_name = str_replace("\n", "", $inp_category_dir_name);
		$inp_category_dir_name = str_replace("\r", "", $inp_category_dir_name);
		$inp_category_dir_name_mysql = quote_smart($link, $inp_category_dir_name);

		$inp_intro_video_embedded = trim(substr($data, strpos($data, "course_intro_video_embedded:") + strlen("course_intro_video_embedded:")));    
		$inp_intro_video_embedded = str_replace("\n", "", $inp_intro_video_embedded);
		$inp_intro_video_embedded = str_replace("\r", "", $inp_intro_video_embedded);
		$inp_intro_video_embedded_mysql = quote_smart($link, $inp_intro_video_embedded);

		$inp_icon_a = $inp_course_dir_name . "_48x48.png";
		$inp_icon_a_mysql = quote_smart($link, $inp_icon_a);

		$inp_icon_b = $inp_course_dir_name . "_64x64.png";
		$inp_icon_b_mysql = quote_smart($link, $inp_icon_b);

		$inp_icon_c = $inp_course_dir_name . "_96x96.png";
		$inp_icon_c_mysql = quote_smart($link, $inp_icon_c);

		$datetime = date("Y-m-d H:i:s");


		$query = "SELECT category_id FROM $t_courses_categories WHERE category_dir_name=$inp_category_dir_name_mysql AND category_language=$inp_language_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_category_id) = $row;
		if($get_current_category_id == ""){
			// Create category
			$inp_category_title = ucfirst($inp_category_dir_name);
			$inp_category_title_mysql = quote_smart($link, $inp_category_title);

			mysqli_query($link, "INSERT INTO $t_courses_categories 
			(category_id, category_title, category_dir_name, category_description, category_language, category_created, category_updated) 
			VALUES 
			(NULL, $inp_category_title_mysql, $inp_category_dir_name_mysql, '', $inp_language_mysql, '$datetime', '$datetime')")
			or die(mysqli_error($link));


			$query = "SELECT category_id FROM $t_courses_categories WHERE category_dir_name=$inp_category_dir_name_mysql AND category_language=$inp_language_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_category_id) = $row;

		}



		mysqli_query($link, "INSERT INTO $t_courses_index
		(course_id, course_title, course_is_active, course_short_introduction, course_long_introduction, course_contents, course_language, course_dir_name, course_category_id, course_category_dir_name, course_intro_video_embedded, course_icon_48, course_icon_64, course_icon_96, course_modules_count, course_lessons_count, course_quizzes_count, course_users_enrolled_count, course_read_times, course_created, course_updated) 
		VALUES 
		(NULL, $inp_title_mysql, 1, $inp_short_introduction_mysql, $inp_long_introduction_mysql, $inp_contents_mysql, $inp_language_mysql, $inp_course_dir_name_mysql, $get_current_category_id, $inp_category_dir_name_mysql, $inp_intro_video_embedded_mysql, $inp_icon_a_mysql, $inp_icon_b_mysql, $inp_icon_c_mysql, 0, 0, 0, 0, 0, '$datetime', '$datetime')")
		or die(mysqli_error($link));


		echo"
		<h1>Course created</h1>
		<p>Hit F5</p>

		";
	}
	else{

		echo"<h1>Course not found</h1>
		<p>Server error 404.</p>";
	}
}
else{
	// Find me
	if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
		// Get user
		$my_user_id = $_SESSION['user_id'];
		$my_user_id_mysql = quote_smart($link, $my_user_id);
		$my_security = $_SESSION['security'];
		$my_security_mysql = quote_smart($link, $my_security);
	}



	if($action == ""){
		echo"
		<h1>$get_current_course_title</h1>


		<!-- About course -->
			<div style=\"height:20px;\"></div>
			<div class=\"course_overview\">
				<a href=\"index.php?course=$get_current_course_dir_name&amp;l=$l\"><img src=\"_images/$get_current_course_icon_96\" alt=\"$get_current_course_icon_96\" class=\"course_icon\" /></a>
		
				<div class=\"course_text\">
					<h1 style=\"margin: 0px 0px 0px 0px;padding: 0px 0px 0px 0px;\">$get_current_course_title</h1> 
			
					$get_current_course_long_introduction
				</div>
				<div class=\"clear\"></div>
			</div>
			<div style=\"height:20px;\"></div>
		<!-- //About course -->

		";
		if(!(isset($_SESSION['user_id']))){
			$refer = $_SERVER['PHP_SELF'];
			$refer = str_replace('/en/', "", $refer);
			echo"
			<form method=\"POST\" action=\"../users/login.php?action=check&amp;process=1&amp;l=en&amp;referer=../$refer\" enctype=\"multipart/form-data\" name=\"nameform\">
	
			<div class=\"course_quick_login\">
				<div class=\"quick_login_headerspace\">
					<p>
					<a href=\"$root/users/login.php?l=$l\">$l_login_to_our_site</a>
					</p>
				</div>
			
				<div class=\"course_quick_login_username\">
					<p>
					$l_email:
					<input type=\"text\" name=\"inp_email\" size=\"10\" value=\""; if(isset($inp_email)){ echo"$inp_email"; } echo"\" />
					</p>
				</div>
				<div class=\"course_quick_login_password\">
					<p>
					$l_password: <input type=\"password\" name=\"inp_password\" size=\"10\" value=\""; if(isset($inp_password)){ echo"$inp_password"; } echo"\" />
					</p>
				</div>
				<div class=\"course_quick_login_autologin\">
					<p>
					$l_remember_me  <input style=\"margin-top: -3px;\" type=\"checkbox\" name=\"inp_remember\" "; if(isset($inp_remember)){ if($inp_remember == "on"){ echo" checked=\"checked\""; } } else{ echo" checked=\"checked\""; } echo" />
					</p>
				</div>
				<div class=\"course_quick_login_submit\">
					<input type=\"submit\" value=\"$l_login\" class=\"btn_default\" />
				</div>
				<div class=\"course_quick_login_forgot_password\">
					<p>
					<a href=\"$root/users/create_free_account.php?l=$l\">$l_create_a_free_account</a>
					|
					<a href=\"$root/users/forgot_password.php?l=$l\">$l_i_forgot_my_password</a>
					</p>
				</div>

			</div>
			</form>



			";
		}



		// Get modules
		$course_dir_name_mysql = quote_smart($link, $get_current_course_dir_name);
		$query = "SELECT module_id, module_course_id, module_number, module_title, module_title_clean, module_url, module_read_times, module_created, module_updated FROM $t_courses_modules WHERE module_course_dir_name=$course_dir_name_mysql ORDER BY module_number ASC";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_module_id, $get_module_course_id, $get_module_number, $get_module_title, $get_module_title_clean, $get_module_url, $get_module_read_times, $get_module_created, $get_module_updated) = $row;


			// Did I complete this module?
			$module_title_clean_mysql = quote_smart($link, $get_module_title_clean);
			if(isset($my_user_id)){
				$query_m = "SELECT module_read_id FROM $t_courses_modules_read WHERE read_course_dir_name=$course_dir_name_mysql AND read_module_title_clean=$module_title_clean_mysql AND read_user_id=$my_user_id_mysql";
				$result_m = mysqli_query($link, $query_m);
				$row_m = mysqli_fetch_row($result_m);
				list($get_module_read_id) = $row_m;
			
			}
			else{
				$get_module_read_id = "";
			}

			echo"
			<div class=\"course_module\">
				<a href=\"$root/$get_current_course_dir_name/$get_module_url/index.php?course=$get_current_course_dir_name&amp;module=$get_module_title_clean&amp;l=$l\">
				<div class=\"module_left\">
					<p><span>Module $get_module_number:</span> $get_module_title</p>
				</div>
				
				<div class=\"module_right\">
                        		";
					if($get_module_read_id == ""){
						echo"<p><img src=\"$root/courses/_images/icons/checked_grey.png\" alt=\"checked_grey.png\" /></p>";
					}
					else{
						echo"<p><img src=\"$root/courses/_images/icons/checked_color.png\" alt=\"checked_color.png\" /></p>";
					}
					echo"
				</div>
				</a>
			</div>
			";

			// Get content
			$module_title_clean_mysql = quote_smart($link, $get_module_title_clean);
			$query_c = "SELECT content_id, content_course_id, content_course_dir_name, content_module_id, content_module_title_clean, content_type, content_number, content_title, content_title_clean, content_description, content_url, content_url_type, content_read_times, content_read_times_ipblock, content_created_datetime, content_created_date_formatted, content_last_read_datetime, content_last_read_date_formatted FROM $t_courses_modules_contents WHERE content_course_dir_name=$course_dir_name_mysql AND content_module_title_clean=$module_title_clean_mysql ORDER BY content_number ASC";
			$result_c = mysqli_query($link, $query_c);
			while($row_c = mysqli_fetch_row($result_c)) {
				list($get_content_id, $get_content_course_id, $get_content_course_dir_name, $get_content_module_id, $get_content_module_title_clean, $get_content_type, $get_content_number, $get_content_title, $get_content_title_clean, $get_content_description, $get_content_url, $get_content_url_type, $get_content_read_times, $get_content_read_times_ipblock, $get_content_created_datetime, $get_content_created_date_formatted, $get_content_last_read_datetime, $get_content_last_read_date_formatted) = $row_c;
		


				// Did I complete this content?
				$content_title_clean_mysql = quote_smart($link, $get_content_title_clean);
				if(isset($my_user_id)){
					$query_m = "SELECT content_read_id FROM $t_courses_modules_contents_read WHERE read_course_dir_name=$course_dir_name_mysql AND read_module_title_clean=$module_title_clean_mysql AND read_content_title_clean=$content_title_clean_mysql AND read_user_id=$my_user_id_mysql";
					$result_m = mysqli_query($link, $query_m);
					$row_m = mysqli_fetch_row($result_m);
					list($get_content_read_id) = $row_m;
				}
				else{
					$get_content_read_id = "";
				}


				echo"
				<div class=\"course_content\">
                        		<a href=\"$root/$get_current_course_dir_name/$get_module_url/$get_content_url";
					if($get_content_url_type == "dir"){ echo"/index.php"; } 
					echo"?course=$get_current_course_dir_name&amp;module=$get_module_title_clean&amp;content=$get_content_title_clean&amp;l=$l\">
					<div class=\"course_content_left\">
                               			 <span class=\"course_content_number\">$get_content_number</span> <span class=\"course_content_title\">$get_content_title</span>
					</div>
					<div class=\"course_content_right\">
                        			";
						if($get_content_read_id == ""){
							echo"<p><img src=\"$root/courses/_images/icons/checked_grey.png\" alt=\"checked_grey.png\" /></p>";
						}
						else{
							echo"<p><img src=\"$root/courses/_images/icons/checked_color.png\" alt=\"checked_color.png\" /></p>";
						}
						echo"
					</div>
					</a>
				</div>
				";
			} // while content


		} // while modules

		// Other pages
		echo"
		<p>
		<a href=\"index.php?action=create_navigation&amp;course=$get_current_course_dir_name&amp;l=$l\" class=\"grey_small\">$l_create_navigation</a>
		&middot;
		<a href=\"index.php?action=look_for_changes_in_modules_and_content&amp;course=$get_current_course_dir_name&amp;l=$l\" class=\"grey_small\">$l_look_for_changes_in_modules_and_content</a>
		</p>
		";
	} // action == ""
	elseif($action == "create_navigation"){
		echo"
		<h1>$get_current_course_title</h1>
		";


		$input_header="<?php
/**
*
* File: $get_current_course_dir_name/navigation.php
* Version 2.0.0
* Date 22:38 03.05.2019
* Copyright (c) 2011-2019 Localhost
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Current page ---------------------------------------- */
\$self 		= \$_SERVER['PHP_SELF'];
\$request_url 	= \$_SERVER[\"REQUEST_URI\"];
\$self_array     = explode(\"/\", \$self);
\$array_size     = sizeof(\$self_array);

\$minus_one	= \$array_size-1;
\$minus_one	= \$self_array[\$minus_one];

\$minus_two	= \$array_size-2;
\$minus_two	= \$self_array[\$minus_two];

\$complex	= \$minus_two . \"/\" . \$minus_one;

echo\"
<ul class=\\\"toc\\\">
	<li class=\\\"header_home\\\"><a href=\\\"\$root/$get_current_course_dir_name/index.php?course=$get_current_course_dir_name&amp;l=\$l\\\"\"; if(\$minus_two == \"$get_current_course_dir_name\" && \$minus_one  == \"index.php\"){ echo\" class=\\\"navigation_active\\\"\";}echo\">$get_current_course_title</a></li>

";
		
		$fh = fopen("$root/$get_current_course_dir_name/navigation.php", "w") or die("can not open file");
		fwrite($fh, $input_header);
		fclose($fh);


		// Get modules
		$course_dir_name_mysql = quote_smart($link, $get_current_course_dir_name);
		$query = "SELECT module_id, module_course_id, module_number, module_title, module_title_clean, module_url, module_read_times, module_created, module_updated FROM $t_courses_modules WHERE module_course_dir_name=$course_dir_name_mysql ORDER BY module_number ASC";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_module_id, $get_module_course_id, $get_module_number, $get_module_title, $get_module_title_clean, $get_module_url, $get_module_read_times, $get_module_created, $get_module_updated) = $row;


			echo"
			<p><span>Module $get_module_number:</span> $get_module_title</p>
			
			";
			$input_module="
	<li class=\\\"header_up\\\"><a href=\\\"\$root/$get_current_course_dir_name/$get_module_url/index.php?course=$get_current_course_dir_name&amp;module=$get_module_title_clean&amp;l=\$l\\\"\"; if(\$minus_two == \"$get_module_title_clean\" && \$minus_one  == \"index.php\"){ echo\" class=\\\"navigation_active\\\"\";}echo\">$get_module_title</a></li>
";
		
			$fh = fopen("$root/$get_current_course_dir_name/navigation.php", "a+") or die("can not open file");
			fwrite($fh, $input_module);
			fclose($fh);




			// Get content
			$module_title_clean_mysql = quote_smart($link, $get_module_title_clean);
			$query_c = "SELECT content_id, content_course_id, content_course_dir_name, content_module_id, content_module_title_clean, content_type, content_number, content_title, content_title_clean, content_description, content_url, content_url_type, content_read_times, content_read_times_ipblock, content_created_datetime, content_created_date_formatted, content_last_read_datetime, content_last_read_date_formatted FROM $t_courses_modules_contents WHERE content_course_dir_name=$course_dir_name_mysql AND content_module_title_clean=$module_title_clean_mysql ORDER BY content_number ASC";
			$result_c = mysqli_query($link, $query_c);
			while($row_c = mysqli_fetch_row($result_c)) {
				list($get_content_id, $get_content_course_id, $get_content_course_dir_name, $get_content_module_id, $get_content_module_title_clean, $get_content_type, $get_content_number, $get_content_title, $get_content_title_clean, $get_content_description, $get_content_url, $get_content_url_type, $get_content_read_times, $get_content_read_times_ipblock, $get_content_created_datetime, $get_content_created_date_formatted, $get_content_last_read_datetime, $get_content_last_read_date_formatted) = $row_c;
		
				echo"
				<span class=\"course_content_number\">$get_content_number</span> <span class=\"course_content_title\">$get_content_title</span><br />
				
				";
				if($get_content_url_type == "dir"){
					$input_content="
	<li><a href=\\\"\$root/$get_current_course_dir_name/$get_module_url/$get_content_url/index.php?course=$get_current_course_dir_name&amp;module=$get_module_title_clean&amp;content=$get_content_title_clean&amp;l=\$l\\\"\"; if(\$minus_one  == \"$get_content_title\"){ echo\" class=\\\"navigation_active\\\"\";}echo\">$get_content_title</a></li>";
				}
				else{
					$input_content="
	<li><a href=\\\"\$root/$get_current_course_dir_name/$get_module_url/$get_content_url?course=$get_current_course_dir_name&amp;module=$get_module_title_clean&amp;content=$get_content_title_clean&amp;l=\$l\\\"\"; if(\$minus_one  == \"$get_content_title\"){ echo\" class=\\\"navigation_active\\\"\";}echo\">$get_content_title</a></li>";
				}

				$fh = fopen("$root/$get_current_course_dir_name/navigation.php", "a+") or die("can not open file");
				fwrite($fh, $input_content);
				fclose($fh);


			} // while content


		} // while modules
		$input_footer="
</ul>
\";

?>";
		$fh = fopen("$root/$get_current_course_dir_name/navigation.php", "a+") or die("can not open file");
		fwrite($fh, $input_footer);
		fclose($fh);



	} // action == "navigation"
	elseif($action == "look_for_changes_in_modules_and_content"){
		echo"
		<h1>$get_current_course_title</h1>

		";
		if(file_exists("_modules_and_lessons.txt")){
			

			// Read
			$fh = fopen("_modules_and_lessons.txt", "r");
			$data = fread($fh, filesize("_modules_and_lessons.txt"));
			fclose($fh);

			$data_array = explode("\n", $data);
			$size = sizeof($data_array);


			// vars
			$datetime = date("Y-m-d H:i:s");
			$date_formatted = date("j M Y");
			$module_counter = 0;
			$content_counter = 0;
			$changes_found = 0;
			$course_dir_name_mysql = quote_smart($link, $get_current_course_dir_name);


			for($x=0;$x<$size;$x++){
				$temp = explode("|", $data_array[$x]);
				$temp_size = sizeof($temp);

				$type = explode(":", $temp[0]); // "- less" "- quiz" "- exam"
				$type_size = sizeof($type);
				if($type_size == 1 && $temp[0] != "" && isset($temp[1])){
					$inp_module_title = trim($temp[0]);
					//$inp_module_title = str_replace("﻿", "", $inp_module_title);
					$inp_module_title = output_html($inp_module_title);
					$inp_module_title = str_replace("&iuml;&raquo;&iquest;", "", $inp_module_title);
					$inp_module_title_mysql = quote_smart($link, $inp_module_title);


					$inp_module_url = trim($temp[1]);
					$inp_module_url = output_html($inp_module_url);
					$inp_module_url_mysql = quote_smart($link, $inp_module_url);

					$inp_title_clean = str_replace(".php", "", $inp_module_url);
					$inp_title_clean_mysql = quote_smart($link, $inp_title_clean);
					
					if($inp_module_title != ""){

						// Check if it exists
						$query = "SELECT module_id, module_course_id, module_course_dir_name, module_number, module_title, module_title_clean, module_url, module_read_times, module_created, module_updated FROM $t_courses_modules WHERE module_course_dir_name=$course_dir_name_mysql AND module_title=$inp_module_title_mysql";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_module_id, $get_module_course_id, $get_module_course_dir_name, $get_module_number, $get_module_title, $get_module_title_clean, $get_module_url, $get_module_read_times, $get_module_created, $get_module_updated) = $row;

						$module_counter = $module_counter+1;

						if($get_module_id == "" OR $module_counter != "$get_module_number" OR $inp_module_title != "$get_module_title" OR $inp_module_url != "$get_module_url"){
							$changes_found = "1";
							echo"<span style=\"color:red;\">Changes found. module_id=$get_module_id. $module_counter!=$get_module_number. $inp_module_title!=$get_module_title<br /></span>\n";
						}
						echo"<h2>$inp_module_title &middot; $get_module_title_clean &middot; $get_module_id</h2>";
					}
				} // end module
				else{

					if(isset($type[1]) && !(empty(trim($type[1]))) && isset($get_module_title_clean)){
						
						$inp_type = trim($type[0]);
						$inp_type = str_replace("- ", "", $inp_type);
						$inp_type = output_html($inp_type);
						$inp_type_mysql = quote_smart($link, $inp_type);

						$inp_title = trim($type[1]);
						$inp_title = output_html($inp_title);
						$inp_title_mysql = quote_smart($link, $inp_title);

						$inp_title_clean = clean($inp_title);
						$inp_title_clean_mysql = quote_smart($link, $inp_title_clean);


						$inp_url = "";
						if(isset($temp[1])){
							$inp_url = trim($temp[1]);
						}
						$inp_url = output_html($inp_url);
						$inp_url_mysql = quote_smart($link, $inp_url);

						$inp_url_type_array = explode(".", $inp_url);
						if(sizeof($inp_url_type_array) == 1){
							$inp_url_type = "dir";
						}
						else{
							$inp_url_type = $inp_url_type_array[1];
						}
						$inp_url_type = output_html($inp_url_type);
						$inp_url_type_mysql = quote_smart($link, $inp_url_type);


						$inp_description = "";
						if(isset($temp[2])){
							$inp_description = trim($temp[2]);
						}
						if($inp_description == "-"){
							$inp_description = "";
						}
						$inp_description = output_html($inp_description);
						$inp_description_mysql = quote_smart($link, $inp_description);

						
						if($inp_title != ""){

							$content_counter = $content_counter+1;

							// Check if it exists
							$content_module_title_clean_mysql = quote_smart($link, $get_module_title_clean);
							$query = "SELECT content_id, content_course_id, content_course_dir_name, content_module_id, content_module_title_clean, content_type, content_number, content_title, content_title_clean, content_description, content_url, content_url_type, content_read_times, content_read_times_ipblock, content_created_datetime, content_created_date_formatted, content_last_read_datetime, content_last_read_date_formatted FROM $t_courses_modules_contents WHERE content_course_dir_name=$course_dir_name_mysql AND content_module_title_clean=$content_module_title_clean_mysql AND content_title=$inp_title_mysql";
							$result = mysqli_query($link, $query);
							$row = mysqli_fetch_row($result);
							list($get_content_id, $get_content_course_id, $get_content_course_dir_name, $get_content_module_id, $get_content_module_title_clean, $get_content_type, $get_content_number, $get_content_title, $get_content_title_clean, $get_content_description, $get_content_url, $get_content_url_type, $get_content_read_times, $get_content_read_times_ipblock, $get_content_created_datetime, $get_content_created_date_formatted, $get_content_last_read_datetime, $get_content_last_read_date_formatted) = $row;

							if($get_content_id == ""){
								$changes_found = "1";
								echo"<span style=\"color: blue;\">Found changes in content #1<br /></span>";
							}
							if($inp_type != "$get_content_type"){
								$changes_found = "1";
								echo"<span style=\"color: blue;\">Found changes in content #2<br /></span>";
							}
							if($content_counter != "$get_content_number"){
								$changes_found = "1";
								echo"<span style=\"color: blue;\">Found changes in content #3: $content_counter != $get_content_number<br /></span>";
							}
							if($inp_title != "$get_content_title"){
								$changes_found = "1";
								echo"<span style=\"color: blue;\">Found changes in content #4<br /></span>";
							}
							if($inp_url != "$get_content_url"){
								$changes_found = "1";
								echo"<span style=\"color: blue;\">Found changes in content #5<br /></span>";
							}
							if($inp_url_type != "$get_content_url_type"){
								$changes_found = "1";
								echo"<span style=\"color: blue;\">Found changes in content #6<br /></span>";
							}
							echo"<span>$inp_title &middot; $get_content_id &middot; $inp_url_type #7<br /></span>";
						} // not empty title
						else{
							echo"<span class=\"grey\">$inp_title &middot; $get_content_id &middot; $inp_url_type <br /></span>";
						}
					} //isset $type[1]
				} // is content, not module			
			} // for





			if($changes_found == "1"){

				// Delete old entries
				$result = mysqli_query($link, "DELETE FROM $t_courses_modules WHERE module_course_dir_name=$course_dir_name_mysql") or die(mysqli_error($link));;
				$result = mysqli_query($link, "DELETE FROM $t_courses_modules_contents WHERE content_course_dir_name=$course_dir_name_mysql") or die(mysqli_error($link));

				// New vars
				$module_counter = 0;
				$content_counter = 0;

				echo"<hr />
				<h2>Rewrite!!</h2>";

				for($x=0;$x<$size;$x++){
					$temp = explode("|", $data_array[$x]);
					$temp_size = sizeof($temp);

					$type = explode(":", $temp[0]); // "- less" "- quiz" "- exam"
					$type_size = sizeof($type);
					if($type_size == 1 && $temp[0] != "" && isset($temp[1])){
						$inp_module_title = trim($temp[0]);
						$inp_module_title = output_html($inp_module_title);
						$inp_module_title = str_replace("&iuml;&raquo;&iquest;", "", $inp_module_title);
						$inp_module_title_mysql = quote_smart($link, $inp_module_title);


						$inp_module_url = trim($temp[1]);
						$inp_module_url = output_html($inp_module_url);
						$inp_module_url_mysql = quote_smart($link, $inp_module_url);

						$inp_title_clean = str_replace(".php", "", $inp_module_url);
						$inp_title_clean_mysql = quote_smart($link, $inp_title_clean);

						if($inp_module_title != ""){
							$module_counter = $module_counter+1;			


							mysqli_query($link, "INSERT INTO $t_courses_modules
							(module_id, module_course_id, module_course_dir_name, module_number, module_title, module_title_clean, module_url, module_read_times, module_created, module_updated) 
							VALUES 
							(NULL, $get_current_course_id, $course_dir_name_mysql, $module_counter, $inp_module_title_mysql, $inp_title_clean_mysql, $inp_module_url_mysql, 0, '$datetime', '$datetime')")
							or die(mysqli_error($link));
					
							// Get ID
							$query = "SELECT module_id, module_title_clean FROM $t_courses_modules WHERE module_course_dir_name=$course_dir_name_mysql AND module_title=$inp_module_title_mysql";
							$result = mysqli_query($link, $query);
							$row = mysqli_fetch_row($result);
							list($get_module_id, $get_module_title_clean) = $row;
							echo"<h2>$inp_module_title &middot; $get_module_title_clean &middot; $get_module_id </h2>";
						}

					
					} // end module
					else{
						if(isset($type[1]) && !(empty(trim($type[1])))){
						
							$inp_type = trim($type[0]);
							$inp_type = str_replace("- ", "", $inp_type);
							$inp_type = output_html($inp_type);
							$inp_type_mysql = quote_smart($link, $inp_type);

							$inp_title = trim($type[1]);
							$inp_title = output_html($inp_title);
							$inp_title_mysql = quote_smart($link, $inp_title);

							$inp_title_clean = clean($inp_title);
							$inp_title_clean_mysql = quote_smart($link, $inp_title_clean);

							$inp_url = "";
							if(isset($temp[1])){
								$inp_url = trim($temp[1]);
							}
							$inp_url = output_html($inp_url);
							$inp_url_mysql = quote_smart($link, $inp_url);

							$inp_url_type_array = explode(".", $inp_url);
							if(sizeof($inp_url_type_array) == 1){
								$inp_url_type = "dir";
							}
							else{
								$inp_url_type = $inp_url_type_array[1];
							}
							$inp_url_type = output_html($inp_url_type);
							$inp_url_type_mysql = quote_smart($link, $inp_url_type);
						

							$inp_description = "";
							if(isset($temp[2])){
								$inp_description = trim($temp[2]);
							}
							if($inp_description == "-"){
								$inp_description = "";
							}
							$inp_description = output_html($inp_description);
							$inp_description_mysql = quote_smart($link, $inp_description);

						
							if($inp_title != ""){

								$content_counter = $content_counter+1;

								$content_module_title_clean_mysql = quote_smart($link, $get_module_title_clean);
								mysqli_query($link, "INSERT INTO $t_courses_modules_contents 
								(content_id, content_course_id, content_course_dir_name, content_module_id, content_module_title_clean, content_type, content_number, content_title, content_title_clean, content_description, content_url, content_url_type, content_read_times, content_read_times_ipblock, content_created_datetime, content_created_date_formatted) 
								VALUES 
								(NULL, $get_current_course_id, $course_dir_name_mysql, $get_module_id, $content_module_title_clean_mysql, $inp_type_mysql, $content_counter, $inp_title_mysql, $inp_title_clean_mysql, $inp_description_mysql, $inp_url_mysql, $inp_url_type_mysql, '0', '', '$datetime', '$date_formatted')")
								or die(mysqli_error($link));

								$query = "SELECT content_id FROM $t_courses_modules_contents WHERE content_course_dir_name=$course_dir_name_mysql AND content_module_title_clean=$content_module_title_clean_mysql AND content_title=$inp_title_mysql";
								$result = mysqli_query($link, $query);
								$row = mysqli_fetch_row($result);
								list($get_content_id) = $row;

								echo"<span>#$content_counter $inp_title &middot; $get_content_id<br /></span>";
							} // not empty title
						} //isset $type[1]
					} // is content, not module			
				} // for
			} // changes found
		} // file exists


	} // action == "look_for_changes_in_modules_and_content"
} // course found

?>