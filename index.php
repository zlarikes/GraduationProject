<?php
require 'include/init.php';
//读取公告
$announce = $db->queryOne("select * from f_announce order by id desc limit 1");
//判读登录用户身份
if(isset($_SESSION['userName'])){
  $tempList = $db->queryOne("select * from f_member where name='{$_SESSION['userName']}' and type=1");
//  echo $tempList['type'];exit();
}
//热销
$hotList = $db->queryArray("select * from f_foods where food_hot=1");

//分页
if(isset($_GET['type'])){
  $type = $_GET['type'];
  $rowCount = $db->queryNum("select * from f_foods where type=$type");
}
//记录总数
$rowCount = $db->queryNum("select * from f_foods");
//一个页面记录数
$pageSize = 8;
//总页数
$pageCount = ceil($rowCount/$pageSize);
//当前页
if(empty($_GET['page'])){
  $pageNow = 1;
}else{
  $pageNow = $_GET['page'];
}

$list = $db->queryArray("select * from f_foods limit ".($pageNow-1)*$pageSize.",$pageSize");
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>theme restaurant</title>
  <script src="js/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="css/base.css">
  <link rel="stylesheet" type="text/css" href="css/block.css">
  <script src="js/slide.js">  </script>
</head>
<body>
 <div class="layoutOther">
  <b> 当前访客身份 ：<?php if(isset($_SESSION['userName'])) echo "<a href='personal.php'>".$_SESSION['userName']."</a> <a href='logout.php'>[退出]</a>";else echo "游客 [ <a href='login.php'> 登录 </a> ]";?>[ <a href='login.php?act=waiter'> 服务员登录 </a> ]</b>
  <p>甜 点 主 题 屋</p>
  <div class="wrap">
    <marquee class="announcement" scrollAmount=2 ><span style="color:red;font-weight: bold">最新公告：</span><?php echo $announce['content']; ?></marquee>
    <script language=JavaScript>
      today=new Date();
      function initArray(){
        this.length=initArray.arguments.length
        for(var i=0;i<this.length;i++)
          this[i+1]=initArray.arguments[i] }
        var d=new initArray(
          "星期日",
          "星期一",
          "星期二",
          "星期三",
          "星期四",
          "星期五",
          "星期六");
        document.write(
          "<font color=#333 style='font-size:14pt;font-family: 宋体'> ",
          today.getFullYear(),"年",
          today.getMonth()+1,"月",
          today.getDate(),"日",
          d[today.getDay()+1],
          "</font>" ); 
        </script>
        <!-- 导航栏 -->
        <ul id="tabul" style="position: relative;z-index: 999;" class="nav-menu clearfix unstyled">
          <li tip="top"><a   class="three-d active" > 首页<span class="three-d-box"><span class="front">首页</span><span class="back">首页</span></span> </a></li>
          <!--  <li ><a href="menu.php" target="frame" class="three-d" > 菜单 <span class="three-d-box"><span class="front">菜单</span><span class="back">菜单</span></span> </a></li> -->
          <li tip="cart" ><a   class="three-d" > 订座中心 <span class="three-d-box"><span class="front">订座中心</span><span class="back">订座中心</span></span> </a></li>
          <li tip="shopping"><a  class="three-d"> 购物车 <span class="three-d-box"><span class="front">购物车</span><span class="back">购物车</span></span> </a></li>
          <li tip="collect"><a   class="three-d"> 收藏夹 <span class="three-d-box"><span class="front">收藏夹</span><span class="back">收藏夹</span></span> </a></li>

          <?php if($tempList['type'] != 1){
            echo ' <li ><a href="#" class="three-d"> 个人中心 <span class="three-d-box"><span class="front">个人中心</span><span class="back">个人中心</span></span></a>';
            echo '<ul class="clearfix unstyled drop-menu">';
            echo '<li tip="person_book"><a   class="three-d"> 个人订单 <span class="three-d-box"><span class="front">个人订单</span><span class="back">个人订单</span></span> </a></li>';
            echo '<li tip="person_table"><a   class="three-d">个人订座 <span class="three-d-box"><span class="front">个人订座</span><span class="back">个人订座</span></span> </a></li>';
            echo '<li tip="personal"><a  class="three-d"> 个人资料 <span class="three-d-box"><span class="front">个人资料</span><span class="back">个人资料</span></span> </a></li>';
            echo '</ul>';
            echo '</li>';
          }else{
            echo '<li tip="waiter"><a  class="three-d"> 管理中心 <span class="three-d-box"><span class="front">管理中心</span><span class="back">管理中心</span></span> </a></li>';
          }
          ?>
          <li><a href="admin/login.php" class="three-d" target="_blank"> 后台管理 <span class="three-d-box"><span class="front">后台管理</span><span class="back">后台管理</span></span> </a></li>
        </ul>
        <!-- 导航栏end -->
        <!--菜单 -->
        <div class="top">
          <div class="menu">
            <ul>
              <li id="10"><a href="javascript:void(0);">全 部</a></li>
              <li id="1"><a href="javascript:void(0);">特 色 推 荐</a></li>
              <li id="2"><a href="javascript:void(0);">冷 饮</a></li>     
              <li id="3"><a href="javascript:void(0);">热 饮</a></li>
              <li id="4"><a href="javascript:void(0);">甜 品</a></li>     
              <li id="5"><a href="javascript:void(0);">冰淇淋</a></li>     
              <li id="6"><a href="javascript:void(0);">烧仙草</a></li>
              <li><input style="width:150px" id="searchTxt" type="text" placeholder="请输入想查找的菜名"></li>
              <li><input type="button" id="search" value="搜索" onclick="Searchfood();"></li>
            </ul>
            <div class="clean"></div>
            <div class="main">
              <div id="div1"></div>
              <div class="page">
                <ul>
                  <?php if($pageNow!=1)
                  echo '<li><a href="index.php?page=1">首页</a></li>';
                  ?>

                  <?php if($pageNow<=1){}else{
                    echo '<li><a href="index.php?page='.($pageNow-1).'">上一页</a></li>';
                  } ?>
                  <?php if($pageNow>=$pageCount){}else{
                    echo '<li><a href="index.php?page='.($pageNow+1).'">下一页</a></li>';
                  } ?>
                  <?php if($pageNow!=$pageCount)
                  echo "<li><a href='index.php?page=$pageCount'>尾页</a></li>";
                  ?>
                </ul>
              </div>
            </div>
          </div>
          <div class="rexiao">
            <p>热销榜</p>
            <ul border="1">
              <?php foreach($hotList as $k=>$v) { ?>
              <li>
                <a href="detail_menu.php"><img src="upload/<?php echo $v['img']; ?>"></a> 
              </li>
              <?php }
              ?>
            </ul>
          </div>
        </div>
        <script>
          $(function(){
    //初始化
    getHtml('0');

    $('ul>li').live('click',function(){
      var index = $(this).index();
      var tip= $(this).attr("tip");
      if(tip=="top"){
        $(".top").show();
        $("#mainIndex").hide();
      }else if(tip=="shopping"){
        $(".top").hide(); 
        $("#mainIndex").attr("src","shopping.php").show();
      }else if(tip=="cart"){
       $(".top").hide(); 
       $("#mainIndex").attr("src","cart.php").show();
     }else if(tip=="collect"){
       $(".top").hide();
       $("#mainIndex").attr("src","collect.php").show();
     }else if(tip=="person_table"){
       $(".top").hide();
       $("#mainIndex").attr("src","person_table.php").show();
     }else if(tip=="person_book"){
       $(".top").hide();
       $("#mainIndex").attr("src","person_book.php").show();
     }else if(tip=="personal"){
       $(".top").hide();
       $("#mainIndex").attr("src","personal.php").show();
     }else if(tip=="waiter"){
       $(".top").hide();
       $("#mainIndex").attr("src","waiter.php").show();
     }
     if($(this).attr('id') == '10'){
      $('#div1').html('');
      getHtml('0');
    }
     if($(this).attr('id') == '1'){
      $('#div1').html('');
      getHtml('1');
    }
    if($(this).attr('id') == '2'){
      $('#div1').html('');
      getHtml('2');
    }
    if($(this).attr('id') == '3'){
      $('#div1').html('');
      getHtml('3');
    }
    if($(this).attr('id') == '4'){
      $('#div1').html('');
      getHtml('4');
    }
    if($(this).attr('id') == '5'){
      $('#div1').html('');
      getHtml('5');
    }
    if($(this).attr('id') == '6'){
      $('#div1').html('');
      getHtml('6');
    } 
  });
    $('#bug').live('click',function(){
      var loginer = "<?php echo $_SESSION['userName']; ?>";
      //判断有没有登录，没有就不让购买。
      if(loginer == ''){
        alert('请登录~');
        location.href='login.php';
        exit();
      }
      $.ajax({
        type:'post',
        url:'book.php',
        data:{
          'id':$(this).attr('value')
        },
        success:function(){
          alert('加入购物车成功~');
        }
      });
    });

    //收藏
    $('#collect').live('click',function(){
      var loginer = "<?php echo $_SESSION['userName']; ?>";
      //判断有没有登录，没有就不让购买。
      if(loginer == ''){
        alert('请登录~');
        location.href='login.php';
        exit();
      }
      $.ajax({
        type:'post',
        url:'book.php?action=collect',
        data:{
          'id':$(this).attr('value')
        },
        success:function(res){
          alert('收藏成功~');
        }
      });
    });

    function getHtml(type){
      var html = '';
      $.ajax({
        type:"GET",
        url:'page.php',
        data:{'type':type,'page':<?php echo $pageNow ?>},
        cache:false,
        dataType:'json',
        success:function(res){
          $.each(res,function(k,v){
            html +='<dl>';
            html +="<dt><a href='detail_menu.php?img="+v['img']+
            "&food_name="+v['food_name']+"&id="+v['id']+"&food_num="+v['food_num']+
            "&food_price="+v['food_price']+"'><img src='upload/"+v['img']+"'></a></dt>";
            html +="<dd style='width:80px'>"+v['food_name']+"</dd>";
            html +="<dd>"+v['food_price']+"元</dd>";
            html +="<dd><button id='bug' value='"+v['id']+"'>加入购物车</button></dd>";
            html +="<dd><button id='collect' value='"+v['id']+"'>收藏</button></dd>";
            html +='</dl>';
          });
          $('#div1').html(html);
        }
      });
    }
  });
          function Searchfood(){
            var searchTxt = $("#searchTxt").val();
            var html = '';
  //  if(searchTxt != ""){
    $.ajax({
      type:"post",
      url:"search.php",
      data:{"foodName":searchTxt},
      dataType:'json',
      success: function(result){
        //  var res = eval("("+result+")");

        $.each(result.data,function(k,v){
          html +='<dl>';
          html +="<dt><a href='detail_menu.php?img="+v['img']+
          "&food_name="+v['food_name']+"&food_num="+v['food_num']+
          "&food_price="+v['food_price']+"'><img src='upload/"+v['img']+"'></a></dt>";
          html +="<dd style='width:80px'>"+v['food_name']+"</dd>";
          html +='</dl>';
        });
        $('#div1').html(html);
      }
    })
//    }

}
</script>
<div><iframe frameborder="0" id="mainIndex" width="100%" height="100%" src="" ></iframe></div>
<table class="foot">
  <tr>
    <td colspan="4">Copyright? 2016 by 亮 All Rights Reserved</td>
  </tr>
  <tr>
    <td colspan="4">联系方式：13333333333|邮箱：XXXXXXXX@qq.com</td>
  </tr>
  <tr>
    <td>友情链接</td>
    <td><a href="http:/www.baidu.com"><img src="images/baidu.png"></a></td>
    <td><a href="http:/www.qq.com"><img src="images/qq.png"></a></td>
    <td><a href="http://www.sina.com.cn/"><img src="images/sina.png"></a></td>
  </tr>
</table>
</div>
</div>
</body>
</html>