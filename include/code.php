<?php
session_start();
ob_clean();
//验证码宽度
$width = 100;
//验证码高度
$height = 35;
//验证码位数
$num = 4;
//验证码字符串初始化
$code = '';

//随机产生十六进制的字符串
for($i = 0; $i < $num; $i++){
    $code .= dechex(mt_rand(0,15));
}

//存储在session中
$_SESSION['code'] = $code;


//创建一个图像
$img = imagecreatetruecolor($width,$height);

//创建白色
$white = imagecolorallocate($img,255,255,255);

//填充白色
imagefill($img, 0, 0, $white);


//绘制黑色边框
/*if($border=="yes"){
    $black = imagecolorallocate($img,0,0,0);
    imagerectangle($img, 0, 0, $width-1, $height-1, $black);
}*/
//绘制6条线条
for($i=0;$i<6;$i++){
    $color = imagecolorallocate($img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
    imageline($img, mt_rand(0,$width), mt_rand(0,$height), mt_rand(0,$width), mt_rand(0,$height), $color);
}
//绘制雪花
for($i=0;$i<100;$i++){
    $color = imagecolorallocate($img,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255));
    imagestring($img,1,mt_rand(1,$width-3),mt_rand(1,$height-3),"*",$color);
}
//输出验证码
for($i=0;$i<strlen($_SESSION['code']);$i++){
    $color = imagecolorallocate($img,mt_rand(0,100),mt_rand(0,150),mt_rand(0,200));
    imagestring($img, 5, $i*($width/$num)+mt_rand(1,10), mt_rand($i,$height/2), $_SESSION['code'][$i], $color);
}
//输出图像
header("Content-type: image/png");
imagepng($img);

//销毁
imagedestroy($img);