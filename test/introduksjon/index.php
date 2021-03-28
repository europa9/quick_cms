<?php
/*- Configuration ---------------------------------------------------------------------------- */
$layoutNumberOfColumn = "2";
$layoutCommentsActive = "1";

/*- Header ----------------------------------------------------------- */
$website_title = "test - introduksjon";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");

/*- Content ---------------------------------------------------------- */
?>

<p>1zza</p>

<?php
/*- Course ---------------------------------------------------------- */
include("$root/courses/_includes/content_after_content.php");

/*- Footer ----------------------------------------------------------- */
include("$root/_webdesign/$webdesignSav/footer.php");
?>