<?php
session_start();
require 'include/init.php';

$list = $db->queryArray("select * from f_book where member='{$_SESSION['userName']}'");

//删除
if(isset($_GET['act']) && $_GET['act'] == 'del'){
	$id = $_GET['id'];
	$res = $db->queryOne("delete from f_book where id=$id");
	if($res){
		echo "<script>alert('删除成功~');window.location.reload(true);</script>";
	}
}
//
if(isset($_GET['act']) && $_GET['act'] == 'confirm'){
	$db->query("update f_trade set state=1 where buyer='{$_SESSION['userName']}'");
	$db->query("truncate f_book");
}
/*if(empty($_GET['user_name']) && $_GET['a'] == 1 ){
  	//var_dump($_GET['a']);
		$food_name = $_POST['food_name'];
		$food_price = $_POST['food_price'];
		$count = $_POST['count'];
  //生成商品订单
		$order = "YXC".time();
		$user_name = $_SESSION['userName'];
	//var_dump($_SESSION);
		$db->queryOne("insert into `f_order` (`food_name`,`count`,`food_price`,`order`,`user_name`,`statu`) value ('{$food_name}','{$count}','{$food_price}','{$order}','{$user_name}','0')");
	//statu 0wei zhifu 1 yizhifu
		$res = $db->queryArray("select * from `f_order` where statu = '0'");
		var_dump($res);
	}else{
		$user_name = $_SESSION['userName'];
	//var_dump($_SESSION);
		$res = $db->queryArray("select * from `f_order` where user_name='{$user_name}' and statu='0'");
	//var_dump($res);
	}*/
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>购物车</title>
	<script src="js/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/base.css">
	<link rel="stylesheet" type="text/css" href="css/block.css">
</head>
<body>
		<table class="sh">
			<tr>
				<td>菜品信息</td>
				<td>单价</td>
				<td>份数</td>
				<td>金额</td>
				<td>操作</td>
			</tr>
			<?php foreach($list as $k=>$v) { ?>
			<tr class="detailCon">
				<td><?php echo $v['food_name'] ?></td>
				<td><?php echo $v['food_price'] ?></td>
				<td>
					<a href="#" id="jian">-</a><input type="text" value="1" id="num"><a href="#" 							id="jia">+</a>
				</td>
				<td class="total"><?php echo $v['food_price'] ?></td>
				<td><a href="shopping.php?act=del&id=<?php echo $v['id']?>" >删除</a></td>
			</tr>
			<?php
		}
		?>
		<tr>
			<td colspan="4" id="count">&nbsp;</td>
			<td><font>&nbsp;</font></td>
			<td><a href="#" class="count" id="account">结算</a></td>
		</tr>
		</table>
</body>
</html>
<script>
	$(function(){

		$('#jian').live('click',function(){
			var i = $(this).next().attr('value');
			i--;
			$(this).next().attr('value',i);
			dan = $(this).parent().prev().text();
			total = $(this).parent().next().text();
			money = total-dan;
			$(this).parent().next().text(money);
		})

		$('#jia').live('click',function(){
			var i = $(this).prev().attr('value');
			i++;
			$(this).prev().attr('value',i);
			num = $(this).prev().attr('value');
			dan = $(this).parent().prev().text();
			total = num*dan;
			$(this).parent().next().text(total);
		})

		$('#account').click(function(){
			var sum=0;
			$('.total').each(function(index) {
				sum += +$(this).text();
			});
			if(confirm("您总共需要支付"+sum)){

				$.get('shopping.php?act=confirm',{},function(){
				});
				alert("支付成功~");
				top.location.href="index.php";
			}else{
				alert("支付失败~");
			}
		});

	});
</script>