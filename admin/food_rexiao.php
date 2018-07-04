<?php
require '../include/init.php';
$list = $db->queryArray("select * from f_hot");

if(isset($_POST['sub']) && $_POST['sub'] == 'modify') {
//上传
	var_dump($_FILES);
	if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
		//echo "上传成功";
		$fileName = date("Y-m-d His") . '.jpg';
		if (!move_uploaded_file($_FILES['userfile']['tmp_name'], '../upload/' . date("Y-m-d His") . '.jpg')) {
			echo "移动失败";
		}
	}

	if (isset($fileName) && isset($_POST['id'])) {
		$res = $db->query("update f_hot set img='{$fileName}' where id={$_POST['id']}");
	}
}
?>
<!doctype html>
<html lang="zh_cn">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet"  type="text/css" href="css/admin.css">
	<script src="js/jquery.min.js"></script>
	<style type="text/css">
	.im{margin: 130px; border: 1px ;width: 450px;}
		.im td{width: 130px;height: 130px;text-align: center;}
		.im img{width: 90%;height: 90%;}
	</style>
	<title>Document</title>
</head>
<body>
<form action="" method="post" enctype="multipart/form-data">
	<table class="im">
		<?php  foreach($list as $k=>$v) { ?>
		<tr>
			<td>
				<img src="../upload/<?php echo $v['img'];?>" width="60" border="1">
				<input type="file" id="file" style="display:none" name="userfile" />
				<input type="hidden" value="<?php echo $v['id']; ?>" name="id">
				<input type="button" id="sub" value="更换" onclick="document.getElementById('file').click();" />
			</td>
		</tr>
		<?php } ?>
	</table>
	<p style="text-align:center"><button type="submit" name="sub" value="modify">修改</button></p>
</form>
</body>
</html>
