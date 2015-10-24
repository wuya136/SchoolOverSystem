<?php

/*
 * Connect the database
 */
$mysqli = new mysqli("localhost", "root", "", "school_over_system");
if (mysqli_connect_errno()) {
	printf("Connect failed %s\n", mysqli_connect_errno());
	exit();
}
$mysqli->set_charset("utf8");

/*
 * Discriminate the login role
 */
if (strcmp($_POST["role"], "teacher") == 0)
	$ROLE_TABLE_NAME = "teacher";
else
	$ROLE_TABLE_NAME = "parent";


$COLUMS = " " . $ROLE_TABLE_NAME . "_id, name, password";
$WHRE_CLAUS = " where name='" . $_POST["name"] . "' and " . "password='" . $_POST["password"] . "'";

$query = "select" . $COLUMS . " from " . $ROLE_TABLE_NAME . $WHRE_CLAUS . ";";

if ($result = $mysqli->query($query)) {
	if ($result->num_rows > 0) {
		while ($obj = $result->fetch_object()) {
			//printf("ID: %s\n", $obj->class_id);
			printf("Name: %s\n", $obj->name);
		}
	} else {
		$result->close();

		printf("您输入的用户名或密码错误，请重新输入\n");
		sleep(2);
		include index.php
	}
	$result->close();

}

$mysqli->close();
?>
