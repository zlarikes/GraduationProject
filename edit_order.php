<?php 
require "include/init.php";
if(isset($_GET['act']) && $_GET['act']=='modify'){
	$res = $db->query("update f_trade set table_num={$_POST['table_num']} where id={$_POST['id']}");

	if($res){
		echo "<script>alert('修改成功~');window.location.href='waiter.php';</script>";
	}
}
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>personal center</title>
	<script src="image/jquery.js"></script>
	<link rel="stylesheet" type="text/css" href="css/base.css">
	<link rel="stylesheet" type="text/css" href="css/block.css">
	<link rel="stylesheet" type="text/css" href="css/page.css">
	<script src="js/jquery.min.js"></script>
</head>
<body>
	<table class="sh">
		<form action="?act=modify" method="post">
			<table>
				<tr>
					桌号: <input type="text" name="table_num" value='<?php echo $_GET['table']?>'><br>
				</tr>
				<tr>
					订餐人: <input type="text" name="user_name" readonly="readonly" value="<?php echo $_GET['name']?>"><br>
				</tr>
				<tr>
					订单号: <input type="text" name="order" readonly="readonly" value="<?php echo $_GET['bookNum']?>"><br>
				</tr>	
				<tr>
					价格: <input type="text" name="price" readonly="readonly" value="<?php echo $_GET['total']?>"><br>
				</tr>
				<input type='hidden' name="id" value="<?php echo $_GET['id']?>">
				<input type="submit" value='只能修改桌号'>
			</table>
		</form>
	</table>	
</body>
</html>