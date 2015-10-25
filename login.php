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
	$_SESSION['role'] = "teacher";
} else {
	$_SESSION['role'] = "parent";
}

/*
 * Create sql query statement
 */
$COLUMS = " " . "login_id, name, password, role";
$WHRE_CLAUS = " where name='" . $_POST["name"] . "' and " . "password='" . $_POST["password"] . "'";

$query = "select" . $COLUMS . " from logins" . $WHRE_CLAUS . ";";

/*
 * Authenticate the login and jump to the right action page
 */
if ($result = $mysqli_login->query($query)) {
	if ($result->num_rows > 0) {
		$obj = $result->fetch_object();
		if ($obj->role == 2) {
			$_SESSION['teacher_id'] = $obj->login_id;
			$_SESSION['loginname'] = $obj->name;
			include "teacher.php";
		} else if ($obj->role == 1) {
			$_SESSION['parent_id'] = $obj->login_id;
			$_SESSION['loginname'] = $obj->name;
			include "parent.php";
		} else {
			printf("您输入的用户名或密码错误，请重新输入\n");
			sleep(1);
			include "index.php";
		}

	} else {
		printf("您输入的用户名或密码错误，请重新输入\n");
		sleep(1);
		include "index.php";
	}

}

$mysqli_login->close();
?>
