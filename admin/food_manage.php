<?php
require '../include/init.php';
//分页
//记录总数
$rowCount = $db->queryNum("select * from f_foods");
//一个页面记录数
$pageSize = 4;
//总页数
$pageCount = ceil($rowCount/$pageSize);
//当前页
if(empty($_GET['page'])){
    $pageNow = 1;
}else{
    $pageNow = $_GET['page'];
}

$list = $db->queryArray("select * from f_foods limit ".($pageNow-1)*$pageSize.",$pageSize");
foreach($list as $k=>$v){
    switch($v['type']){
        case '0':
        $list[$k]['type'] = '全部';
        break;
        case '1':
        $list[$k]['type'] = '推荐';
        break;
        case '2':
        $list[$k]['type'] = '冷饮';
        break;
        case '3':
        $list[$k]['type'] = '热饮';
        break;
        case '4':
        $list[$k]['type'] = '甜品';
        break;
        case '5':
        $list[$k]['type'] = '冰淇淋';
        break;
        case '6':
        $list[$k]['type'] = '烧仙草';
        break;
        default:
        $list[$k]['type'] = '未选';
    }
    switch($v['tuijian']){
        case '0':
        $list[$k]['tuijian'] = '未推荐';
        break;
        case '1':
        $list[$k]['tuijian'] = '推荐';
        break;
    }
    switch($v['food_hot']){
        case '0':
        $list[$k]['food_hot'] = '否';
        break;
        case '1':
        $list[$k]['food_hot'] = '是';
        break;
    }
}
if($_GET['sub'] == 'del'){
    $id = $_POST['id'];
    $db->query("delete from f_foods where id={$id}");
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
    <table border="1" cellpadding="0" cellspacing="0" class="foodTable">
        <tr>
            <th>菜名</th>
            <th>价格(元)</th>
            <th>图片</th>
            <th>类型</th>
            <th>推荐</th>
            <th>热销</th>
            <th>操作</th>
        </tr>
        <?php foreach($list as $k=>$v) { ?>
        <tr>
            <td><?php echo $v['food_name'] ?></td>
            <td><?php echo $v['food_price'] ?></td>
            <td><img src="../upload/<?php echo $v['img'] ?>" width="100" height="90"></td>
            <td><?php echo $v['type'] ?></td>
            <td><?php echo $v['tuijian'] ?></td>
            <td><?php echo $v['food_hot'] ?></td>
            <td><a href="javascript:void()" id="del" val="<?php echo $v['id'];?>">删除</a> <a href="food_modify.php?id=<?php echo $v['id']; ?>">修改</a></td>
        </tr>
        <?php
    }
    ?>
</table>
<div class="page">
    <ul>
        <li><a href="food_manage.php?page=1">首页</a></li>
        <li><a href="food_manage.php?page=<?php echo $pageNow-1; ?>">上一页</a></li>
        <li><a href="food_manage.php?page=<?php echo $pageNow+1; ?>">下一页</a></li>
        <li><a href="food_manage.php?page=<?php echo $pageCount; ?>">尾页</a></li>
    </ul>
</div>
<script>
    $(function(){
        $('#del').live('click',function(){
            $.ajax({
                type:'post',
                url:'food_manage.php?sub=del',
                data:{'id':$(this).attr('val')},
                success:function(){
                    alert('删除成功');
                    window.location.reload(true);
                }
            })
        });
    });
</script>
</body>
</html>