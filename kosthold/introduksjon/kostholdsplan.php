<?php
/*- Configuration ---------------------------------------------------------------------------- */
$layoutNumberOfColumn = "2";
$layoutCommentsActive = "1";

/*- Variables ------------------------------------------------------------------------- */
if(isset($_GET['id'])) {
	$id = $_GET['id'];
	$id = strip_tags(stripslashes($id));
}
else{
	$id = "";
}

/*- Header ----------------------------------------------------------- */
if($id != ""){
	$website_title = "Kosthold - Kostholdsplan - Måltidsplan $id"; 
}
else{
	$website_title = "Kosthold - Kostholdsplan"; 
}
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");


/*- Content ---------------------------------------------------------- */
echo"
<h1>Kostholdsplan</h1>

$money


<p>
<b>Kostholdsplan</b><br />
<a href=\"kostholdsplan.php\""; if($id == ""){ echo" style=\"font-weight: bold;\""; } echo">Introduksjon</a>
|
<a href=\"kostholdsplan.php?id=1\""; if($id == "1"){ echo" style=\"font-weight: bold;\""; } echo">Måltidsplan 1</a>
|
<a href=\"kostholdsplan.php?id=2\""; if($id == "2"){ echo" style=\"font-weight: bold;\""; } echo">Måltidsplan 2</a>
</p>


";
if($id == ""){
	include("kostholdsplan/0.php");
}
elseif($id == "1" OR $id == "2"){
	include("kostholdsplan/$id.php");
}

echo"
";


/*- Footer ----------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>