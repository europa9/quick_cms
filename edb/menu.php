<?php
/*- Language --------------------------------------------------------------------------- */
include("$root/_admin/_translations/site/$l/edb/ts_menu.php");

echo"
								<ul>
									<li><a href=\"cases_explorer.php?finished=0&amp;l=$l\">$l_cases_explorer</a></li>
									<li><a href=\"tasks.php?finished=0&amp;l=$l\">$l_tasks</a></li>";

									if(isset($get_current_district_id)){
										echo"									";
										echo"<li><a href=\"tasks.php?finished=0&amp;district_id=$get_current_district_id&amp;l=$l\">$get_current_district_title $l_tasks_lowercase</a></li>\n";
									}
									if(isset($get_current_station_id)){
										echo"									";
										echo"<li><a href=\"tasks.php?finished=0&amp;station_id=$get_current_station_id&amp;l=$l\">$get_current_station_title $l_tasks_lowercase</a></li>\n";
									}
									echo"
									<li><a href=\"tasks.php?finished=0&amp;user_id=$my_user_id&amp;l=$l\">$l_my_tasks</a></li>
									<li><a href=\"storage.php?l=$l"; 
									if(isset($get_current_station_id)){
										echo"&amp;station_id=$get_current_station_id";
									}
									if(isset($get_current_district_id)){
										echo"&amp;district_id=$get_current_district_id";
									}
									echo"\">$l_storage</a></li>
									<li><a href=\"most_used_passwords.php?l=$l\">$l_most_used_passwords</a></li>
									<li><a href=\"automated_tasks_overview.php?"; if(isset($get_current_district_id)){ echo"district_id=$get_current_district_id&amp;"; } if(isset($get_current_station_id)){ echo"station_id=$get_current_station_id&amp;"; } echo"l=$l\">$l_automated_tasks_overview</a></li>
								</ul>
";
?>