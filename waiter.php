<?php 
require 'include/init.php';
$sum = $db->queryArray("select sum(`food_price`) as total from f_trade group by buyer");
$list = $db->queryArray("select * from f_trade group by buyer");
foreach($list as $k=>$v){
	$list[$k]['food_price'] = $sum[$k]['total'];
}
if(isset($_GET['act']) && $_GET['act']=='confirm'){
	$res = $db->query("update f_trade set confirm={$_POST['confirm']} where book_num='{$_POST['orderID']}'");}
	$foodList = $db->queryArray("select * from f_foods");
	if(isset($_GET['act']) && $_GET['act']=='add') {
		$res = $db->queryOne("select food_price from f_foods where food_name='{$_POST['selected']}'");
		echo json_encode($res);
		exit;
	}
	if(isset($_GET['act']) && $_GET['act']=='addFood') {
		$res = $db->query("insert into f_trade(buyer,food_name,food_price,table_num,book_num) values('{$_POST['buyer']}','{$_POST['foodName']}','{$_POST['price']}','0',0)");
		echo json_encode($res);
		exit;
	}
	if(isset($_GET['view']) && $_GET['view']=='viewFood') {
		$res = $db->queryArray("select * from f_trade where buyer='{$_POST['buyer']}'");
		echo json_encode($res);
		exit;
	}
	//当前页
	if(empty($_GET['page3'])){
		$pageNow3 = 1;
	}else{
		$pageNow3 = $_GET['page3'];
	}
	$pageSize = 10;
//分页
//记录总数
	$rowCount3 = $db->queryNum("select * from f_table_save");
//总页数
	$pageCount3 = ceil($rowCount2/$pageSize);
	$bookCart = $db->queryArray("select * from f_table_save  limit ".($pageNow3-1)*$pageSize.",$pageSize");
//删除
	if(isset($_GET['act']) && $_GET['act']=='take') {
		$res = $db->query("delete from f_table_save where id={$_POST['id']}");
	} 
	?>
	<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>personal center</title>
		<link rel="stylesheet" type="text/css" href="css/base.css">
		<link rel="stylesheet" type="text/css" href="css/block.css">
		<link rel="stylesheet" type="text/css" href="css/page.css">
		<script src="js/jquery.min.js"></script>
		<style type="text/css">
			.nav li{line-height: 30px;margin: 0 0 3px 0;width: 70px;background-color: #74adaa;text-align: center;}
			#page2{position: relative;margin-left: auto;margin-right: auto;}
			#page2 td{width: 170px;line-height: 30px;}
		</style>
	</head>
	<body> 
		<ul class="nav">
			<li id="1">订单管理</li>
			<li id="2">订座管理</li>
		</ul>
		<table class="sh" id="page1">
			<tr>
				<td>桌号</td>
				<td>订餐人</td>
				<td>订单</td>
				<td>金额</td>
				<td>状态</td>
				<td>操作</td>
			</tr>
			<?php foreach($list as $k=>$v){ ?>
			<tr>
				<td><?php echo $v['table_num']; ?></td>
				<td><?php echo $v['buyer']?></td>
				<td><?php echo $v['book_num']?></td>
				<td><?php echo $v['food_price']?></td>
				<td><?php if($v['confirm']==1) echo '已审核';else echo '未审核';?></td>
				<td><a href="javascript:void(0);" style="color:red" class="pass">审核</a> <a href="edit_order.php?id=<?php echo $v['id'];?>&table=<?php echo $v['table_num'];?>&name=<?php echo $v['buyer'];?>&bookNum=<?php echo $v['book_num'];?>&total=<?php echo $v['food_price']?>">修改</a><td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td>
						<select name='food' id='food'>
							<option>请选择</option>
							<?php
							foreach($foodList as $k=>$val){
								echo "<option>{$val['food_name']}</option>";
							}
							?>
						</select>
					</td>
					<td><input placeholder="请输入追加的菜价" id="foodPrice"/></td>
					<td></td>
					<td><button id="sub">提交</button> <button id="details">详情</button></td>
					<input type='hidden' id='order'  value="<?php echo $v['buyer']?>" />
				</tr>
				<?php } ?>
			</table>
			<form action="" method="post">
			</form>
			<table id="page2">
				<tr>
					<td>预定人数</td>
					<td>预定桌号</td>
					<td>预定时间</td>
					<td>预定人姓名</td>
					<td>操作</td>
				</tr>
				<?php foreach($bookCart as $k=>$v){ ?>
				<tr>
					<td><?php echo $v['book_num']; ?>名顾客</td>
					<td><?php echo $v['table_name'] ?></td>
					<td><?php echo $v['book_time'] ?></td>
					<td><?php echo $v['name'] ?></td>
					<td><a href="javascript:void(0)" value="<?php echo $v['id']; ?>" id="take">删除</a></td>
				</tr>
				<?php } ?>
			</table>
		</body>
		</html>
		<script>
			$(function(){
				$('#page1').show();
				$('#page2').hide(); 
				$('ul>li').live('click',function(){
					if($(this).attr('id') == '1'){
						$('#page1').show();
						$('#page2').hide(); 
					}
					if($(this).attr('id') == '2'){
						$('#page2').show();
						$('#page1').hide(); 
					} 
				});
			});
			$('#take').live('click',function(){
			var id = $(this).attr('value');
			$.ajax({
				type: "POST",
				url: "waiter.php?act=take",
				data: {'id': id},
				success: function (res) {
					alert("删除成功~");window.location.reload(true);
				}
			});
		})
			$(function(){
				var html = '';
				$('.pass').each(function()
				{
					$(this).click(function()
					{
						var orderID = $(this).parent().prev().prev().prev().text();
						$.post('waiter.php?act=confirm',{'confirm':1,'orderID':orderID},function()
						{
							alert('审核成功~');window.location.reload();
						})
					})
				});

				$('#food').live('change',function()
				{
					var selected = $(this).val();
					var $this = $(this);

					$.ajax({
						type: "POST",
						url: "waiter.php?act=add",
						data: {'selected': selected},
						dataType:'json',
						success: function (data) 
						{
							$this.parent().next().children().val(data['food_price']);
						}
					});
				});

		//追加菜单
		$('#sub').live('click',function()
		{
			var addPrice = $(this).parent().prev().prev().children().val();
			var foodName =  $(this).parent().prev().prev().prev().children().val();
			var buyer   = $(this).parent().next().val();
			//var $this = $(this);
			$.ajax({
				type:'post',
				url:'waiter.php?act=addFood',
				data:{'price':addPrice,'buyer':buyer,'foodName':foodName},
				dataType:'json',
				success: function(res)
				{
					alert('下单成功~');window.location.reload();
				}
			});
		});
		//显示详情
		$('#details').live('click',function()
		{
			var buyer   = $(this).parent().next().val();
			html='';
			$.ajax({
				type:'post',
				url:'waiter.php?view=viewFood',
				data:{'buyer':buyer},
				dataType:'json',
				success: function(res)
				{
					html += "菜名"+"------价格"+'\n';
					$.each(res,function(k,v){
						html += v['food_name']+"----"+v['food_price']+'\n';
					});
					alert(html);
				}
			});
		});
	});
</script>
