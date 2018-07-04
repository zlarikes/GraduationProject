<?php
    require '../include/init.php';
    $res = $db->queryOne('select * from f_manager');


    if(isset($_POST['sub']) && $_POST['sub'] == 'login'){
        if($_POST['code'] != $_SESSION['code']){
            echo "<script>alert('验证码错误~');location.href='login.php'</script>";
            exit;
        }
        if($_POST['manager'] == $res['admin'] && sha1($_POST['pwd']) == $res['password']){
            $_SESSION['admin'] = $_POST['manager'];
            header('location:index.php');
            exit;
        }else{
            echo "<script>alert('登录失败,请重新登陆~');location.href='login.php'</script>";
            exit;
        }
    }
?>
<!doctype html>
<html lang="zh_cn">
<head>
    <meta charset="UTF-8">
    <link  rel="stylesheet" type="text/css" href="css/login.css" />
    <script src="js/jquery.min.js"></script>
    <title>后台登陆</title>
</head>
<body>
    <form action="login.php" method="post">
        <h4>管理员登录</h4>
        <p>管理员账户：<input type="text" name="manager" class="text"></p>
        <p>管理员密码：<input type="password" name="pwd" class="text"></p>
        <p style="height:40px; position: relative">验证码验证：<input type="text" name="code" style="width:80px;height:25px;"><img src="../include/code.php" id="code"></p>
        <p style="text-align:center"><button type="submit" name="sub" value="login">登录</button></p>
    </form>
<script>
    $(function(){
        $('#code').click(function(){
           this.src = "../include/code.php?yzm="+Math.random();
        });
    });
</script>
</body>
</html>
