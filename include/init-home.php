<?php
header("Content-type:text/html;charset=utf-8");
ini_set("display_errors", 1); //‘display_errors'：设置php.ini配置
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED); //除去后面这三个的错误提醒；
date_default_timezone_set('Asia/Shanghai');//设置时区
if(!defined('ROOT_PATH')) {
    //dirname(__FILE__) 函数返回的是脚本所在在的绝对路径
define('ROOT_PATH',substr(dirname(__FILE__),0,-7));//取路径，设置为常量；
}
require(ROOT_PATH."include/config.php");
require(ROOT_PATH."include/mysql.class.php");
require(ROOT_PATH."include/common.php");
if(!defined('__ROOT__')) {
        //$_SERVER['SCRIPT_NAME']当前脚本路径
	$_root=dirname(rtrim($_SERVER['SCRIPT_NAME'],'/'));
     define('__ROOT__',  (($_root=='/' || $_root=='\\')?'':$_root));
}
foreach($_REQUEST as $k=>$v) {
	if(is_array($v)) {
		foreach($v as $k2=>$v2) {
			if(htmlspecialchars($v2,ENT_QUOTES) != $v2) {
				$_REQUEST[$k][$k2]=htmlspecialchars($v2,ENT_QUOTES);
			}
		}
	} else {
		if(htmlspecialchars($v,ENT_QUOTES) != $v) {
			$_REQUEST[$k]=htmlspecialchars($v,ENT_QUOTES);
		}
	}
}

$db = new mysql($config['DB']['dbhost'],$config['DB']['dbuser'],$config['DB']['dbpwd'],$config['DB']['dbname']);
$_cfg=$db->queryArray("select * from config");//执行sql语句
foreach ($_cfg as $c){
	$cfg[$c['code']]=$c['value'];//遍历数据
}
session_start();//开启session