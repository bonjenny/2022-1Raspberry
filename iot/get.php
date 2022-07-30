<?php
	if( $_GET["name"] || $_GET["age"] ) {
		echo ("Welcome ".$_GET['name']."<br />");
		echo ("You are ".$_GET['age']." years old.");
		exit();
	}
?>
<html>
	<body>
		<form action="<?=$_SERVER["PHP_SELF"]?>"
			  method="GET">
			Name: <input type="text" name="name" /><br />
			Age: <input type="text" name="age" /><br />
			<input type="submit" />
		</form>
	</body>
</html>
