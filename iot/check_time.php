<?php
$time = time();
$distance = $_GET['distance'];
if (!file_exists("log")) mkdir("log");
$logf = 'log/check_time.log';
$contents = $time."=>".$distance.", ";
file_put_contents($logf, $contents, FILE_APPEND);
error_log($contents);
echo "Usonic:".$distance;
exit();
?>
