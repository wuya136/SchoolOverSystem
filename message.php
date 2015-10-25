<?php

date_default_timezone_set("Asia/Shanghai");

if (!isset($_SESSION))
	session_start();

/*
 * Jump to teacher page
 */
if (strcmp($_SESSION['role'], "teacher") == 0)
	$url = "http://localhost/SchoolOverSystem/teacher.php";
else
	$url = "http://localhost/SchoolOverSystem/parent.php";
header("location:$url");

/*
 * Connect the database
 */
$mysqli_message = new mysqli("localhost", "root", "", "school_over_system");
if (mysqli_connect_errno()) {
	printf("Connect failed %s\n", mysqli_connect_errno());
	exit();
}
$mysqli_message->set_charset("utf8");

/*
 * Discriminate the message direction
 */
if (isset($_POST['message_to_all']) && $_POST['message_to_all'] != NULL) {
	$message = $_POST['message_to_all'];
	$message_type = 1;
	$author_type = 1;
	$author_id = $_SESSION['teacher_id'];
	$createtime = date("Y-m-d H:i:s");

	$query1 = "select student_id, parent_id from student where class_id='" . $_SESSION['class'] . "';";
	if ($result1 = $mysqli_message->query($query1)) {
		while ($obj1 = $result1->fetch_object()) {
			$STUDENT_ID = $obj1->student_id;
			$PARENT_ID = $obj1->parent_id;

			$start_time = substr($_SESSION['overtime'], 0, 10) . " 00:00:00";
			$end_time = substr($_SESSION['overtime'], 0, 10) . " 23:59:59";
			$query2 = "select schoolover_id from schoolover where student_id='" . $STUDENT_ID . "' and overtime>'" . $start_time . "' and overtime<'" . $end_time . "';" ;
			$result2 = $mysqli_message->query($query2);
			$obj2 = $result2->fetch_object();
			$SCHOOLOVER_ID = $obj2->schoolover_id;

			$insert = "insert into message (schoolover_id, author_type, author_id, receiver_id, content, type, createtime) VALUES" . "($SCHOOLOVER_ID, $author_type, $author_id, $PARENT_ID, \"$message\", $message_type, \"$createtime\");";
			/*
			 * Insert message into database
			 */
			if ($mysqli_message->query($insert))
				printf("Update message table successfully\n");
			else
				printf("%s failed to execute\n" ,$insert);
		}
	}
} else if (isset($_POST['message_to_parent']) && $_POST['message_to_parent'] != NULL) {
	$message = $_POST['message_to_parent'];
	$message_type = 2;
	$author_type = 1;
	$author_id = $_SESSION['teacher_id'];
	$createtime = date("Y-m-d H:i:s");
	$STUDENT_ID = $_POST['keeped_student'];

	$start_time = substr($_SESSION['overtime'], 0, 10) . " 00:00:00";
	$end_time = substr($_SESSION['overtime'], 0, 10) . " 23:59:59";
	$query = "select schoolover_id from schoolover where student_id='" . $STUDENT_ID . "' and overtime>'" . $start_time . "' and overtime<'" . $end_time . "';" ;
	$result = $mysqli_message->query($query);
	$obj = $result->fetch_object();
	$SCHOOLOVER_ID = $obj->schoolover_id;

	$query = "select parent_id from student where student_id='" . $STUDENT_ID . "';";
	$result = $mysqli_message->query($query);
	$obj = $result->fetch_object();
	$PARENT_ID = $obj->parent_id;

	$insert = "insert into message (schoolover_id, author_type, author_id, receiver_id, content, type, createtime) VALUES" . "($SCHOOLOVER_ID, $author_type, $author_id, $PARENT_ID, \"$message\", $message_type, \"$createtime\");";
	/*
	 * Insert message into database
	 */
	if ($mysqli_message->query($insert))
		printf("Update message table successfully\n");
	else
		printf("%s failed to execute\n" ,$insert);
} else if (isset($_POST['message_to_teacher']) && $_POST['message_to_teacher'] != NULL) {
	$message = $_POST['message_to_teacher'];
	$message_type = 2;
	$author_type = 2;
	$author_id = $_SESSION['parent_id'];
	$createtime = date("Y-m-d H:i:s");

	$query = "select student_id from student where parent_id='" . $author_id . "';";
	$result = $mysqli_message->query($query);
	$obj = $result->fetch_object();
	$STUDENT_ID = $obj->student_id;

	$start_time = substr(date("Y-m-d H:i:s"), 0, 10) . " 00:00:00";
	$end_time = substr(date("Y-m-d H:i:s"), 0, 10) . " 23:59:59";
	$query = "select schoolover_id, teacher_id from schoolover where student_id='" . $STUDENT_ID . "' and overtime>'" . $start_time . "' and overtime<'" . $end_time . "';" ;
	$result = $mysqli_message->query($query);
	$obj = $result->fetch_object();
	$SCHOOLOVER_ID = $obj->schoolover_id;
	$TEACHER_ID = $obj->teacher_id;

	$insert = "insert into message (schoolover_id, author_type, author_id, receiver_id, content, type, createtime) VALUES" . "($SCHOOLOVER_ID, $author_type, $author_id, $TEACHER_ID, \"$message\", $message_type, \"$createtime\");";
	/*
	 * Insert message into database
	 */
	if ($mysqli_message->query($insert))
		printf("Update message table successfully\n");
	else
		printf("%s failed to execute\n" ,$insert);
}


$mysqli_message->commit();
?>
