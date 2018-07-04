<?php
require '../include/init.php';
if(isset($_POST['sub']) && $_POST['sub'] == 'add'){
        //上传
    $fileTypes = array('image/jpeg','image/pjpeg','image/png','image/x-png','image/gif');
    if(!in_array($_FILES['userfile']['type'],$fileTypes)){
        echo '<script>alert("文件必须是jpg,gif,png中的一种");history.back();</script>';
        exit;
    }
    if($_FILES['userfile']['error']>0){
        switch($_FILES['userfile']['error']){
            case 1:
            echo '<script>alert("超过上传最大值2M");history.back();</script>';
            break;
            case 2:
            echo '<script>alert("超过上传最大值2M");history.back();</script>';
            break;
            case 3:
            echo '<script>alert("只有部分文件被上传");history.back();</script>';
            break;
            case 4:
            echo '<script>alert("没有文件被上传");history.back();</script>';
            break;
        }
    }

    if(is_uploaded_file($_FILES['userfile']['tmp_name'])){
            //echo "上传成功";
        if(!move_uploaded_file($_FILES['userfile']['tmp_name'],'../upload/'.date("Y-m-d His").'.jpg')){
            echo "移动失败";
        }
    }else{
        echo "上传失败";
    }

    if(isset($_POST['foodName']) && isset($_POST['foodPrice']) && isset($_POST['foodType'])){
        $fileName = date("Y-m-d His").'.jpg';
        $res = $db->query("insert into f_foods(food_name,food_price,img,type,tuijian,food_num,food_hot) values('{$_POST['foodName']}','{$_POST['foodPrice']}','{$fileName}','{$_POST['foodType']}','{$_POST['tuijian']}','{$_POST['foodNum']}','{$_POST['hot']}')");
        if($res){
            echo "<script>alert('添加成功~');window.location.reload(true)</script>";
        }else{
            echo "<script>alert('添加失败~');histroy.go(-1);</script>";
        }
    }
}
?>

<!doctype html>
<html lang="zh_cn">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet"  type="text/css" href="css/admin.css">
    <title>Document</title>
</head>
<body>
    <form action="food_add.php" method="post" enctype="multipart/form-data">
        <h4>食品添加</h4>
        <p>食品名称：<input type="text" name="foodName"></p>
        <p>食品价格：<input type="text" name="foodPrice"></p>
        <p>食品库存：<input type="text" name="foodNum"></p>
        <p>食品照片：<input type="file" name="userfile"></p>
        <p>食品类型：
            <select name="foodType">
                <option value="0">全部</option>
                <option value="1">推荐菜</option>
                <option value="2">冷饮</option>
                <option value="3">热饮</option>
                <option value="4">甜品</option>
                <option value="5">冰淇淋</option>
                <option value="6">烧仙草</option>
            </select>
        </p>
        <p>是否推荐：
            <select name="tuijian">
                <option value=""></option>
                <option value="0">不推荐</option>
                <option value="1">推荐</option>
            </select>
        </p>
        <p>是否热销：
            <select name="hot">
                <option value=""></option>
                <option value="0">否</option>
                <option value="1">是</option>
            </select>
        </p>
        <p style="text-align:center"><button type="submit" name="sub" value="add">添加</button></p>
    </form>
</body>
</html>