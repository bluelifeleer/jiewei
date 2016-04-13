<?php
header("Content-Type:text/html; charset=utf-8");
define("APP_PATH", dirname(__FILE__).DIRECTORY_SEPARATOR);
define("CORE_PATH", dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'initphp'.DIRECTORY_SEPARATOR);
define("CACHE_PATH", dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR.'caches'.DIRECTORY_SEPARATOR);
ini_set('session.cookie_path', '/');
ini_set('session.cookie_domain', '.zj3w.net');
require_once (CORE_PATH.'initphp.php');//导入配置文件-必须载入
require_once (APP_PATH.'conf/comm.conf.php');//公用配置
if(isset($_SERVER['HTTP_TOKEN']) && $_SERVER['HTTP_TOKEN'] !='' &&   $_SERVER['HTTP_TOKEN']!='undefined'){
	initPHP::getUtils('cookie')->set('sso_session', $_SERVER['HTTP_TOKEN'],time()+86400,'/','zj3w.net');
	$_COOKIE['sso_session'] =  $_SERVER['HTTP_TOKEN'];
}
/*
 *	初始化框架
 */
InitPHP::init();
