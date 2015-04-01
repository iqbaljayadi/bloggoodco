<?php
//this is the less compiler. It is not used in production, it is just for developers who want to use our theme with elss


ob_start('ob_gzhandler');
header('Content-type: text/css');


require_once("css-files/less/lessc.inc.php");
$less = new lessc;

//$less->setPreserveComments(true);
echo $less->compileFile("css-files/main.less");
//echo $less->compileFile("external/bootstrap-master/less/bootstrap.less");

?>
