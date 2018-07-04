<?php
header("Content-type:text/html;charset=utf-8");

ini_set("display_errors", 1);
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
date_default_timezone_set('Asia/Shanghai');
if(!defined('ROOT_PATH')) {
define('ROOT_PATH',substr(dirname(__FILE__),0,-7));
}

require(ROOT_PATH."include/config.php");
require(ROOT_PATH."include/mysql.class.php");
require(ROOT_PATH."include/common.php");
if(!defined('__ROOT__')) {
	$now_dir=dirname(rtrim($_SERVER['SCRIPT_NAME'],'/'));
	$_root=rtrim(dirname($now_dir),'/');
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

session_start();