<?php
if(isset($_SESSION['admin_user_id'])){

	$t_stats_user_agents 		= $mysqlPrefixSav . "stats_user_agents";



 mysqli_query($link, "INSERT INTO $t_stats_user_agents
(stats_user_agent_id, stats_user_agent_string, stats_user_agent_browser, stats_user_agent_os, stats_user_agent_bot, stats_user_agent_url, stats_user_agent_browser_icon, stats_user_agent_os_icon, stats_user_agent_bot_icon, stats_user_agent_type, stats_user_agent_banned)
VALUES
(NULL, 'facebookexternalhit/1.1;kakaotalk-scrap/1.0; +https://devtalk.kakao.com/t/scrap/33984', '', '', 'Facebook', 'http://facebook.com', '', '', 'facebook.png', 'bot', '0')") or die(mysqli_error($link));


}
?>