<?php 
$d = $_GET['d'];
if(!file_exists("log")) mkdir("log");
$logf = 'log/check.log';
$contents = date('Y/m/d H:i:s')." \t".$d." <br>\n";		
file_put_contents($logf, $contents, FILE_APPEND);
echo "distance: ".$d;
exit();
?>
