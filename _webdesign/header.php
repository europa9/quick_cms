<?php
/**
*
* File: _webdesign/header.php
* Version 2.0
* Date 11:20 02.05.2019
* Copyright (c) 2009-2019 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if(!(isset($webdesignSav))){
	include("$root/_admin/website_config.php");
}
include("$root/_webdesign/$webdesignSav/header.php");
?>