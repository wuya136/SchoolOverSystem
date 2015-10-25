<html>

	<head>
		<title>老师放学</title>
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
$mysqli_teacher = new mysqli("localhost", "root", "", "school_over_system");
if (mysqli_connect_errno()) {
	printf("Connect failed %s\n", mysqli_connect_errno());
	exit();
}
$mysqli_teacher->set_charset("utf8");
?>
		老师，你好！
	</h1>

	<body>

	<form name="classes" action="selectclass.php" method="post">
		班级：
		<select name="class">
<?php
$query = "select class_id,name from class";
if ($result = $mysqli_teacher->query($query)) {
	while ($obj = $result->fetch_object()) {
		$CLASS_ID = $obj->class_id;
		$CLASS_NAME = $obj->name;
		$htmlcode = "<option value='" . $CLASS_ID . "'";
		if (isset($_SESSION['class']) && $_SESSION['class'] == $CLASS_ID)
			$htmlcode .= " selected='selected'";
		$htmlcode .= ">" . $CLASS_NAME . "</option>";
		printf("%s\n", $htmlcode);
	}
}
?>
		</select>
		<input type="submit" value="选择班级"/>

	</form>
	<form name="time" action="gohome.php" method="post">
		计划放学时间：
<?php
/*
 * Students overschool
 */
$htmlcode = "<input type='text' name='overtime' value='";
if (isset($_SESSION['overtime']))
	$htmlcode .= $_SESSION['overtime'];
else
	$htmlcode .= date("Y-m-d H:i:s");
$htmlcode .= "'/>";
printf("%s\n", $htmlcode);
?>

		<input type="submit" value="放学"/>
	</form>

	</p>

	<fieldset>
		<legend>
			班级学生
		</legend>
		<form name="students_gohome" action="keep.php" method="post">
<?php
if (isset($_SESSION['class'])) {
	$start_time = substr($_SESSION['overtime'], 0, 10) . " 00:00:00";
	$end_time = substr($_SESSION['overtime'], 0, 10) . " 23:59:59";
	$query = "select student_id from schoolover where status=1 and overtime>'" . $start_time . "' and overtime<'" . $end_time . "' and class_id='" . $_SESSION['class'] . "';" ;
} else {
	$query = "";
}

if ($result = $mysqli_teacher->query($query)) {
	printf("<table>\n");
	$count = 0;
	while ($obj = $result->fetch_object()) {
		if ($count % 7 == 0)
			printf("<tr>\n");

		$STUDENT_ID = $obj->student_id;

		/*
		 * Query student info
		 */
		$query2 = "select name from student where student_id=" . $STUDENT_ID . ";";
		$result2 = $mysqli_teacher->query($query2);
		$obj2 = $result2->fetch_object();
		$STUDENT_NAME = $obj2->name;
		$result2->close();

		$htmlcode = "<td>";
		$htmlcode .= "<input type='checkbox' name='student_gohome[]' id='student_gohome' value='" . $STUDENT_ID . "'/>" . $STUDENT_NAME . "<br/>";
		$htmlcode .= "</td>";
		printf("%s\n", $htmlcode);

		if ($count % 7 == 6)
			printf("</tr>\n");
		$count++;

	}
	printf("</table>\n");
}
?>

			<br/>
			<input type="submit" value="暂留"/>
		</form>
	</fieldset>

	</p>

	<fieldset>
		<legend>
			暂留学生
		</legend>
		<form name="students_keeped" action="nokeep.php" method="post">
<?php
/*
 * Students keeped
 */
if (isset($_SESSION['class'])) {
	$start_time = substr($_SESSION['overtime'], 0, 10) . " 00:00:00";
	$end_time = substr($_SESSION['overtime'], 0, 10) . " 23:59:59";
	$query = "select student_id from schoolover where status=2 and overtime>'" . $start_time . "' and overtime<'" . $end_time . "' and class_id='" . $_SESSION['class'] . "';" ;
} else {
	$query = "";
}

if ($result = $mysqli_teacher->query($query)) {
	printf("<table>\n");
	$count = 0;
	while ($obj = $result->fetch_object()) {
		if ($count % 7 == 0)
			printf("<tr>\n");

		$STUDENT_ID = $obj->student_id;

		$query2 = "select name from student where student_id=" . $STUDENT_ID . ";";
		$result2 = $mysqli_teacher->query($query2);
		$obj2 = $result2->fetch_object();
		$STUDENT_NAME = $obj2->name;
		$result2->close();

		$htmlcode = "<td>";
		$htmlcode .= "<input type='checkbox' name='student_keeped[]' id='student_keeped' value='" . $STUDENT_ID . "'/>" . $STUDENT_NAME . "<br/>";
		$htmlcode .= "</td>";
		printf("%s\n", $htmlcode);

		if ($count % 7 == 6)
			printf("</tr>\n");
		$count++;

	}
	printf("</table>\n");
}

