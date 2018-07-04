<?php
require '../include/init.php';
if(!isset($_SESSION['admin'])){
    echo "<script>alert('非法操作,请登录~');location.href='login.php'</script>";
        exit;//终止下面程序运行
    }
    ?>
    <!doctype html>
    <html lang="zh_cn">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="css/frame.css" />
        <style type="text/css">
            #list{width:200px;margin:50px;}
            #list h3{cursor:pointer;font-size: 16px; line-height:22px;color:#00bff3;}
            #list a{display:block;line-height:24px;color:#00bff3;}
            #list div{display:none;border: #00bff3;}
        </style>
        <script src="js/jquery.min.js"></script>
        <script type="text/javascript">
        //window.onload表示页面加载完毕后执行
        //window.onresize表示窗口触发事件的时候执行
        //两个函数，用闭包包裹起来()()
        window.onload = function () {(
            window.onresize = function () {
                var height = document.documentElement.clientHeight - 100;
                //如果有高度，给值
                if (height >= 0) {
                    document.getElementById('sidebar').style.height = height + 'px';
                    document.getElementById('frame').style.height = height + 'px';
                }
            })()};
        </script>
        <title>后台管理</title>
    </head>
    <body>
        <header id="header">
            <div class="logo">
                <h1>后台管理中心</h1>
            </div>
            <div class="info">
                您好，<?php echo $_SESSION['admin'];?> [<a href="../index.php" target="_blank">去首页</a>] | [<a href="login.php">退出</a>]
            </div>
        </header>
        <aside id="sidebar">
            <div id="list">
            <h3><a href="main.php" target="frame">后台首页</a></h3>
                <h3><a href="food_announcement.php" target="frame">公告管理</a></h3>

                <h3>菜品管理</h3>
                    <a href="food_add.php" target="frame">菜品添加</a>
                    <a href="food_manage.php" target="frame">菜品删除与修改</a>

                <!--<h3><a href="food_tuijian.php" target="frame">今日推荐</a></h3>-->

                <h3>库存管理</h3>

                    <a href="food_jia.php" target="frame">库存增加</a>
                    <a href="food_sub.php" target="frame">库存删除</a>

                <h3><a href="member_manage.php" target="frame">会员管理</a></h3>
                <h3><a href="cart_manage.php" target="frame">订座管理</a></h3>
            </div>
        </aside>

        <div id="frame">
            <iframe src="main.php" frameborder="0" width="100%" height="100%" name="frame" ></iframe>
        </div>
    </body>
    </html>
<script>
    /*function $(id){return document.getElementById(id)}
    window.onload = function(){
        $("list").onclick = function(e){
            var src = e?e.target:event.srcElement;
            if(src.tagName == "H3"){
                var next = src.nextElementSibling || src.nextSibling;
                next.style.display = (next.style.display =="block")?"none":"block";
            }
        }
    }*/
</script>
