<?php

/*
 * Connect the database
 */
$mysqli = $_SESSION['mysqli'];

$STUDENT_GOHOME = $_POST['student_gohome'];
$update = "";

if (is_array($STUDENT_GOHOME)) {
	foreach($STUDENT_GOHOME as $value) {
		$update .= "update schoolover set status='2' where student_id="; 
		$update .= "$value" . ";";
}

/*
 * Update schoolover data from GoHome to Keep
 */
if ($mysqli->query($update))
	printf("Update schoolover table successfully\n");
else
	printf("%s failed to execute\n" ,$update);

?>
