<?php
/**
*
* File: _admin/_functions/output_html.php
* Version 2 - Updated 19:31 06.03.2015
* Copyright (c) 2008-2015 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*
*
* -----> Please also see: encode_national_letters.php <-----
* encode_national_letters.php are used when this class cannot be used, because
* this class also removes html entities. Example SQL with links, bold text etc
*
*
*/
function output_html($value){
	// Stripslashes
	$value = htmlentities($value, ENT_COMPAT, "UTF-8");
	$value = str_replace('"',"&quot;","$value");
	$value = str_replace("'","&#039;","$value");
	$value = str_replace("<","&gt;","$value"); // less than
	$value = str_replace(">","&lt;","$value"); // greater than
	$value = str_replace("\n","<br />","$value");
	
	// Trim and line space
	$value = trim($value);

	// Math
	$value = str_replace("&amp;#699;","&#39;","$value");
	$value = str_replace("&amp;#3647;","&#3647;","$value");
	$value = str_replace("&amp;#960;","&#960;","$value"); // pi
	$value = str_replace("&amp;#966;","&#966;","$value"); // phi
	$value = str_replace('�', '&#247;', $value);  // Yeah, I know.  But otherwise the gap is confusing.  --Kris

	// Check last, if it is backslash, then replace it...
	$check  = substr($value, -1);
	$check  =  "^" . $check . "^";
	if($check == "^\^"){
		$new_value = substr($value, 0, -1);
		$value	 = $new_value . "&#92";
	}

	// A
	$value = str_replace('�', '&aelig;', $value);
	$value = str_replace("æ", "&aelig;", $value);
	$value = str_replace("&amp;aelig;", "&aelig;", $value);
	$value = str_replace('�', '&oslash;', $value);
	$value = str_replace('ø', '&oslash;', $value);
	$value = str_replace('&amp;oslash;', '&oslash;', $value);
	$value = str_replace("�", "&aring;", $value);
	$value = str_replace("å", "&aring;", $value);
	$value = str_replace("&amp;aring;", "&aring;", $value);
	$value = str_replace('�', '&AElig;', $value);
	$value = str_replace('Æ', '&AElig;', $value);
	$value = str_replace('&amp;AElig;', '&AElig;', $value);
	$value = str_replace('�', '&Aring;', $value);
	$value = str_replace('Å', '&Aring;', $value);
	$value = str_replace('&amp;Aring;', '&Aring;', $value);

	$value = str_replace('�', '&aacute;', $value);
	$value = str_replace('�', '&agrave;', $value);
	$value = str_replace('�', '&Agrave;', $value);
	$value = str_replace('�', '&acirc;', $value);
	$value = str_replace('�', '&Acirc;', $value);
	$value = str_replace('�', '&Aacute;', $value);


	$value = str_replace('�', '&Auml;', $value);
	$value = str_replace('�', '&auml;', $value);


	$value = str_replace('�', '&#192;', $value);
	$value = str_replace('�', '&#193;', $value);
	// $value = str_replace('�', '&#194;', $value);
	// $value = str_replace('�', '&#195;', $value);
	$value = str_replace('�', '&#196;', $value);
	$value = str_replace('�', '&#224;', $value);
	$value = str_replace('�', '&#225;', $value);
	$value = str_replace('�', '&#226;', $value);
	$value = str_replace('�', '&#227;', $value);
	$value = str_replace('�', '&#228;', $value);

	// C
	$value = str_replace('�', '&#199;', $value);
	$value = str_replace('�', '&#231;', $value);


	// E
	$value = str_replace('�', '&egrave;', $value);
	$value = str_replace('�', '&Egrave;', $value);
	$value = str_replace('�', '&eacute;', $value);
	$value = str_replace('�', '&Eacute;', $value);
	$value = str_replace('�', '&ecirc;', $value);
	$value = str_replace('�', '&Ecirc;', $value);
	$value = str_replace('�', '&euml;', $value);
	$value = str_replace('�', '&Euml;', $value);
	$value = str_replace('�', '&#200;', $value);
	$value = str_replace('�', '&#201;', $value);
	$value = str_replace('�', '&#202;', $value);
	$value = str_replace('�', '&#203;', $value);
	$value = str_replace('�', '&#232;', $value);
	$value = str_replace('�', '&#233;', $value);
	$value = str_replace('�', '&#234;', $value);
	$value = str_replace('�', '&#235;', $value);

	// I
	$value = str_replace('�', '&icirc;', $value);
	$value = str_replace('�', '&Icirc;', $value);
	$value = str_replace('�', '&iuml;', $value);
	$value = str_replace('�', '&Iuml;', $value);
	$value = str_replace('�', '&Iacute;', $value);
	$value = str_replace('�', '&iacute;', $value);
	$value = str_replace('�', '&iquest;', $value);
	$value = str_replace('�', '&iexcl;', $value);
	$value = str_replace('�', '&#204;', $value);
	$value = str_replace('�', '&#205;', $value);
	$value = str_replace('�', '&#206;', $value);
	$value = str_replace('�', '&#207;', $value);
	$value = str_replace('�', '&#236;', $value);
	$value = str_replace('�', '&#237;', $value);
	$value = str_replace('�', '&#238;', $value);
	$value = str_replace('�', '&#239;', $value);

	// D
	$value = str_replace('�', '&#208;', $value);

	// N
	$value = str_replace('�', '&Ntilde;', $value);
	$value = str_replace('�', '&ntilde;', $value);
	$value = str_replace('�', '&#209;', $value);

	// O
	$value = str_replace('�', '&Oslash;', $value);
	$value = str_replace('Ø', '&Oslash;', $value);
	$value = str_replace('&amp;Oslash;', '&Oslash;', $value);
	$value = str_replace('�', '&ocirc;', $value);
	$value = str_replace('�', '&Ocirc;', $value);
	$value = str_replace('�', '&Oacute;', $value);
	$value = str_replace('�', '&oacute;', $value);
	$value = str_replace('�', '&ordm;', $value);
	$value = str_replace('�', '&ordf;', $value);
	$value = str_replace('�', '&Ouml;', $value);
	$value = str_replace('�', '&ouml;', $value);
	$value = str_replace('�', '&#210;', $value);
	$value = str_replace('�', '&#211;', $value);
	$value = str_replace('�', '&#212;', $value);
	$value = str_replace('�', '&#213;', $value);
	$value = str_replace('�', '&#214;', $value);
	$value = str_replace('�', '&#240;', $value);
	$value = str_replace('�', '&#241;', $value);
	$value = str_replace('�', '&#242;', $value);
	$value = str_replace('�', '&#243;', $value);
	$value = str_replace('�', '&#244;', $value);
	$value = str_replace('�', '&#245;', $value);
	$value = str_replace('�', '&#246;', $value);

	// P
	$value = str_replace('�', '&#222;', $value);
	$value = str_replace('�', '&#254;', $value);

	// S
	$value = str_replace('�', '&#223;', $value);

	// U
	$value = str_replace('�', '&ugrave;', $value);
	$value = str_replace('�', '&Ugrave;', $value);
	$value = str_replace('�', '&ucirc;', $value);
	$value = str_replace('�', '&Ucirc;', $value);
	$value = str_replace('�', '&uuml;', $value);
	$value = str_replace('�', '&Uuml;', $value);
	$value = str_replace('�', '&Uacute;', $value);
	$value = str_replace('�', '&uacute;', $value);
	$value = str_replace('�', '&uuml;', $value);
	$value = str_replace('�', '&#217;', $value);
	$value = str_replace('�', '&#218;', $value);
	$value = str_replace('�', '&#219;', $value);
	$value = str_replace('�', '&#220;', $value);
	$value = str_replace('�', '&#249;', $value);
	$value = str_replace('�', '&#250;', $value);
	$value = str_replace('�', '&#251;', $value);
	$value = str_replace('�', '&#252;', $value);

	// Y
	$value = str_replace('�', '&yuml;', $value);
	$value = str_replace('�', '&Yuml;', $value);
	$value = str_replace('�', '&#221;', $value);
	$value = str_replace('�', '&#253;', $value);
	$value = str_replace('�', '&#255;', $value);
 
	// X
	$value = str_replace('�', '&#215;', $value);  // Yeah, I know.  But otherwise the gap is confusing.  --Kris


	// Other
	$value = str_replace('�', '&ccedil;', $value);
	$value = str_replace('�', '&Ccedil;', $value);
	$value = str_replace('�', '&oelig;', $value);
	$value = str_replace('�', '&OElig;', $value);

	//Punctuation
	$value = str_replace('�', '&laquo;', $value);
	$value = str_replace('�', '&raquo;', $value);
	$value = str_replace('�', '&lsaquo;', $value);
	$value = str_replace('�', '&rsaquo;', $value);
	$value = str_replace('�', '&ldquo;', $value);
	$value = str_replace('�', '&rdquo;', $value);
	$value = str_replace('�', '&lsquo;', $value);
	$value = str_replace('�', '&rsquo;', $value);
	$value = str_replace('�', '&mdash;', $value);
	$value = str_replace('�', '&ndash;', $value);

	// Money
	$value = str_replace('�', '&euro;', $value);

	// Degree
	$value = str_replace('°', '&deg;', $value);
	$value = str_replace('&amp;deg;', '&deg;', $value);

	// &
	$value = str_replace('&amp;amp;', '&amp;', $value);


	// Return
	return $value;
}
?>