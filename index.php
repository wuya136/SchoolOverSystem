<html>
	<head>
		<title>登陆</title>
	<h1>
		数字化校园智能放学系统
	</h1>
	</head>

	<body>
		<form name="login" action="login.php" method="post">
			学校：
			<select name="school">
				<option value="diaozhuang">常州市雕庄中心小学</option>
				<option value="hongjing">常州市虹景小学</option>
				<option value="boailu">常州市博爱路小学</option>
				<option value="jiefanglu">常州市解放路小学</option>
				<option value="juqianjie">常州市局前街小学</option>
				<option value="qingliang">常州市清凉小学</option>
				<option value="beihuanlu">常州市北环路小学</option>
				<option value="dierxincun">常州市第二新村小学</option>
				<option value="disanxincun">常州市第三新村小学</option>
				<option value="chaoyangqiao">常州市朝阳桥小学</option>
				<option value="chaoyangxincun">常州市朝阳新村小学</option>
				<option value="beijiao">常州市北郊小学</option>
			</select>
			<br/>
			姓名：
			<input type="text" name="name"/>
			<br/>
			密码：
			<input type="password" name="password"/>
			<br/>
			<input type="radio" name="role" value="teacher"/>老师
			<input type="radio" name="role" value="parent"/>家长
			<br/>
			<input type="submit" value="登陆"/>
		</form>
	</body>
</html>
