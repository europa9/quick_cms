<?php

/*- Current page ---------------------------------------- */
$self 		= $_SERVER['PHP_SELF'];
$request_url 	= $_SERVER["REQUEST_URI"];
$self_array     = explode("/", $self);
$array_size     = sizeof($self_array);

$minus_one	= $array_size-1;
$minus_one	= $self_array[$minus_one];

$minus_two	= $array_size-2;
$minus_two	= $self_array[$minus_two];

$complex	= $minus_two . "/" . $minus_one;



/*- Language ------------------------------------------ */
include("$root/_admin/_translations/site/$l/recipes/ts_recipes.php");


/*- Special main mode ------------------------------------------------------------------ */
if(!(isset($include_as_navigation_main_mode))){
	$include_as_navigation_main_mode = 0;
}



/*- Variables ----------------------------------------- */
$l_mysql = quote_smart($link, $l);


if($include_as_navigation_main_mode == 0){
	echo"
	<ul class=\"toc\">
		<li class=\"header_home\"><a href=\"$root/recipes/index.php?l=$l\""; if($minus_one == "index.php" && $minus_two == "recipes"){ echo" class=\"navigation_active\"";}echo">$l_recipes</a></li>
	";
}

echo"
<li><a href=\"$root/recipes/categories.php?l=$l\""; if($minus_one == "categories.php"){ echo" class=\"navigation_active\"";}echo">$l_categories</a></li>

	

	<li class=\"header_up\"><a href=\"$root/recipes/user_pages.php?l=$l\""; if($minus_one == "index.php" && $minus_two == "android"){ echo" class=\"navigation_active\"";}echo">$l_user_pages</a></li>
	<li><a href=\"$root/recipes/my_recipes.php?l=$l\""; if($minus_one == "my_recipes.php"){ echo" class=\"navigation_active\"";}echo">$l_my_recipes</a></li>
	<li><a href=\"$root/recipes/my_favorites.php?l=$l\""; if($minus_one == "my_favorites.php"){ echo" class=\"navigation_active\"";}echo">$l_my_favorites</a></li>
	<li><a href=\"$root/recipes/submit_recipe.php?l=$l\""; if($minus_one == "submit_recipe.php"){ echo" class=\"navigation_active\"";}echo">$l_submit_recipe</a></li>
";

if($include_as_navigation_main_mode == 0){
	echo"
	</ul>
	\n";
}
?>