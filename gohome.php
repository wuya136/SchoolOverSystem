<?php
if (!isset($_SESSION))
	session_start();

$url = "http://localhost/SchoolOverSystem/teacher.php";
header("location:$url");

/*
 * Connect the database
 */
$mysqli_gohome = new mysqli("localhost", "root", "", "school_over_system");
if (mysqli_connect_errno()) {
	printf("Connect failed %s\n", mysqli_connect_errno());
	exit();
}
$mysqli_gohome->set_charset("utf8");

$CLASS_ID = $_SESSION['class'];
$OVERTIME = $_POST['overtime'];
$_SESSION['overtime'] = $OVERTIME;
$TEACHER_ID = $_SESSION['teacher_id'];
$query = "select student_id from student where class_id='" . $CLASS_ID . "';";
$insert = "";

if ($result = $mysqli_gohome->query($query)) {
	while ($obj = $result->fetch_object()) {

		$STUDENT_ID = $obj->student_id;
		$insert = "insert into schoolover (student_id, class_id, teacher_id, status, overtime) VALUES" . "($STUDENT_ID, $CLASS_ID, $TEACHER_ID, 1," .  "\"$OVERTIME\"" . ");";

		/*
		 * Insert schoolover data into database
		 */
		if ($mysqli_gohome->query($insert))
			printf("Update schoolover table successfully\n");
		else
			printf("%s failed to execute\n" ,$insert);
	}
}
$result->close();

$mysqli_gohome->commit();

?>
