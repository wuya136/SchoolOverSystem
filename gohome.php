<?php

$CLASS_ID = $_POST['class'];
$OVERTIME = $_POST['overtime'];
$query = "select student_id from student where class_id='" . $CLASS_ID . "';";
$insert = "";

if ($result = $mysqli->query($query)) {
	while ($obj = $result->fetch_object()) {

		$STUDENT_ID = $obj->student_id;
		$insert .= "insert into schoolover (student_id, teacher_id, status, overtime) VALUES" . "($STUDENT_ID, $TEACHER_ID, 1, $OVERTIME)" . ";";
	}
}

/*
 * Insert schoolover data into database
 */
if ($mysqli->query($insert))
	printf("Update schoolover table successfully\n");
else
	printf("%s failed to execute\n" ,$insert);

?>
