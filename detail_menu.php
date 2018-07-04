<?php
require 'include/init.php';
$img=$_GET['img'];
$id = $_GET['id'];
$food_name = $_GET['food_name'];
$food_price = $_GET['food_price'];
$food_num=$_GET['food_num'];
	// echo $food_num;
$pageSize = 8;
//总页数
$pageCount = ceil($rowCount/$pageSize);
//当前页
if(empty($_GET['page'])){
	$pageNow = 1;
}else{
	$pageNow = $_GET['page'];
}
$list = $db->queryArray("select * from f_comment");
$list = $db->queryArray("select * from f_comment limit ".($pageNow-1)*$pageSize.",$pageSize");
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>菜品介绍</title>
	<script src="js/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/base.css">
	<link rel="stylesheet" type="text/css" href="css/block.css">
	<style type="text/css">
		.picture{width: 200px;height: 200px; margin:40px 30px 0 300px ;float: left; }
		.intro{width: 300px;height: 200px;float: left;margin-top: 10px; }
		.intro ul li{line-height: 44px;} 
		.conInput {position: absolute; top: 330px; left: 200px; width:700px; height: 360px;}
		.conInput b{margin: 0;padding: 0;}
		.conInput td{text-align: center;width: 150px;}
		.comment{border:1px solid #ccc;margin-top:5px;margin-bottom:5px;padding:10px 20px;height: 200px;} 
		.autoScroll{ overflow :auto; }
		.add{background-color: #ff761a;border:0;height: 34px;color: #eee;}
		.wid{width: 38px;height:23px; }
	</style>	
</head>
<body>	
	<div class="layoutOther">
		<b> 当前访客身份 ：<?php if(isset($_SESSION['userName'])) echo "<a href='personal.php'>".$_SESSION['userName']."</a> <a href='logout.php'>[退出]</a>";else echo "游客 [ <a href='login.php'> 登录 </a> ]";?>[ <a href='login.php?act=waiter'> 服务员登录 </a> ]</b>
		<p>森 林 小 屋 餐 厅</p>
		<div class="picture"><img src="upload/<?php echo $img?>" width=200px height=200px></div>
		<div class="intro">
			<ul>
				<li> 
					<li>菜名:<?php echo $food_name; ?></li>
					<li>价格:<?php echo $food_price; ?></li>
					<li><font>数量：<a onclick="minus()" class="adjust" href="#">-</a> 
						<input id="count" class="wid" name="count" value="1" /> 
						<a onclick="plus()" class="adjust" href="#">+</a>份</li>
						<li>
							<input type="submit" value="收藏商品" class="add" id="collect" />
							<input type="submit" value="加入购物车" class="add" id="bug"/>
							<input type="hidden"  value="<?php echo $id; ?>">
						</li> 
						<li><a onclick="top.location='index.php'">继续购买</a></li> 
					</li>				
				</ul>
			</div> 
			<script type="text/javascript">
				$('#bug').live('click',function(){
					
					var loginer = "<?php echo $_SESSION['userName']; ?>";
      //判断有没有登录，没有就不让购买。
      if(loginer == ''){
      	alert('请登录~');
      	location.href='login.php';
      	exit();
      }
      var id = $(this).next().val();
      
      $.ajax({
      	type:'post',
      	url:'book.php',
      	data:{
      		'id':id
      	},
      	success:function(){
      		alert('加入购物车成功~');
      	}
      });
  });

    //收藏
    $('#collect').live('click',function(){
    	var loginer = "<?php echo $_SESSION['userName']; ?>";
      //判断有没有登录，没有就不让购买。
      if(loginer == ''){
      	alert('请登录~');
      	location.href='login.php';
      	exit();
      }
      var id = $(this).next().next().val();
      $.ajax({
      	type:'post',
      	url:'book.php?action=collect',
      	data:{
      		'id':id
      	},
      	success:function(res){
      		alert('收藏成功~');
      	}
      });
  });
</script>
<!-- 评论 -->
<script type="text/javascript">
	$(function(){
		$("#sub").live('click',function(){
			var html=""; 
			var content = $('#content').val();
			$.ajax({
				type:"POST",
				url:"comment.php",
				data:{'content':content},
				cache:false,
				dataType:'json',
				success:function(res){
					if(res.state=1){
						alert('评论成功');
						$.each(res.data,function(k,v){
							html += '<table>';									
							html += "<td>"+v['comment']+"</td>";
							html += "<td>"+v['member']+"</td>";
							html += "</table>";
						});
						$('.comment').html(html);
					}else{
						alert('评论失败');
					}
				}
			});
		});
	});
</script>
<div class="conInput">
	<b style="font-size: 22px"> 评 论 区 : </b>	
	<div class="comment autoScroll">			
		<table>
			<?php foreach($list as $k=>$v){ ?>
			<tr>
				<td><?php echo $v['comment'] ?></td>
				<td><?php echo $v['member'] ?></td>
			</tr> 
			<?php } ?>
		</table>
	</div>
	<div class="enter"> 
		<input placeholder="请输入您的评价" id="content"/>
		<button id="sub">提交</button>
	</div>
</div>
<script>
	var count=document.getElementById("count");
	function plus(){
		count.value=parseInt(count.value) + 1;
        // qty.value = parseInt(qty.value) + 1;
        // // 找到最大库存量
        // var span = document.getElementById('store');
        if(parseInt(count.value) > <?=$food_num?>){
        	count.value =<?=$food_num?> ;
        }
    }
    function minus(){
    	count.value = parseInt(count.value) - 1;
         // 购买数量不能小于1
         if(parseInt(count.value) < 1){
         	count.value = 1;
         }
     }
 </script>
</body>
</html>