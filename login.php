<?php
	require 'include/init.php';

	if(isset($_POST['sub'])){
		if($_SESSION['code'] != $_POST['code']){
			echo "<script>alert('验证码错误~');location.href='login.php'</script>";
			exit;
		}
		if(isset($_POST['userName'])&& isset($_POST['pwd'])){
			$pwd = sha1($_POST['pwd']);
			$res = $db->queryOne("select name from f_member where name='{$_POST['userName']}' and password='{$pwd}'");
			if($res){
				$_SESSION['userName'] = $_POST['userName'];
				header('location:index.php');
			}else{
				echo "<script>alert('登录失败,请重新登陆~');location.href='login.php'</script>";
				exit;
			}
		}else{
			echo "<script>alert('登录失败,请重新登陆~');location.href='login.php'</script>";
			exit;
		}
	}
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>theme restaurant</title>
	<link rel="stylesheet" type="text/css" href="css/base.css">
	<link rel="stylesheet" type="text/css" href="css/block.css">
	<script src="js/jquery.min.js"></script>
</head>
<body>
<form action="" method="post">
		<p><?php if(isset($_GET['act']) && $_GET['act'] == 'waiter') echo '服务员登录';else echo '用户登录';?></p>
			<table class="signIn">
				<tr>
					<td><img src="images/user.png"></td>
					<td>用户账号：<input type="text" placeholder="请输入用户名" name="userName"></td>
				</tr>
				<tr>
					<td><img src="images/password.png"></td>
					<td>用户密码：<input type="password" placeholder="请输入密码" name="pwd"></td>
				</tr>
				<tr>
					<td><img src="images/checkCode.png"></td>
					<td >验 证 码：<input type="text" style="width:80px;" name="code"><img src="include/code.php" style="width:80px;height:30px; cursor: pointer" id="code"></td>
				</tr>
				<tr>
					<td colspan="3"><input class="button" type="submit" value="登录" name="sub"><input class="button" type="reset" value="重置"></td>
				</tr>
				<tr>
					<td colspan="3"><a href="register.php">注册新用户</a></td>
				</tr>
			</table>
	</form>
<script>
	$(function(){
		$('#code').click(function(){
			this.src = "include/code.php?yzm="+Math.random();
		})
	});
</script>
</body>
</html>