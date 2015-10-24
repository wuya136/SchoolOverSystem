<html>
	<head>
		<title>登陆</title>
	<h1>
		数字化校园智能放学系统
	</h1>
	</head>

	<body>
		<?php
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

		<form name="login" action="login.php" method="post">
			学校：
			<select name="school">
				<option value="diaozhuang">常州雕庄中心小学</option>
			</select>
			<br/>
			姓名：
			<input type="text" name="name"/>
			<br/>
			密码：
			<input type="text" name="password"/>
			<br/>
			<input type="radio" name="role" value="teacher"/>老师
			<input type="radio" name="role" value="parent"/>家长
			<br/>
			<input type="submit" value="登陆"/>
		</form>
	</body>
</html>