?>

			<br/>
			<input type="submit" value="放学"/>
		</form>
	</fieldset>

	</p>

	<fieldset>
		<legend>
			给家长的留言
		</legend>
		<form name="teacher_message" action="message.php" method="post">
<?php
$start_time = substr($_SESSION['overtime'], 0, 10) . " 00:00:00";
$end_time = substr($_SESSION['overtime'], 0, 10) . " 23:59:59";
$query = "select receiver_id from message where type='1' and author_id='" . $_SESSION['teacher_id'] . "' and createtime>'" . $start_time . "' and createtime<'" . $end_time . "';" ;

if ($result = $mysqli_teacher->query($query)) {
	if ($obj = $result->fetch_object()) {
		$PARENT_ID = $obj->receiver_id;
	}
}
$result->close();

$htmlcode = "<textarea rows='15' cols='80'>";
$query = "select content, createtime from message where type='1' and author_id='" . $_SESSION['teacher_id'] . "' and createtime>'" . $start_time . "' and createtime<'" . $end_time . " and receiver_id='" . $PARENT_ID . "';" ;
if ($result = $mysqli_teacher->query($query)) {
	while ($obj = $result->fetch_object()) {
		$message = $obj->content;
		$createtime = $obj->createtime;
		$htmlcode .= "我对所有家长说 " . $createtime . ":\n" . $message . "\n";
	}
}
$result->close();

$query = "select schoolover_id, content, createtime from message where type='2' and author_id='" . $_SESSION['teacher_id'] . "' and createtime>'" . $start_time . "' and createtime<'" . $end_time . "';" ;
if ($result = $mysqli_teacher->query($query)) {
	while ($obj = $result->fetch_object()) {
		$SCHOOLOVER_ID = $obj->schoolover_id;
		$message = $obj->content;
		$createtime = $obj->createtime;

		$query2 = "select student_id from schoolover where schoolover_id='" . $SCHOOLOVER_ID . "';";
		$result2 = $mysqli_teacher->query($query2);
		if ($obj2 = $result2->fetch_object()) {
			$STUDENT_ID = $obj2->student_id;

			$query3 = "select name from student where student_id='" . $STUDENT_ID . "';";
			$result3 = $mysqli_teacher->query($query3);
			if ($obj3 = $result3->fetch_object())
				$STUDENT_NAME = $obj3->name;
		}
		$htmlcode .= "我对" . $STUDENT_NAME . "家长说 " . $createtime . ":\n" . $message . "\n";
	}
}

$htmlcode .= "</textarea>";
printf("%s\n", $htmlcode);
?>
			</br>
			<input type="text" name="message_to_all"/>
			<input type="submit" value="发送"/>
			</br>

			给
			<select name="keeped_student">
<?php
if (isset($_SESSION['class'])) {
	$start_time = substr($_SESSION['overtime'], 0, 10) . " 00:00:00";
	$end_time = substr($_SESSION['overtime'], 0, 10) . " 23:59:59";
	$query = "select student_id from schoolover where status=2 and overtime>'" . $start_time . "' and overtime<'" . $end_time . "' and class_id='" . $_SESSION['class'] . "';" ;
} else
	$query = "";

	$htmlcode = "";
if ($result = $mysqli_teacher->query($query)) {
	while ($obj = $result->fetch_object()) {
		$STUDENT_ID = $obj->student_id;

		$query2 = "select name from student where student_id=" . $STUDENT_ID . ";";
		$result2 = $mysqli_teacher->query($query2);
		$obj2 = $result2->fetch_object();
		$STUDENT_NAME = $obj2->name;
		$result2->close();

		$htmlcode .= "<option value='" . $STUDENT_ID . "'>" . $STUDENT_NAME . "</option>";
	}
}
printf("%s\n", $htmlcode);
?>
			</select>
			家长的留言
			</br>
			<input type="text" name="message_to_parent"/>
			<input type="submit" value="发送"/>
		</form>
	</fieldset>

	</p>

	<fieldset>
		<legend>
			家长的回复
		</legend>
		<form name="parent_reply" action="teacher.php" method="post">
<?php
$htmlcode = "<textarea rows='15' cols='80'>";

$query = "select author_id, content, createtime from message where type='2' and receiver_id='" . $_SESSION['teacher_id'] . "' and createtime>'" . $start_time . "' and createtime<'" . $end_time . "';" ;
if ($result = $mysqli_teacher->query($query)) {
	while ($obj = $result->fetch_object()) {
		$PARENT_ID = $obj->author_id;
		$message = $obj->content;
		$createtime = $obj->createtime;

		$query2 = "select name from student where parent_id='" . $PARENT_ID . "';";
		$result2 = $mysqli_teacher->query($query2);
		if ($obj2 = $result2->fetch_object())
			$STUDENT_NAME = $obj2->name;

		$htmlcode .= $STUDENT_NAME . "家长对我说 " . $createtime . ":\n" . $message . "\n";
	}
}
$htmlcode .= "</textarea>";

printf("%s\n", $htmlcode);
?>
			<input type="submit" value="更新"/>
		</form>
	</fieldset>

	</body>

</html>
