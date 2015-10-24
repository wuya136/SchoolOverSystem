<html>

	<head>
		<title>老师放学</title>
	</head>
	<h1>
<?php
printf("%s\n", $TEACHER_NAME);
?>
		老师，你好！
	</h1>

	<body>

	<form name="students" action="teacher.php" method="post">
		班级：
		<select name="class">
<?php
$query = "select name from class";
if ($result = $mysqli->query($query)) {
	while ($obj = $result->fetch_object()) {
		$CLASS_ID = $obj->class_id;
		$CLASS_NAME = $obj->name;
		$htmlcode = "<option value='" . $CLASS_ID . "'>" . $CLASS_NAME . "</option>";
		printf("%s\n", $htmlcode);
	}
}
?>
		</select>

		计划放学时间：
		<input type="text" name="time" value="2015.10.24 17:44:34"/>

	</form>
<?php

?>
	</body>

</html>
