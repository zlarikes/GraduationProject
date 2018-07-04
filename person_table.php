<?php
require 'include/init.php';
//当前页
if(empty($_GET['page3'])){
	$pageNow3 = 1;
}else{
	$pageNow3 = $_GET['page3'];
}
$pageSize = 5;
//分页
//记录总数
$rowCount3 = $db->queryNum("select * from f_table_save");
//总页数
$pageCount3 = ceil($rowCount2/$pageSize);
$bookCart = $db->queryArray("select * from f_table_save where member='{$_SESSION['userName']}' limit ".($pageNow3-1)*$pageSize.",$pageSize");
//删除
if(isset($_GET['act']) && $_GET['act']=='take') {
	$res = $db->query("delete from f_table_save where id={$_POST['id']}");
} 
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>table</title>
	<script src="js/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/base.css">
	<link rel="stylesheet" type="text/css" href="css/block.css">
</head>
<body>
	<div class="table">
		<table>
			<tr>
				<td>预定人数</td>
				<td>预定桌号</td>
				<td>预定时间</td>
				<td>预定人姓名</td>
				<td>操作</td>
			</tr>
			<?php foreach($bookCart as $k=>$v){ ?>
			<tr>
				<td><?php echo $v['book_num']; ?>个人</td>
				<td><?php echo $v['table_name'] ?></td>
				<td><?php echo $v['book_time'] ?></td>
				<td><?php echo $v['name'] ?></td>
				<td><a href="javascript:void(0)" value="<?php echo $v['id']; ?>" id="take">删除</a></td>
			</tr>
			<?php } ?>
		</table>
		<div class="page">
			<ul>
				<?php if($pageNow3!=1)
				echo '<li><a href="person_table.php?type=book&page3=1">首页</a></li>';
				?>

				<?php if($pageNow3<=1){}else{
					echo '<li><a href="person_table.php?type=book&page3='.($pageNow3-1).'">上一页</a></li>';
				} ?>
				<?php if($pageNow3>=$pageCount3){}else{
					echo '<li><a href="person_table.php?type=book&page3='.($pageNow3+1).'">下一页</a></li>';
				} ?>
				<?php if($pageNow3!=$pageCount3)
				echo "<li><a href='person_table.php?type=book&page3=$pageCount3'>尾页</a></li>";
				?>
			</ul>
		</div>
	</div>
	<script> 
		$('#take').live('click',function(){
			var id = $(this).attr('value');
			$.ajax({
				type: "POST",
				url: "person_table.php?act=take",
				data: {'id': id},
				success: function (res) {
					alert("删除成功~");window.location.reload(true);
				}
			});
		})
	</script>
</body>
</html>