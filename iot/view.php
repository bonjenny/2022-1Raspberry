<!DOCTYPE html>
<html>
<head>
	<meta name="viewport"
	content="width=device-width, initial-scale=1.0" />
</head>
<body>
	<h2>Distance</h2>
	<pre>
<?php
	$logf = 'log/check.log';
	if (!file_exists($logf))
		echo "log is not exist";
	else
		echo file_get_contents($logf);
?>
	</pre>
</body>
</html>
