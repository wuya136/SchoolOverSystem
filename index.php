<html>
	<head>
		<title>登陆</title>
	</head>

	<body>
		<?php
			echo "Hello PHP!";

			$mysqli = new mysqli("localhost", "root", "", "school_over_system");
			if (mysqli_connect_errno()) {
				printf("Connect failed %s\n", mysqli_connect_errno());
				exit();
			}
			$mysqli->set_charset("utf8");

			$query = "select * from class";

			if ($result = $mysqli->query($query)) {
				while ($obj = $result->fetch_object()) {
					printf("ID: %s\n", $obj->class_id);
					printf("Name: %s\n", $obj->name);
				}
				$result->close();
			}

			$mysqli->close();
		?>
	</body>
</html>
