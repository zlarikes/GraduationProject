<?php
require '../include/init.php';
$list = $db->queryArray("select * from f_table_save2");


if(isset($_POST['num']) && isset($_GET['act']) && $_GET['act']=='jia'){
    $num = $_POST['num'];

    $res = $db->query("update f_table_save2 set num=(num+{$num})");
}
if(isset($_POST['num']) && isset($_GET['act']) && $_GET['act']=='sub'){
    $num = $_POST['num'];

    $res = $db->query("update f_table_save2 set num=(num-{$num})");
}


//分页
//记录总数
$rowCount = $db->queryNum("select * from f_table_save");
//一个页面记录数
$pageSize = 5;
//总页数
$pageCount = ceil($rowCount/$pageSize);
//当前页
if(empty($_GET['page'])){
    $pageNow = 1;
}else{
    $pageNow = $_GET['page'];
}

$bookCart = $db->queryArray("select * from f_table_save limit ".($pageNow-1)*$pageSize.",$pageSize");
if($_GET['sub'] == 'del'){
    $id = $_POST['id'];
    $db->query("delete from f_table_save where id={$id}");
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
        <th>桌数余量</th>
        <th>操作</th>
    </tr>
    <?php foreach($list as $k=>$v){  ?>
        <tr>

            <td><?php echo $v['num']; ?></td>
            <td>
                <input type="text"  id="foodNum" placeholder="请输入数量" />
                <input type="submit" value="增加" class="sub1" />
                <input type="submit" value="删减" id="sub2" />
            </td>
        </tr>
    <?php } ?>
</table>
<table border="1" cellpadding="0" cellspacing="0" class="foodTable">
    <tr>
        <th>会员名</th>
        <th>订座个数</th>
        <th>订座时间</th>
        <th>订座人姓名</th>
        <th>操作</th>
    </tr>
    <?php foreach($bookCart as $k=>$v) { ?>
        <tr>
            <td><?php echo $v['member'] ?></td>
            <td><?php echo $v['book_num'] ?></td>
            <td><?php echo $v['book_time'] ?></td>
            <td><?php echo $v['name'] ?></td>
            <td><a href="javascript:void()" id="del" val="<?php echo $v['id'];?>">删除</a></td>
        </tr>
        <?php
    }
    ?>
</table>
<div class="page">
    <ul>
        <li><a href="cart_manage.php?page=1">首页</a></li>
        <li><a href="cart_manage.php?page=<?php echo $pageNow-1; ?>">上一页</a></li>
        <li><a href="cart_manage.php?page=<?php echo $pageNow+1; ?>">下一页</a></li>
        <li><a href="cart_manage.php?page=<?php echo $pageCount; ?>">尾页</a></li>
    </ul>
</div>
</body>
</html>
<script>
    $(function(){
        $('.sub1').each(function(){
            $(this).bind('click',function(){

                var num = $(this).prev().val();
                $.post('cart_manage.php?act=jia',{num:num},function(){
                    alert('增加成功');
                    window.location.reload();
                });
            });
        });
        $('#sub2').live('click',function(){
            var num = $(this).prev().prev().val();

            $.post('cart_manage.php?act=sub',{num:num},function(){
                alert('删减成功');
                window.location.reload();
            });
        });

        $('#del').live('click',function(){
            $.ajax({
                type:'post',
                url:'cart_manage.php?sub=del',
                data:{'id':$(this).attr('val')},
                success:function(){
                    alert('删除成功');
                    window.location.reload(true);
                }
            })
        });
    });
</script>