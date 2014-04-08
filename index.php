<!DOCTYPE html>
<html>
	<head>
		<title>Hello World</title>
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
	</head>

	<body>
		<div id="hello_world_div">
			<?php
				$message = "Hello world!!";
				$tag = "h1";
				echo "<".$tag.">".$message."</".$tag.">";
                echo "HELLO";
			?>
		</div>
	</body>
</html>
