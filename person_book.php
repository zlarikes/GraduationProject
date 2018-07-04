<?php
require 'include/init.php';

//获取订单和收藏
//当前页
if(empty($_GET['page1'])){
	$pageNow1 = 1;
}else{
	$pageNow1 = $_GET['page1'];
}
  //分页
//一个页面记录数
$pageSize = 6;
//总页数
$pageCount1 = ceil($rowCount1/$pageSize);
if($_SESSION['userName']=='服务员'){
	$bookList = $db->queryArray("select * from f_trade limit ".($pageNow1-1)*$pageSize.",$pageSize");
	
}else{
	$bookList = $db->queryArray("select * from f_trade where buyer='{$_SESSION['userName']}' limit ".($pageNow1-1)*$pageSize.",$pageSize");
}
//删除
if(isset($_GET['act']) && $_GET['act'] == 'del'){
	$id = $_GET['id'];
	$res = $db->queryOne("delete from f_book where id=$id");
	if($res){
		echo "<script>alert('删除成功~');window.location.reload(true);</script>";
	}
}
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>book</title>
	<script src="js/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/base.css">
	<link rel="stylesheet" type="text/css" href="css/block.css">
</head>
<body>
	<div class="book">
		<table border="1px">
			<tr>
				<td>订单号</td>
				<td>菜品名称</td>
				<td>价格</td>
				<td>下单时间</td>
<!-- 				<td>操作</td>
 -->			</tr>
			<?php foreach($bookList as $k=>$v){ ?>
			<tr>
			<td><?php echo $v['book_num'] ?></td>
				<td><?php echo $v['food_name'] ?></td>				
				<td><?php echo $v['food_price'] ?></td>
				<td><?php echo $v['time'] ?></td>
<!-- 				<td><a href="person_book.php?act=del&id=<?php echo $v['id']?>" >删除</a></td>
 -->			</tr>
			<?php } ?>
		</table>
		<div class="page">
			<ul>
				<?php if($pageNow1!=1)
				echo '<li><a href="person_book.php?type=book&page1=1">首页</a></li>';
				?>

				<?php if($pageNow1<=1){}else{
					echo '<li><a href="person_book.php?type=book&page1='.($pageNow1-1).'">上一页</a></li>';
				} ?>
				<?php if($pageNow1>=$pageCount1){}else{
					echo '<li><a href="person_book.php?type=book&page1='.($pageNow1+1).'">下一页</a></li>';
				} ?>
				<?php if($pageNow1!=$pageCount1)
				echo "<li><a href='person_book.php?type=book&page1=$pageCount1'>尾页</a></li>";
				?>
			</ul>
		</div>
	</div>
</body>
</html>