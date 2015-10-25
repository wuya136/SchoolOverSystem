<html>

	<head>
		<title>老师放学</title>
	</head>
	<h1>
<?php
session_start();

printf("%s\n", $_SESSION['loginname']);

/*
 * Connect the database
 */
$mysqli_teacher = new mysqli("localhost", "root", "", "school_over_system");
if (mysqli_connect_errno()) {
	printf("Connect failed %s\n", mysqli_connect_errno());
	exit();
}
$mysqli_teacher->set_charset("utf8");
?>
		老师，你好！
	</h1>

	<body>

	<form name="classes" action="gohome.php" method="post">
		班级：
		<select name="class">
<?php
$query = "select class_id,name from class";
if ($result = $mysqli_teacher->query($query)) {
	while ($obj = $result->fetch_object()) {
		$CLASS_ID = $obj->class_id;
		$CLASS_NAME = $obj->name;
		$htmlcode = "<option value='" . $CLASS_ID . "'";
		if (isset($_SESSION['class']) && $_SESSION['class'] == $CLASS_ID)
			$htmlcode .= " selected='selected'";
		$htmlcode .= ">" . $CLASS_NAME . "</option>";
		printf("%s\n", $htmlcode);
	}
}
?>
		</select>

		计划放学时间：
		<input type="text" name="overtime" value="2015.10.24 17:44:34"/>

		<input type="submit" value="放学"/>
	</form>

	<fieldset>
		<legend>
			班级学生
		</legend>
		<form name="students_gohome" action="keep.php" method="post">
<?php
$query = "select student_id from schoolover where status=1 and overtime>'2015-10-24 00:00:00' and overtime <'2015-10-24 23:59:59' and class_id='" . $CLASS_ID . "';" ;

if ($result = $mysqli_teacher->query($query)) {
	printf("<table>\n");
	$count = 0;
	while ($obj = $result->fetch_object()) {
		if ($count % 7 == 0)
			printf("<tr>\n");

		$STUDENT_ID = $obj->student_id;

		/*
		 * Query student info
		 */
		$query2 = "select name from student where student_id=" . $STUDENT_ID . ";";
		$result2 = $mysqli_teacher->query($query2);
		$obj2 = $result2->fetch_object();
		$STUDENT_NAME = $obj2->name;
		$result2->close();

		$htmlcode = "<td>";
		$htmlcode .= "<input type='checkbox' name='student_gohome[]' id='student_gohome' value='" . $STUDENT_ID . "'/>" . $STUDENT_NAME . "<br/>";
		$htmlcode .= "</td>";
		printf("%s\n", $htmlcode);

		if ($count % 7 == 6)
			printf("</tr>\n");
		$count++;

	}
	printf("</table>\n");
}
?>

			<br/>
			<input type="submit" value="暂留"/>
		</form>
	</fieldset>

	<fieldset>
		<legend>
			暂留学生
		</legend>
		<form name="students_keeped" action="nokeep.php" method="post">
<?php
$query = "select student_id from schoolover where status=2 and overtime>'2015-10-24 00:00:00' and overtime <'2015-10-24 23:59:59' and class_id='" . $CLASS_ID . "';";

if ($result = $mysqli_teacher->query($query)) {
	printf("<table>\n");
	$count = 0;
	while ($obj = $result->fetch_object()) {
		if ($count % 7 == 0)
			printf("<tr>\n");

		$STUDENT_ID = $obj->student_id;

		$query2 = "select name from student where student_id=" . $STUDENT_ID . ";";
		$result2 = $mysqli_teacher->query($query2);
		$obj2 = $result2->fetch_object();
		$STUDENT_NAME = $obj2->name;
		$result2->close();

		$htmlcode = "<td>";
		$htmlcode .= "<input type='checkbox' name='student_keeped[]' id='student_keeped' value='" . $STUDENT_ID . "'/>" . $STUDENT_NAME . "<br/>";
		$htmlcode .= "</td>";
		printf("%s\n", $htmlcode);

		if ($count % 7 == 6)
			printf("</tr>\n");
		$count++;

	}
	printf("</table>\n");
}

$mysqli_teacher->close();
?>

			<br/>
			<input type="submit" value="放学"/>
		</form>
	</body>

</html>
