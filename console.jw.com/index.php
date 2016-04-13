<?php
header("Content-Type:text/html; charset=utf-8");
define("APP_PATH", dirname(__FILE__).DIRECTORY_SEPARATOR);
define("CORE_PATH", dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'initphp'.DIRECTORY_SEPARATOR);
define("CACHE_PATH", dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR.'caches'.DIRECTORY_SEPARATOR);
define('IN_ADMIN', true);
require_once (CORE_PATH.'initphp.php');//导入配置文件-必须载入
require_once (APP_PATH.'conf/comm.conf.php');//公用配置
/*
 *  初始化框架
 */
InitPHP::init();



