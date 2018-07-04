<?php
require 'include/init.php';
if(isset($_POST['sub']) && $_POST['sub'] == 'reg'){
	if($_POST['userName'] && $_POST['pwd'] && $_POST['rePwd'] && $_POST['email']){
		$pwd = sha1($_POST['pwd']);
		$res = $db->query("insert into f_member(name,password,sex,phone,email) values('{$_POST['userName']}','{$pwd}','{$_POST['sex']}','{$_POST['phone']}','{$_POST['email']}')");
		if($res){
			echo "<script>alert('注册成功~');location.href='index.php'</script>";
			exit;
		}else{
			echo "<script>alert('注册有误哦~');location.href='register.php'</script>";
			exit;
		}
	}
}
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>The menu</title>
	<link rel="stylesheet" type="text/css" href="css/base.css">
	<link rel="stylesheet" type="text/css" href="css/block.css">
</head>
<body>
<form action="" method="post">
	<div class="layoutOther">
		<p> 用 户 注 册 </p>
		<table class="conMenu">
			<tr>
				<td>用户名：</td>
				<td><input  type='text' placeholder="请输入昵称" name="userName"></td>
			</tr>
			<tr>
				<td><input type="radio" name="sex" value="1">男</td>
				<td><input type="radio" name="sex" value="0">女</td>
			</tr>
			<tr>
				<td>密码：</td>
				<td><input  type="password" placeholder="请输入密码" name="pwd"></td>
			</tr>
			<tr>
				<td>确认密码：</td>
				<td><input type="password" placeholder="请再次确认密码" name="rePwd"></td>
			</tr>
			<tr>
				<td>联系电话：</td>
				<td><input type='text' placeholder="请输入有效电话" name="phone"></td>
			</tr>
			<tr>
				<td>有效邮箱：</td>
				<td><input type='text' placeholder="请输入有效邮箱" name="email"></td>
			</tr>
			<tr>
				<td></td>
				<td><button value="reg" name="sub"> 提 交 </button></td>
			</tr>
		</table>
		<a class="back_home" onclick="top.location='index.php'">返回首页</a>
	</div>
	</form>
</body>
</html>