<?php
/**
 * 计划任务
 * 执行 订单提成处理
 */
header("Content-Type:text/html; charset=utf-8");
define("APP_PATH", dirname(__FILE__).DIRECTORY_SEPARATOR);
define("CORE_PATH", dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'initphp'.DIRECTORY_SEPARATOR);
define("CACHE_PATH", dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR.'caches'.DIRECTORY_SEPARATOR);
require_once (CORE_PATH.'initphp.php');//导入配置文件-必须载入
require_once (APP_PATH.'conf/comm.conf.php');//公用配置
/*
 *	初始化框架
 */
InitPHP::cli_init($argv);
/**
 * Begin Work Start
 */

