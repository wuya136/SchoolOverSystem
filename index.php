<html>
	<head>
		<title>登陆</title>
	</head>

	<body>
		<?php
			echo "Hello PHP!";

			$mysqli = new mysqli("localhost", "root", "", "SchoolOverSystem");
			if (mysqli_connect_errno()) {
				printf("Connect failed %s\n", mysqli_connect_errno());
				exit();
			}

			$query = "select * from class";

			if ($result = $mysqli->query($query)) {
				while ($finfo = $result->fetch_field()) {
					$currentfield = $result->currentfield;

					printf("Column: %d\n", $currentfield);
					printf("ID: %d\n", $finfo->class_id);
					printf("Name: %s\n", $finfo->name);
				}
				$result->close();
			}

			$mysqli->close();
		?>
	</body>
</html>
