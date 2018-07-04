<?php
require 'include/init.php';
//取消收藏
if(isset($_GET['act']) && $_GET['act']=='take') {
	$res = $db->query("delete from f_shoucang where id={$_POST['id']}");
}
//获取收藏
//当前页
if(empty($_GET['page2'])){
	$pageNow2 = 1;
}else{
	$pageNow2 = $_GET['page2'];
}

$pageSize = 12;
  //分页
//记录总数
$rowCount2 = $db->queryNum("select * from f_shoucang");
//总页数
$pageCount2 = ceil($rowCount2/$pageSize);
$collectList = $db->queryArray("select * from f_shoucang where member='{$_SESSION['userName']}' limit ".($pageNow2-1)*$pageSize.",$pageSize");

?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>collect</title>
	<script src="js/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/base.css">
	<link rel="stylesheet" type="text/css" href="css/block.css">
	<style type="text/css"> 
		.collect img{width: 110px; height: 110px;}
		.collect table {border: 1px solid #999; width: 792px;height: 100%;}
		.collect tr{float: left;border: 1px solid #999;margin: 15px 0 10px 10px;}
	</style>
</head>
<body>
	<div class="collect">
		<table >
			<?php foreach($collectList as $k=>$v){ ?>
			<tr>
				<td>
					<img src="upload/<?php echo $v['img']; ?>"><br/>
					<?php echo $v['food_name'] ?><br/>
					<a href="javascript:void(0)" value="<?php echo $v['id']; ?>" id="take">取消收藏</a>
				</td>
			</tr> 
			<?php } ?>
		</table>
		<div class="page">
			<ul>
				<?php if($pageNow2!=1)
				echo '<li><a href="collect.php?type=collect&page2=1">首页</a></li>';
				?>

				<?php if($pageNow2<=1){}else{
					echo '<li><a href="collect.php?type=collect&page2='.($pageNow2-1).'">上一页</a></li>';
				} ?>
				<?php if($pageNow2>=$pageCount2){}else{
					echo '<li><a href="collect.php?type=collect&page2='.($pageNow2+1).'">下一页</a></li>';
				} ?>
				<?php if($pageNow2!=$pageCount2)
				echo "<li><a href='collect.php?type=collect&page2=$pageCount2'>尾页</a></li>";
				?>
			</ul>
		</div>
	</div>	
	<script>
		$('#take').live('click',function(){
			var id = $(this).attr('value');
			$.ajax({
				type: "POST",
				url: "collect.php?act=take",
				data: {'id': id},
				success: function (res) {
					alert("取消收藏成功~");window.location.reload(true);
				}
			});
		})
	</script>
</body>
</html>
