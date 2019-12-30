<?php
/**
*
* File: _admin/_functions/quote_smart.php
* Version 23.37 23.11.2016
* Copyright (c) 2008-2016 Solo
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
function quote_smart($link, $value){
	// Table: http://www.starr.net/is/type/htmlcodes.html

	// Norwegian characters
	$value = str_replace("æ","&aelig;","$value"); // &#230;
	$value = str_replace("ø","&oslash;","$value"); // &#248;
	$value = str_replace("å","&aring;","$value"); // &#229;
	$value = str_replace("Æ","&Aelig;","$value"); // &#198;
	$value = str_replace("Ø","&Oslash;","$value"); // &#216;
	$value = str_replace("Å",'&Aring;', "$value"); // &#197;

        // Stripslashes
        if (get_magic_quotes_gpc() && !is_null($value) ) {
                $value = stripslashes($value);
        }

        //Change decimal values from , to . if applicable
        if( is_numeric($value) && strpos($value,',') !== false ){
                $value = str_replace(',','.',$value);
        }
        if( is_null($value) ){
                $value = 'NULL';
        }
        // Quote if not integer or null
        elseif (!is_numeric($value)) {
                $value = "'" . mysqli_real_escape_string($link, $value) . "'";
        }

        return $value;
}
?>