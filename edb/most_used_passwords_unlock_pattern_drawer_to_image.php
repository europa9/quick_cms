<?php 
/**
*
* File: edb/most_used_passwords_unlock_pattern_drawer_to_image.php
* Version 1.0
* Date 15:32 31.08.2019
* Copyright (c) 2019 S. A. Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/*- Variables -------------------------------------------------------------------------- */
if(isset($_GET['pattern'])) {
	$pattern = $_GET['pattern'];
	$pattern = strip_tags(stripslashes($pattern));
}
else{
	$pattern = "";
}

$pattern_array = explode("-", $pattern);
$pattern_array_size = sizeof($pattern_array);


/*- Generate image ---------------------------------------------------------------------- */

$img_width = 150;
$img_height = 150;
 
$img = imagecreatetruecolor($img_width, $img_height);

$white = imagecolorallocate($img, 255, 255, 255);
$light_blue = imagecolorallocate($img, 134, 180, 203);
$dark_blue  = imagecolorallocate($img, 9, 39, 88);
$red  = imagecolorallocate($img, 100, 44, 44);
 
imagefill($img, 0, 0, $white);

// Draw 3x3 circles
// Ready cordinates
$cord_counter = 1;
for($x=1;$x<4;$x++){
	for($y=1;$y<4;$y++){
		$from_left = ($x*50)-25;
		$from_top  = ($y*50)-25;
		imageellipse($img, $from_left, $from_top, 20, 20, $light_blue);

		// Cord
		$cord_array_x[$cord_counter] = "$from_left";
		$cord_array_y[$cord_counter] = "$from_top";

		$cord_counter = $cord_counter + 1;
	} // y
} // x

// Draw the array
for($z=0;$z<$pattern_array_size;$z++){
	$pattern_placement = $pattern_array[$z];
	$place_on_image_cord_x = $cord_array_x[$pattern_placement];
	$place_on_image_cord_y = $cord_array_y[$pattern_placement];

	// First = circle, rest=arrow, last=diamond
	if($z == 0){
		imagefilledellipse($img, $place_on_image_cord_x, $place_on_image_cord_y, 6, 6, $dark_blue);
	}
	elseif($z == $pattern_array_size-1){
		imagefilledrectangle($img, $place_on_image_cord_y-3, $place_on_image_cord_x-3, $place_on_image_cord_y+3, $place_on_image_cord_x+3, $dark_blue);
	}
	else{

	}

	if(isset($coming_from_place_on_image_cord_x)){
		imageline($img, $coming_from_place_on_image_cord_y, $coming_from_place_on_image_cord_x, $place_on_image_cord_y, $place_on_image_cord_x, $dark_blue);	
	}
	

	// Transfer
	$coming_from_pattern_placement = "$pattern_placement";
	$coming_from_place_on_image_cord_x = "$place_on_image_cord_x";
	$coming_from_place_on_image_cord_y = "$place_on_image_cord_y";
} // z


header("Content-type: image/png"); 
imagepng($img);

?>