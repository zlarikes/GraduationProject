<?php
    require '../include/init.php';

if(isset($_GET['id'])){
        $id = $_GET['id'];
        global $id;
        $list = $db->queryArray("select * from f_foods where id={$_GET['id']}");
    }
if(isset($_POST['sub']) && $_POST['sub'] == 'modify'){
    //上传
    if(is_uploaded_file($_FILES['userfile']['tmp_name'])){
        //echo "上传成功";
        $fileName = date("Y-m-d His").'.jpg';
        if(!move_uploaded_file($_FILES['userfile']['tmp_name'],'../upload/'.date("Y-m-d His").'.jpg')){
            echo "移动失败";
        }
    }
    if(isset($_POST['foodName']) || isset($_POST['foodPrice']) || isset($_POST['foodType'])){
        if(isset($fileName)){
            $res = $db->query("update f_foods set food_name='{$_POST['foodName']}',food_price='{$_POST['foodPrice']}',type='{$_POST['foodType']}',tuijian='{$_POST['tuijian']}',food_hot='{$_POST['hot']}',img='{$fileName}' where id={$_GET['id']}");
        }else{
            $res = $db->query("update f_foods set food_name='{$_POST['foodName']}',food_price='{$_POST['foodPrice']}',type='{$_POST['foodType']}',tuijian='{$_POST['tuijian']}',food_hot='{$_POST['hot']}' where id={$_GET['id']}");
        }

        if($res){
            echo "<script>alert('修改成功~');location.href='food_manage.php';</script>";
        }else{
            echo "<script>alert('修改失败~');histroy.go(-1);</script>";
        }
    }else{
        echo "<script>alert('未改动~');histroy.go(-1);</script>";
    }
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
<form action="food_modify.php?id=<?php echo $_GET['id'];?>" method="post" enctype="multipart/form-data">
    <h4>食品修改</h4>
    <?php  foreach($list as $k=>$v) { ?>
        <p>食品名称：<input type="text" name="foodName" value="<?php echo $v['food_name'] ?>"></p>
        <p>食品价格：<input type="text" name="foodPrice" value="<?php echo $v['food_price'] ?>"></p>
        <p>食品照片：<img src="../upload/<?php echo $v['img'];?>" width="60" border="1">
            <input type="file" id="file" style="display:none" name="userfile" />
            <input type="button" value="更改" onclick="document.getElementById('file').click();" /></p>
        <p>食品类型：
            <select name="foodType">
                <option <?php if($v['type']==0) echo 'selected'; ?> value="0"></option>
                <option <?php if($v['type']==1) echo 'selected'; ?> value="1">全部</option>
                <option <?php if($v['type']==2) echo 'selected'; ?> value="2">冷饮</option>
                <option <?php if($v['type']==3) echo 'selected'; ?> value="3">热饮</option>
                <option <?php if($v['type']==4) echo 'selected'; ?> value="4">甜品</option>
                <option <?php if($v['type']==5) echo 'selected'; ?> value="5">冰淇淋</option>
                <option <?php if($v['type']==6) echo 'selected'; ?> value="6">烧仙草</option>
            </select>
        </p>
        <p>是否推荐：
            <select name="tuijian">
                <option value=""></option>
                <option <?php if($v['tuijian']==0) echo 'selected'; ?> value="0">未推荐</option>
                <option <?php if($v['tuijian']==1) echo 'selected'; ?> value="1">推荐</option>
            </select>
        </p>
        <p>是否热销：
            <select name="hot">
                <option value=""></option>
                <option <?php if($v['hot']==0) echo 'selected'; ?> value="0">非热销</option>
                <option <?php if($v['hot']==1) echo 'selected'; ?> value="1">热销</option>
            </select>
        </p>
    <?php
        }
    ?>

    <p style="text-align:center"><button type="submit" name="sub" value="modify">修改</button></p>
</form>
</body>
</html>
