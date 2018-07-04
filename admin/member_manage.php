<?php
    require '../include/init.php';
    $list = $db->queryArray("select * from f_member");
    if($_GET['sub'] == 'del'){
        $id = $_POST['id'];
        $db->query("delete from f_member where id={$id}");
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
    <table border="1" cellpadding="0" cellspacing="0">
        <tr>
            <th>会员名</th>
            <th>邮箱</th>
            <th>操作</th>
        </tr>
        <?php foreach($list as $k=>$v) { ?>
                <tr>
                    <td><?php echo $v['name'] ?></td>
                    <td><?php echo $v['email'] ?></td>
                    <td><a href="javascript:void()" style="text-decoration: none" id="del" val="<?php echo $v['id'];?>">删除</a></td>
                </tr>
        <?php
            }
        ?>
    </table>
<script>
    $(function(){
       $('#del').live('click',function(){
           if(confirm("确定要删除吗？")){
               $.ajax({
                   type:'post',
                   url:'member_manage.php?sub=del',
                   data:{'id':$(this).attr('val')},
                   success:function(){
                       alert('删除成功');
                       window.location.reload(true);
                   }
               })
           }

       });
    });
</script>
</body>
</html>