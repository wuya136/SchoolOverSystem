<html>
	<head>
		<title>登陆</title>
	</head>

	<body>
		<?php
			echo "Hello PHP!";

			$link = mysql_connect("localhost", "root", "");
			if ($link)
				die("Could not connect:" . mysql_error());
			echo "Connected Successfully";
			mysql_close($link);
		?>
	</body>
</html>
