<?php
	if( $_POST["name"] || $_POST["age"] ) {
		echo ("Welcome ".$_POST['name']."<br />");
		echo ("You are ".$_POST['age']." years old.");
		exit();
	}
?>
<html>
	<body>
		<div>
			Name: <input id="name" type="text" /><br />
			Age: <input id="age" type="text" /><br />
			<input type="button" value="submit" 
				   onclick="ajax();" />
		</div>
		<div id="result" style="color:red"></div>
	</body>
	<script>
		var ajax = function() {
			var data = new FormData();
			data.append('name',
					document.getElementById('name').value);
			data.append('age',
					document.getElementById('age').value);
			var request = new XMLHttpRequest();
			request.onreadystatechange = function() {
				if(request.readyState == 4) {
					try {
						var resp = request.response
					} catch(e) {
						var resp = 'error:Unknown error occurred'
					}
					document.getElementById('result').innerHTML = resp
				}
			};
			request.open('POST', "<?=$_SERVER["PHP_SELF"]?>");
			request.send(data);
		}
	</script>
</html>
