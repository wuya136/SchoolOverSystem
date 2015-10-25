<html>

	<head>
		<title>家长接小孩</title>
	</head>
	<h1>
<?php

if (!isset($_SESSION))
		session_start();

date_default_timezone_set("Asia/Shanghai");

printf("%s\n", $_SESSION['loginname']);

/*
 * Connect the database
 */
$mysqli_parent = new mysqli("localhost", "root", "", "school_over_system");
if (mysqli_connect_errno()) {
	printf("Connect failed %s\n", mysqli_connect_errno());
	exit();
}
$mysqli_parent->set_charset("utf8");
?>
		家长，你好！
	</h1>

	<body>
<?php
$PARENT_ID = $_SESSION['parent_id'];

$htmlcode = "<h3>您孩子的班级：";
$query = "select student_id, class_id from student where parent_id='" . $PARENT_ID . "';";
if ($result = $mysqli_parent->query($query)) {
	if ($obj = $result->fetch_object()) {
		$STUDENT_ID = $obj->student_id;
		$CLASS_ID = $obj->class_id;

		$query2 = "select name from class where class_id='" . $CLASS_ID . "';";
		$result2 = $mysqli_parent->query($query2);
		$obj2 = $result2->fetch_object();
		$CLASS_NAME = $obj2->name;
		$htmlcode .= $CLASS_NAME;
	}

	$result->close();
}
$htmlcode .= "</h3>";
printf("%s\n", $htmlcode);

$htmlcode = "<h3>预计放学时间：";
$start_time = substr(date("Y-m-d H:i:s"), 0, 10) . " 00:00:00";
$end_time = substr(date("Y-m-d H:i:s"), 0, 10) . " 23:59:59";
$query = "select teacher_id, status, overtime from schoolover where overtime>'" . $start_time . "' and overtime<'" . $end_time . "' and student_id='" . $STUDENT_ID . "';" ;
if ($result = $mysqli_parent->query($query)) {
	if ($obj = $result->fetch_object()) {
		$STATUS = $obj->status;
		$OVERTIME = $obj->overtime;
		$TEACHER_ID = $obj->teacher_id;
		$htmlcode .= $OVERTIME;
	}

	$result->close();
}
$htmlcode .= "</h3>";
printf("%s\n", $htmlcode);

$htmlcode = "<h3>您孩子的放学情况：";
$STATUS = -1;

if ($STATUS == 1)
	$htmlcode .= "已放学";
else if ($STATUS == 2) {
	$query = "select name from logins where login_id='" . $TEACHER_ID . "';";
	$result = $mysqli_parent->query($query);
	$obj = $result->fetch_object();
	$TEACHER_NAME = $obj->name;

	$htmlcode .= "被" . $TEACHER_NAME . "老师暂留";
}
else
	$htmlcode .= "还未放学";

$htmlcode .= "</h3>";
printf("%s\n", $htmlcode);
?>


	</body>
</html>
