<?php
if (!isset($_SESSION))
	session_start();

$url = "http://localhost/SchoolOverSystem/teacher.php";
header("location:$url");

$CLASS_ID = $_POST['class'];
$_SESSION['class'] = $CLASS_ID;

?>
