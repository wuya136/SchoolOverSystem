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

		<input type="submit" name="放学"/>
	</form>

	<fieldset>
		<legend>
			班级学生
		</legend>
		<form>
<?php
$CLASS_ID = 5;
$query = "select student_id, name from student where class_id='" . $CLASS_ID . "';";

if ($result = $mysqli->query($query)) {
	printf("<table>\n");
	$count = 0;
	while ($obj = $result->fetch_object()) {
		if ($count % 5 == 0)
			printf("<tr>\n");

		$STUDENT_ID = $obj->student_id;
		$STUDENT_NAME = $obj->name;
		$htmlcode = "<td>";
		$htmlcode .= "<input type='checkbox' name='student' value='" . $STUDENT_ID . "'/>" . $STUDENT_NAME . "<br/>";
		$htmlcode .= "</td>";
		printf("%s\n", $htmlcode);

		if ($count % 5 == 4)
			printf("</tr>\n");

	}
	printf("</table>\n");
}
?>
		</form>
	</fieldset>
	</body>

</html>