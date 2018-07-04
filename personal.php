<?php
require 'include/init.php';
if(!$_SESSION['userName']){
	echo "<script>alert('请登录~');top.location.href='login.php';</script>";
}
	//修改密码
$list = $db->queryOne("select * from f_member where name='{$_SESSION['userName']}'");
if(isset($_GET['action']) && $_GET['action']=='pwd'){
	$pwd = sha1($_POST['pwd']);
	$res = $db->query("update f_member set password='{$pwd}' where name='{$_SESSION['userName']}'");
	echo json_encode($res);
	exit;
}
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>personal center</title>
	<script src="image/jquery.js"></script>
	<link rel="stylesheet" type="text/css" href="css/base.css">
	<link rel="stylesheet" type="text/css" href="css/block.css">
	<script src="js/jquery.min.js"></script>
</head>
<body>
	<div class="conPersonal">
		<div class="conLeft">
			<img src="images/avatar.png"><br>
			<a href="javascript:void(0);" id="changePwd">修改密码</a>
			<div class="pwd" style="display: none">
				输入新密码：<input type="password" id="password" value="<?php echo $list['password'];?>" style="width:80px;"><br>
				<button id="sub">修改</button>
			</div>
		</div>			
		<table class="conright">
			<tr>
				<td>用户名：</td>
				<td><?php echo $list['name']; ?></td>
			</tr>
			<tr>
				<td>性别：</td>
				<td><?php if($list['name'] == 1) echo '男';else echo '女'; ?></td>
			</tr>
			<tr>
				<td>联系电话：</td>
				<td><?php echo $list['phone']; ?></td>
			</tr>
			<tr>
				<td>有效邮箱：</td>
				<td><?php echo $list['email']; ?></td>
			</tr>
		</table>	
	</div>
	<script>
		$(function(){
			$('#changePwd').click(function(){
				$('.pwd').toggle();
				$('#sub').live('click',function(){
					var pwd = $('#password').val();
					$.ajax({
						type:'POST',
						url:'personal.php?action=pwd',
						data:{'pwd':pwd},
						cache:false,
						dataType:'json',
						success:function(res){
							alert('修改成功~');
							$('.pwd').hide();
						}
					});
				});
			});
		});
	</script>
</body>
</html>