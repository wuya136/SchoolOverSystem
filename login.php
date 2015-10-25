<?php

if (!isset($_SESSION))
	session_start();

/*
 * Connect the database
 */
$mysqli_login = new mysqli("localhost", "root", "", "school_over_system");
if (mysqli_connect_errno()) {
	printf("Connect failed %s\n", mysqli_connect_errno());
	exit();
}
$mysqli_login->set_charset("utf8");

/*
 * Discriminate the login role
 */
if (strcmp($_POST["role"], "teacher") == 0) {
	$ROLE_TABLE_NAME = "teacher";
	$_SESSION['role'] = "teacher";
} else {
	$ROLE_TABLE_NAME = "parent";
	$_SESSION['role'] = "parent";
}

/*
 * Create sql query statement
 */
$COLUMS = " " . $ROLE_TABLE_NAME . "_id, name, password";
$WHRE_CLAUS = " where name='" . $_POST["name"] . "' and " . "password='" . $_POST["password"] . "'";

$query = "select" . $COLUMS . " from " . $ROLE_TABLE_NAME . $WHRE_CLAUS . ";";

/*
 * Authenticate the login and jump to the right action page
 */
if ($result = $mysqli_login->query($query)) {
	if ($result->num_rows > 0) {
		$obj = $result->fetch_object();
		if (strcmp($_POST["role"], "teacher") == 0) {
			$TEACHER_ID = $obj->teacher_id;
			$TEACHER_NAME = $obj->name;
			$_SESSION['teacher_id'] = $TEACHER_ID;
			$_SESSION['loginname'] = $TEACHER_NAME;
			include "teacher.php";
		} else {
			$PARENT_ID = $obj->parent_id;
			$PARENT_NAME = $obj->name;
			$_SESSION['parent_id'] = $PARENT_ID;
			$_SESSION['loginname'] = $PARENT_NAME;
			include "parent.php";
		}
	} else {
		printf("您输入的用户名或密码错误，请重新输入\n");
		sleep(1);
		include "index.php";
	}

}

$result->close();
$mysqli_login->close();
?>
