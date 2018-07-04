<?php
require 'include/init.php';
// if(!$_SESSION['usermember']){
// 	echo "<script>alert('请登录~');</script>";
// }
//分页
$list = $db->queryArray("select * from f_table");
$listcount = $db->queryNum("select * from f_table");
$tableCount = $db->queryOne("select * from f_table_save2");
$listsave =$db->queryArray("select * from f_table_save");
$num = $_POST['savecount'];
$name = $_POST['savename'];
$time = $_POST['date'];

if(isset($_POST['tableName'])){
	$tableName = $_POST['tableName'];
}
	//var_dump($tableName);
if(isset($_POST['sub'])&&isset($_POST['savecount']) && isset($_POST['date']) && isset($_POST['savename'])) {
	/*$res = $db->query("insert into f_table_save (member,book_name,book_time,book_num,name) values('{$_SESSION['userName']}','{$_POST['date']}','{$_POST['savecount']}','{$_POST['savename']}')");*/
	/*if ($res) {*/
		if($num>$tableCount['num']){
			echo "<script>alert('预定失败，超过数量，请重新预定~');window.location.reload(true);</script>";
		}else{
			$sql = $db->query("update f_table_save2 set num=(num-{$num})");
			$db->query("insert into f_table_save(member,table_name,book_time,book_num,name) values('{$_SESSION['userName']}','$tableName','{$time}',{$num},'{$name}')");
			echo "<script>alert('预定成功~');top.location.href='index.php'</script>";
		}
	// } 
	}
	?>
	<!DOCTYPE HTML>
	<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta member="viewport" content="width=device-width; initial-scale=1.0">
		<title>订餐系统</title>
		<meta member="keywords" content="jQuery,选座">
		<link rel="stylesheet" type="text/css" href="css/base.css"/>
		<link rel="stylesheet" type="text/css" href="css/block.css"/>
		<link rel="stylesheet" type="text/css" href="css/main.css?12321123" />
		<link rel="stylesheet" type="text/css" href="css/datetimepicker.css"/ >
		<script src="js/jquery.js"></script>
		<script src="js/jquery.datetimepicker.js"></script>
		<script type="text/javascript" src="js/jquery.seat-charts.min.js"></script>
		<style type="text/css">
			.demo{width:850px; margin:20px auto 0 auto; min-height:450px;}
			@media screen and (max-width: 360px) {.demo {width:340px}}
			.booking-details {float: left;margin-top: 20px; margin-left: 30px; position: relative;width:200px;height: 450px; }
			.booking-details h3 {margin: 5px 5px 0 0;font-size: 16px;}
			.booking-details p{line-height:26px; font-size:16px; color:#999}
			.booking-details p span{color:#666}
			div.seatCharts-cell {color: #182C4E; height: 50px;width: 35px;line-height: 25px;margin: 3px;float: left;text-align: center;outline: none;font-size: 13px;}
			div.seatCharts-seat {background-image: url(images/table.png); background-size: contain;
				background-repeat: no-repeat;background-position: bottom; color: #fff;cursor: pointer;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;}
				div.seatCharts-row {     width: 100%; float: left;}
				div.seatCharts-seat.available {background-color: #B9DEA0;}
				div.seatCharts-seat.focused {background-color: #76B474;border: none;}
				div.seatCharts-seat.selected {background-color: #E6CAC4;}
				div.seatCharts-seat.unavailable {background-color: #472B34;cursor: not-allowed;}
				div.seatCharts-container {border-right: 1px dotted #adadad;width: 450px;padding: 20px;float: left;}
				div.seatCharts-legend {padding-left: 0px;margin: 30px 0 0 20px;}
				ul.seatCharts-legendList {padding-left: 0px;}
				.seatCharts-legendItem{float:left; width:90px;margin-top: 10px;line-height: 2;}
				span.seatCharts-legendDescription {margin-left: 5px;line-height: 30px;}
				.checkout-button {display: block;width:80px; height:24px; line-height:20px;margin: 10px auto;border:1px solid #999;font-size: 14px; cursor:pointer}
				#selected-seats {max-height: 150px;overflow-y: auto;overflow-x: none;width: 200px;}
				#selected-seats li{float:left; width:72px; height:26px; line-height:26px; border:1px solid #d3d3d3; background:#f7f7f7; margin:6px; font-size:14px; font-weight:bold; text-align:center}
			/*.set{    float: left;
				margin-top: 49px;}*/
			</style>
		</head>
		<body>
			<div id="main">
				<div class="demo">
					<div id="seat-map">					
					</div>
					<div class="booking-details"> 
						<p>预定时间：<input type="text"   id="datetimepicker" name="date" /></p>
						<p>预定人数：<input type="text" id="savecount"  name="savecount"/></p>
						<p>预定人：<input type="text" id="savename"  name="savename"/></p>
						<ul id="selected-seats"></ul>	
						<input type="hidden"  id="tableName" name="tableName" value=''/>		
						<input type="hidden" id="savetable" name="savetable" />					
						<button class="checkout-button" onclick="savaCart()" type="submit"  name="sub" >确定预定</button>
						<div id="legend"></div>
					</div>	   
					<div style="clear:both"></div>
				</div>
				<br/>
			</div>
			<script type="text/javascript"> 
var price = 80; //票价
var unsel=[<?php foreach($listsave as $k=>$v){ ?>
	'<?php echo $v['table_name'] ?>',
	<?php } ?> ];

	$(document).ready(function() {
		$('#datetimepicker').datetimepicker({lang:'ch'});
	var $cart = $('#selected-seats'), //座位区
	$counter = $('#counter'), //票数
	$total = $('#total'); //总计金额	
	var sc = $('#seat-map').seatCharts({
		map: [  //座位图 
		'aaaaaaaaa', 
		'aaaaaaaaa',   
		'aaaaaaaaa', 
		'aaaaaaaaa', 
		'aaaaaaaaa', 
		'aaaaaaaaa',  
		], 
		naming : {
			top : false,
			getLabel : function (character, row, column) {
				return column;
			}
		},
		legend : { //定义图例
			node : $('#legend'),
			items : [
			[ 'a', 'available',   '可选座' ],
			[ 'a', 'unavailable', '已预占']
			]					
		},
		click: function () { //点击事件
			if (this.status() == 'available') { //可选座

				$cart.empty();
				$('<li>'+(this.settings.row+1)+'排'+this.settings.label+'座</li>')
				.attr('id', 'cart-item-'+this.settings.id)
				.data('seatId', this.settings.id)
				.appendTo($cart);

				$counter.text(sc.find('selected').length+1);
				$total.text(recalculateTotal(sc)+price);
				var table= $(this.settings.$node[0]).find("span").attr("key");
				// $("#mytable").html(table);
				$("#savetable").val($("div[tabel]").index(this.settings.$node[0])+1);

				return 'selected';
			}else if (this.status() == 'selected') { //已选中
					//更新数量
					$counter.text(sc.find('selected').length-1);
					//更新总计
					$total.text(recalculateTotal(sc)-price);
					
					//删除已预订座位
					$('#cart-item-'+this.settings.id).remove();
					//可选座
					return 'available';
			} else if (this.status() == 'unavailable') { //已售出
				return 'unavailable';
			} else {
				return this.style();
			}
		}
	});

	$.ajax({
		url:"",
		success:function(){
			for (var i = 0; i < unsel.length; i++) {
				//alert(unsel[i].split("排"));
				var row= unsel[i].split("排")[0];
				var column = unsel[i].split("排")[1].split("座")[0];
				//alert(row+column);
				$("#"+row+"_"+column).addClass("unavailable");
			}

		}
	});
	
	var type=[<?php foreach($list as $k=>$v){ ?>
		'<?php echo $v['seat'] ?>',
		<?php } ?> ];

	});

	function savaCart(){
		$.ajax({
			url:"seletseat.php",

			data:{tableName:$("#selected-seats").find("li").html(),savecount:$("#savecount").val(),date:$("#datetimepicker").val(),savename:$("#savename").val()},
			success:function(){
				alert("保存成功");
				$(".selected").removeClass("selected").addClass("unavailable");
				$("#selected-seats").empty();
			}
		});
	}

	$(function(){
		$('.checkout-button').click(function(){
			var tableName = $('#selected-seats').children().text();		
			$('#tableName').val(tableName);
		//$.post('cart.php',{'tableName':tableName},function(){});
			/*$.ajax({
				type: "POST",
				url: "cart.php",
				data: {'tableName':tableName},
				success: function () {					
				}
			});*/
		});
	});
//计算总金额
function recalculateTotal(sc) {
	var total = 0;
	sc.find('selected').each(function () {
		total += price;
	});
	
	return total;
}
function tosave(){
	var count="";
	$("div[tabel]").each(function(n,t){
		if($(this).hasClass("selected")){
			var select= $(this).find("span").attr("key");
			count +=select +",";
		}
		var savetime= $("#datetimepicker").val();
		var savecount = $("#savecount").val();
		$.ajax({
		});
	});
}
</script>
</body>
</html>