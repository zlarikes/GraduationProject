<?php
require 'include/init.php';

//获取接收过来物品的id
$id = $_POST['id'];
//查询f_foods,获取该食品信息
$list = $db->queryArray("select * from f_foods where id=$id");
//判断是否是收藏
if(isset($_GET['action']) && $_GET['action']=='collect'){

    foreach($list as $k => $v) {
        $foodName = $v['food_name'];
        $food_id = $v['id'];
        $img = $v['img'];
    }
//插入收藏表中
    $res = $db->query("insert into f_shoucang(food_id,food_name,member,img) values('{$food_id}','{$foodName}','{$_SESSION['userName']}','{$img}')");
    echo json_encode($res);
    exit;
}



//产生订单号
$orderId = '';
for($i=0; $i<6; $i++){
    $orderId .= dechex(mt_rand(0,15));
}

$tableNum = rand(0,15);

foreach($list as $k => $v){
    $foodName = $v['food_name'];
    $price    = $v['food_price'];
    $img      = $v['img'];
   /* switch($v['type']){
        case '1':
            $type = '推荐菜';
            break;
        case '2':
            $type = '甜品';
            break;
        case '3':
            $type = '饮料';
            break;
        default:
            $type = '未选';
    }*/
}
//插入订单表中
    $db->query("insert into f_book(member,book_num,food_name,food_price,img,time) values('{$_SESSION['userName']}','{$orderId}','{$foodName}','{$price}','{$img}',NOW())");

//插入交易表
    $db->query("insert into f_trade(buyer,food_name,food_price,table_num,book_num,time) values('{$_SESSION['userName']}','{$foodName}','{$price}','{$tableNum}','{$orderId}',NOW())");

    $res = $db->insertId();
    return $res;

