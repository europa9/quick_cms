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
	$value = str_replace('÷', '&#247;', $value);  // Yeah, I know.  But otherwise the gap is confusing.  --Kris

	// Check last, if it is backslash, then replace it...
	$check  = substr($value, -1);
	$check  =  "^" . $check . "^";
	if($check == "^\^"){
		$new_value = substr($value, 0, -1);
		$value	 = $new_value . "&#92";
	}

	// A
	$value = str_replace('æ', '&aelig;', $value);
	$value = str_replace("Ã¦", "&aelig;", $value);
	$value = str_replace("&amp;aelig;", "&aelig;", $value);
	$value = str_replace('ø', '&oslash;', $value);
	$value = str_replace('Ã¸', '&oslash;', $value);
	$value = str_replace('&amp;oslash;', '&oslash;', $value);
	$value = str_replace("å", "&aring;", $value);
	$value = str_replace("Ã¥", "&aring;", $value);
	$value = str_replace("&amp;aring;", "&aring;", $value);
	$value = str_replace('Æ', '&AElig;', $value);
	$value = str_replace('Ã†', '&AElig;', $value);
	$value = str_replace('&amp;AElig;', '&AElig;', $value);
	$value = str_replace('Å', '&Aring;', $value);
	$value = str_replace('Ã…', '&Aring;', $value);
	$value = str_replace('&amp;Aring;', '&Aring;', $value);

	$value = str_replace('á', '&aacute;', $value);
	$value = str_replace('à', '&agrave;', $value);
	$value = str_replace('À', '&Agrave;', $value);
	$value = str_replace('â', '&acirc;', $value);
	$value = str_replace('Â', '&Acirc;', $value);
	$value = str_replace('Á', '&Aacute;', $value);


	$value = str_replace('Ä', '&Auml;', $value);
	$value = str_replace('ä', '&auml;', $value);


	$value = str_replace('À', '&#192;', $value);
	$value = str_replace('Á', '&#193;', $value);
	// $value = str_replace('Â', '&#194;', $value);
	// $value = str_replace('Ã', '&#195;', $value);
	$value = str_replace('Ä', '&#196;', $value);
	$value = str_replace('à', '&#224;', $value);
	$value = str_replace('á', '&#225;', $value);
	$value = str_replace('â', '&#226;', $value);
	$value = str_replace('ã', '&#227;', $value);
	$value = str_replace('ä', '&#228;', $value);

	// C
	$value = str_replace('Ç', '&#199;', $value);
	$value = str_replace('ç', '&#231;', $value);


	// E
	$value = str_replace('è', '&egrave;', $value);
	$value = str_replace('È', '&Egrave;', $value);
	$value = str_replace('é', '&eacute;', $value);
	$value = str_replace('É', '&Eacute;', $value);
	$value = str_replace('ê', '&ecirc;', $value);
	$value = str_replace('Ê', '&Ecirc;', $value);
	$value = str_replace('ë', '&euml;', $value);
	$value = str_replace('Ë', '&Euml;', $value);
	$value = str_replace('È', '&#200;', $value);
	$value = str_replace('É', '&#201;', $value);
	$value = str_replace('Ê', '&#202;', $value);
	$value = str_replace('Ë', '&#203;', $value);
	$value = str_replace('è', '&#232;', $value);
	$value = str_replace('é', '&#233;', $value);
	$value = str_replace('ê', '&#234;', $value);
	$value = str_replace('ë', '&#235;', $value);

	// I
	$value = str_replace('î', '&icirc;', $value);
	$value = str_replace('Î', '&Icirc;', $value);
	$value = str_replace('ï', '&iuml;', $value);
	$value = str_replace('Ï', '&Iuml;', $value);
	$value = str_replace('Í', '&Iacute;', $value);
	$value = str_replace('í', '&iacute;', $value);
	$value = str_replace('¿', '&iquest;', $value);
	$value = str_replace('¡', '&iexcl;', $value);
	$value = str_replace('Ì', '&#204;', $value);
	$value = str_replace('Í', '&#205;', $value);
	$value = str_replace('Î', '&#206;', $value);
	$value = str_replace('Ï', '&#207;', $value);
	$value = str_replace('ì', '&#236;', $value);
	$value = str_replace('í', '&#237;', $value);
	$value = str_replace('î', '&#238;', $value);
	$value = str_replace('ï', '&#239;', $value);

	// D
	$value = str_replace('Ð', '&#208;', $value);

	// N
	$value = str_replace('Ñ', '&Ntilde;', $value);
	$value = str_replace('ñ', '&ntilde;', $value);
	$value = str_replace('Ñ', '&#209;', $value);

	// O
	$value = str_replace('Ø', '&Oslash;', $value);
	$value = str_replace('Ã˜', '&Oslash;', $value);
	$value = str_replace('&amp;Oslash;', '&Oslash;', $value);
	$value = str_replace('ô', '&ocirc;', $value);
	$value = str_replace('Ô', '&Ocirc;', $value);
	$value = str_replace('Ó', '&Oacute;', $value);
	$value = str_replace('ó', '&oacute;', $value);
	$value = str_replace('º', '&ordm;', $value);
	$value = str_replace('ª', '&ordf;', $value);
	$value = str_replace('Ö', '&Ouml;', $value);
	$value = str_replace('ö', '&ouml;', $value);
	$value = str_replace('Ò', '&#210;', $value);
	$value = str_replace('Ó', '&#211;', $value);
	$value = str_replace('Ô', '&#212;', $value);
	$value = str_replace('Õ', '&#213;', $value);
	$value = str_replace('Ö', '&#214;', $value);
	$value = str_replace('ð', '&#240;', $value);
	$value = str_replace('ñ', '&#241;', $value);
	$value = str_replace('ò', '&#242;', $value);
	$value = str_replace('ó', '&#243;', $value);
	$value = str_replace('ô', '&#244;', $value);
	$value = str_replace('õ', '&#245;', $value);
	$value = str_replace('ö', '&#246;', $value);

	// P
	$value = str_replace('Þ', '&#222;', $value);
	$value = str_replace('þ', '&#254;', $value);

	// S
	$value = str_replace('ß', '&#223;', $value);

	// U
	$value = str_replace('ù', '&ugrave;', $value);
	$value = str_replace('Ù', '&Ugrave;', $value);
	$value = str_replace('û', '&ucirc;', $value);
	$value = str_replace('Û', '&Ucirc;', $value);
	$value = str_replace('ü', '&uuml;', $value);
	$value = str_replace('Ü', '&Uuml;', $value);
	$value = str_replace('Ú', '&Uacute;', $value);
	$value = str_replace('ú', '&uacute;', $value);
	$value = str_replace('ü', '&uuml;', $value);
	$value = str_replace('Ù', '&#217;', $value);
	$value = str_replace('Ú', '&#218;', $value);
	$value = str_replace('Û', '&#219;', $value);
	$value = str_replace('Ü', '&#220;', $value);
	$value = str_replace('ù', '&#249;', $value);
	$value = str_replace('ú', '&#250;', $value);
	$value = str_replace('û', '&#251;', $value);
	$value = str_replace('ü', '&#252;', $value);

	// Y
	$value = str_replace('ÿ', '&yuml;', $value);
	$value = str_replace('Ÿ', '&Yuml;', $value);
	$value = str_replace('Ý', '&#221;', $value);
	$value = str_replace('ý', '&#253;', $value);
	$value = str_replace('ÿ', '&#255;', $value);
 
	// X
	$value = str_replace('×', '&#215;', $value);  // Yeah, I know.  But otherwise the gap is confusing.  --Kris


	// Other
	$value = str_replace('ç', '&ccedil;', $value);
	$value = str_replace('Ç', '&Ccedil;', $value);
	$value = str_replace('œ', '&oelig;', $value);
	$value = str_replace('Œ', '&OElig;', $value);

	//Punctuation
	$value = str_replace('«', '&laquo;', $value);
	$value = str_replace('»', '&raquo;', $value);
	$value = str_replace('‹', '&lsaquo;', $value);
	$value = str_replace('›', '&rsaquo;', $value);
	$value = str_replace('“', '&ldquo;', $value);
	$value = str_replace('”', '&rdquo;', $value);
	$value = str_replace('‘', '&lsquo;', $value);
	$value = str_replace('’', '&rsquo;', $value);
	$value = str_replace('—', '&mdash;', $value);
	$value = str_replace('–', '&ndash;', $value);

	// Money
	$value = str_replace('€', '&euro;', $value);

	// Degree
	$value = str_replace('Â°', '&deg;', $value);
	$value = str_replace('&amp;deg;', '&deg;', $value);

	// &
	$value = str_replace('&amp;amp;', '&amp;', $value);


	// Return
	return $value;
}
?>