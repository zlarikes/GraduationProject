<?php
require '../include/init.php';
	//分页
//记录总数
$rowCount = $db->queryNum("select * from f_foods");
//一个页面记录数
$pageSize = 13;
//总页数
$pageCount = ceil($rowCount/$pageSize);
//当前页
if(empty($_GET['page'])){
	$pageNow = 1;
}else{
	$pageNow = $_GET['page'];
}
$list = $db->queryArray("select * from f_foods limit ".($pageNow-1)*$pageSize.",$pageSize"); 
if(isset($_POST['num'])){
	$num = $_POST['num'];
	$id = $_POST['id'];
	$res = $db->query("update f_foods set food_num=(food_num+{$num}) where id={$id}");
}
?>
<!doctype html>
<html lang="zh_cn">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet"  type="text/css" href="css/admin.css">
	<script src="js/jquery.min.js"></script>
	<title>Document</title>
</head>
<body>
	<table>
		<tr>
			<th>菜名</th>
			<th>余量</th>
			<th>操作</th>
		</tr>
		<?php foreach($list as $k=>$v){  ?>
		<tr>
			<td><?php echo $v['food_name']; ?></td>
			<td><?php echo $v['food_num']; ?></td>
			<td>
				<input type="text"  id="foodNum" placeholder="请输入增加的数量" />
				<input type="submit" value="增加" class="sub" />
				<input type="hidden" value="<?php echo $v['id']; ?>" id="hidden"/>
			</td>
		</tr>
		<?php } ?>
	</table>
	<div class="page">
		<ul>
			<li><a href="food_jia.php?page=1">首页</a></li>
			<li><a href="food_jia.php?page=<?php echo $pageNow-1; ?>">上一页</a></li>
			<li><a href="food_jia.php?page=<?php echo $pageNow+1; ?>">下一页</a></li>
			<li><a href="food_jia.php?page=<?php echo $pageCount; ?>">尾页</a></li>
		</ul>
	</div>
</body>
</html>
<script>
	$(function(){
		$('.sub').each(function(){
			$(this).bind('click',function(){
				var id  = $(this).next().val();
				var num = $(this).prev().val();
				$.post('food_jia.php',{id:id,num:num},function(){
					alert('增加成功');
					window.location.reload();
				});
			});
		});

	});
</script>