<?php
session_start();

/*
 * Jump to teacher page
 */
$url = "http://localhost/SchoolOverSystem/teacher.php";
header("location:$url");

/*
 * Connect the database
 */
$mysqli_keep = new mysqli("localhost", "root", "", "school_over_system");
if (mysqli_connect_errno()) {
	printf("Connect failed %s\n", mysqli_connect_errno());
	exit();
}
$mysqli_keep->set_charset("utf8");

$STUDENT_GOHOME = $_POST['student_gohome'];
$update = "";

if (is_array($STUDENT_GOHOME)) {
	foreach($STUDENT_GOHOME as $value) {
		$update .= "update schoolover set status='2' where student_id="; 
		$update .= "$value" . ";";
	}
}

/*
 * Update schoolover data from GoHome to Keep
 */
if ($mysqli_keep->query($update))
	printf("Update schoolover table successfully\n");
else
	printf("%s failed to execute\n" ,$update);

$mysqli_keep->commit();
?>
