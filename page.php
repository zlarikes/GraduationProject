<?php
require 'include/init.php';
//分页
//各个类型的记录总数
if(isset($_GET['type'])){

    switch($_GET['type']){ 
        case '1' :
        $rowCount = $db->queryNum("select * from f_foods where tuijian=1");
        break;
        case '2' :
        $rowCount = $db->queryNum("select * from f_foods where type=2");
        break;
        case '3' :
        $rowCount = $db->queryNum("select * from f_foods where type=3");
        break;
        case '4' :
        $rowCount = $db->queryNum("select * from f_foods where type=4");
        break;
        case '5' :
        $rowCount = $db->queryNum("select * from f_foods where type=5");
        break;
        case '6' :
        $rowCount = $db->queryNum("select * from f_foods where type=6");
        break;
        default:
        $rowCount = $db->queryNum("select * from f_foods");
        break;
    }
}
//一个页面记录数
$pageSize = 12;
//总页数
$pageCount = ceil($rowCount/$pageSize);

//当前页
if(empty($_GET['page'])){
    $pageNow = 1;
}else{
    $pageNow = $_GET['page'];
}

if(isset($_GET['type'])){
    switch($_GET['type']){  
        case '1' :
        $list = $db->queryArray("select * from f_foods where tuijian=1 limit ".($pageNow-1)*$pageSize.",$pageSize");
        echo json_encode($list);
        break;
        case '2' :
        $list = $db->queryArray("select * from f_foods where type=2 limit ".($pageNow-1)*$pageSize.",$pageSize");
        echo json_encode($list);
        break;
        case '3' :
        $list = $db->queryArray("select * from f_foods where type=3 limit ".($pageNow-1)*$pageSize.",$pageSize");
        echo json_encode($list);
        break;
        case '4' :
        $list = $db->queryArray("select * from f_foods where type=4 limit ".($pageNow-1)*$pageSize.",$pageSize");
        echo json_encode($list);
        break;
        case '5' :
        $list = $db->queryArray("select * from f_foods where type=5 limit ".($pageNow-1)*$pageSize.",$pageSize");
        echo json_encode($list);
        break;
        case '6' :
        $list = $db->queryArray("select * from f_foods where type=6 limit ".($pageNow-1)*$pageSize.",$pageSize");
        echo json_encode($list);
        break;
        default:
        $list = $db->queryArray("select * from f_foods limit ".($pageNow-1)*$pageSize.",$pageSize");
        echo json_encode($list);
        break;
    }
}
?>