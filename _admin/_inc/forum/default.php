<?php
/**
*
* File: _admin/_inc/discuss/default.php
* Version 15.00 03.03.2017
* Copyright (c) 2008-2017 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}


/*- Variables ----------------------------------------------------------------------- */
$tabindex = 0;


echo"
<h1>Forum</h1>
<div class=\"vertical\">
	<ul>
";
include("_inc/forum/menu.php");
echo"	</ul>
</div>
";
?>