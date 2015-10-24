<?php
session_start();

if (strcmp($_SESSION['role'], "teacher"))
	$url = "http://localhost/SchoolOverSystem/teacher.php";
else
	$url = "http://localhost/SchoolOverSystem/parent.php";

header("location:$url");

/*
 * Connect the database
 */
$mysqli = new mysqli("localhost", "root", "", "school_over_system");
if (mysqli_connect_errno()) {
	printf("Connect failed %s\n", mysqli_connect_errno());
	exit();
}
$mysqli->set_charset("utf8");

$CLASS_ID = $_POST['class'];
$OVERTIME = $_POST['overtime'];
$TEACHER_ID = $_SESSION['teacher_id'];
$query = "select student_id from student where class_id='" . $CLASS_ID . "';";
$insert = "";

if ($result = $mysqli->query($query)) {
	while ($obj = $result->fetch_object()) {

		$STUDENT_ID = $obj->student_id;
		$insert = "insert into schoolover (student_id, teacher_id, status, overtime) VALUES" . "($STUDENT_ID, $TEACHER_ID, 1," .  "\"$OVERTIME\"" . ");";

		/*
		 * Insert schoolover data into database
		 */
		if ($mysqli->query($insert))
			printf("Update schoolover table successfully\n");
		else
			printf("%s failed to execute\n" ,$insert);
	}
}
$result->close();

$mysqli->commit();

?>
