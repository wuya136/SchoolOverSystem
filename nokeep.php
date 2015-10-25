<?php
if (!isset($_SESSION))
	session_start();

/*
 * Jump to teacher page
 */
$url = "http://localhost/SchoolOverSystem/teacher.php";
header("location:$url");

/*
 * Connect the database
 */
$mysqli_nokeep = new mysqli("localhost", "root", "", "school_over_system");
if (mysqli_connect_errno()) {
	printf("Connect failed %s\n", mysqli_connect_errno());
	exit();
}
$mysqli_nokeep->set_charset("utf8");

$STUDENT_KEEPED = array_values($_POST['student_keeped']);

if (is_array($STUDENT_KEEPED)) {
	foreach($STUDENT_KEEPED as $value) {
		$update = "update schoolover set status='1' where student_id=";
		$update .= "$value" . ";";

		/*
		 * Update schoolover data from Keep to GoHome
		 */
		if ($mysqli_nokeep->query($update))
			printf("Update schoolover table successfully\n");
		else
			printf("%s failed to execute\n" ,$update);
	}
}

$mysqli_nokeep->commit();
?>
