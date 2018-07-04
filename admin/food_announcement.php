<?php
	require '../include/init.php';
	if(isset($_POST['announce'])){
		$res = $db->query("insert into f_announce(content) values('".$_POST['announce']."')");
		if($res){
			echo "<script>alert('发布成功~');window.location.reload(true)</script>";
		}else{
			echo "<script>alert('发布失败~');histroy.go(-1);</script>";
		}
	}
?>
<!doctype html>
<html lang="zh_cn">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet"  type="text/css" href="css/admin.css">
	<script src="js/jquery.min.js"></script>	
	<title>Document</title>
	<style type="text/css">
	.announ{margin-top: 60px;margin-left: 40px;}
	.announ li{line-height: 34px;}
	</style>
</head>
<body>
	<form action="" method="post">
		<ul class="announ">
			<li>公告内容:<font>####</font></li>
			<li><input type="text" placeholder="请输入公告" name="announce"></li>
			<li><input type="submit" value="发布"></li>
		</ul>
	</form>
</body>
</html>