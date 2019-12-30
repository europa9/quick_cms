<?php

/*- Check if setup is run ------------------------------------------------------------ */
$server_name = $_SERVER['HTTP_HOST'];
$server_name = clean($server_name);
$setup_finished_file = "setup_finished_" . $server_name . ".php";
if(file_exists("../_data/$setup_finished_file")){
	echo"Setup is finished.";
	die;
}

/*- Config -------------------------------------------------------------------------- */
include("../_data/webdesign.php");

/*- Variables ----------------------------------------------------------------------- */
if(isset($_GET['action'])) {
	$action = $_GET['action'];
	$action = strip_tags(stripslashes($action));
}
else{
	$action = "";
}

if($action == ""){
	echo"
	<h1>$l_webdesign</h1>
		
	<!-- Feedback -->
		";
		if($ft != ""){
			if($fm == "changes_saved"){
				$fm = "$l_changes_saved";
			}
			else{
				$fm = ucfirst($ft);
			}
			echo"<div class=\"$ft\"><span>$fm</span></div>";
		}
		echo"
	<!-- //Feedback -->


	<!-- All webdesigns -->
		
		";
		$path = "../../_webdesign";
		if(!(is_dir("$path"))){
			echo"$path doesnt exists";
			die;
		}
		if ($handle = opendir($path)) {
			$x = 0;
			while (false !== ($webdesign_name = readdir($handle))) {
				if ($webdesign_name === '.') continue;
				if ($webdesign_name === '..') continue;
				if ($webdesign_name === 'images') continue;
				if ($webdesign_name === '_other_designs') continue;
				if(is_dir("$path/$webdesign_name")){
					if($x == 0){
						echo"
						<div class=\"flex_row\">
						";
					}
					echo"
							<div class=\"flex_col\">
								<p>
								<a href=\"index.php?page=06_webdesign&amp;action=view_webdesign&amp;webdesign_name=$webdesign_name&amp;language=$language\">$webdesign_name</a><br />
								<a href=\"index.php?page=06_webdesign&amp;action=view_webdesign&amp;webdesign_name=$webdesign_name&amp;language=$language\"><img src=\"$path/$webdesign_name/webdesign_preview_$webdesign_name.jpg\" alt=\"webdesign_preview_$webdesign_name.jpg\" style=\"border: ";
								if($webdesignSav == "$webdesign_name"){ echo"#009b33 2px solid"; } else{ echo"#000 1px solid"; } echo";\" /></a>
								</p>
							</div>
					";

					if($x == 1){
						echo"
							</div>
						";

						$x = -1;
					}
					$x++;
				}
			}
		}
		if($x == 1){
						echo"
							</div>
						";

		}
		echo"
	<!-- //All webdesigns -->
	";
}
elseif($action == "view_webdesign"){
	/*- Variables ------------------------------------------------------------------------ */
	if(isset($_GET['webdesign_name'])) {
		$webdesign_name = $_GET['webdesign_name'];
		$webdesign_name = strip_tags(stripslashes($webdesign_name));
	}
	else{
		$webdesign_name = "";
	}
	if(is_dir("../../_webdesign/$webdesign_name") && file_exists("../../_webdesign/$webdesign_name/webdesign_preview_$webdesign_name.jpg")){
		echo"
		<h1>$webdesign_name</h1>

		<!-- Where am I? -->
			<p><b>$l_you_are_here:</b><br />
			<a href=\"index.php?page=06_webdesign&amp;language=$language\">$l_webdesign</a>
			&gt;
			<a href=\"index.php?page=06_webdesign&amp;action=view_webdesign&amp;webdesign_name=$webdesign_name&amp;language=$language\">$webdesign_name</a>
			</p>
		<!-- //Where am I? -->

		<!-- Design info -->
			<div style=\"float: left;\">
				<img src=\"../../_webdesign/$webdesign_name/webdesign_preview_$webdesign_name.jpg\" alt=\"webdesign_preview_$webdesign_name.jpg\" style=\"border: #ccc 1px solid;\" />
			</div>
			<div>
				<p><b>$l_name:</b> $webdesign_name</p>

				<p><a href=\"index.php?page=06_webdesign&amp;action=switch_to_webdesign&amp;webdesign_name=$webdesign_name&amp;language=$language&amp;process=1\" class=\"btn_default\">$l_use_design</a></p>
			</div>

			<div class=\"clear\"></div>
		<!-- //Design info -->
		";
	} // found
}

elseif($action == "switch_to_webdesign"){
	/*- Variables ------------------------------------------------------------------------ */
	if(isset($_GET['webdesign_name'])) {
		$webdesign_name = $_GET['webdesign_name'];
		$webdesign_name = strip_tags(stripslashes($webdesign_name));
	}
	else{
		$webdesign_name = "";
	}
	if(is_dir("../../_webdesign/$webdesign_name") && file_exists("../../_webdesign/$webdesign_name/webdesign_preview_$webdesign_name.jpg")){
		

	$update_file="<?php
\$webdesignSav 	 = \"$webdesign_name\";
?>";

		$fh = fopen("../_data/webdesign.php", "w+") or die("can not open file");
		fwrite($fh, $update_file);
		fclose($fh);


		// Setup finished
		$fh = fopen("../_data/$setup_finished_file", "w+") or die("can not open file");
		fwrite($fh, "$cmsVersionSav");
		fclose($fh);


		// Move to liquidbase
		header("Location: ../_liquidbase/liquidbase.php");
		exit;
	}
}
?>

