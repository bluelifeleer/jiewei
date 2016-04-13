<?php
/*********************************************************************************
 * InitPHP 3.8.1 国产PHP开发框架
 *-------------------------------------------------------------------------------
 * 版权所有: CopyRight By initphp.com
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 *-------------------------------------------------------------------------------
 * Author:zhuli Dtime:2014-11-25
 ***********************************************************************************/
/* 框架全局配置变量 */
$InitPHP_conf = array();
/*********************************基础配置*****************************************/
/**
 * 站点URL配置
 * 必选参数
 */
$InitPHP_conf['url'] = 'http://order.zj3w.net/';
/*
 *    静态资源CDN
 */
#$InitPHP_conf['static'] = 'http://statics.jw.com/web/';
#$InitPHP_conf['static'] = './sources/web/';
/**
 * 是否开启调试
 */
$InitPHP_conf['is_debug']       = false; //开启-正式上线请关闭
$InitPHP_conf['show_all_error'] = false; //是否显示所有错误信息，必须在is_debug开启的情况下才能显示
/**
 * 日志目录
 */
$InitPHP_conf['log_dir'] = '/var/logs/website/'; //日志目录,必须配置
/**
 * 路由访问方式
 * 1. 如果为true 则开启path访问方式，否则关闭
 * 2. default：index.php?m=user&c=index&a=run
 * 3. rewrite：/user/index/run/?id=100
 * 4. path: /user/index/run/id/100
 * 5. html: user-index-run.htm?uid=100
 * 6. 开启PATH需要开启APACHE的rewrite模块，详细使用会在文档中体现
 *
 *
 *
 *
 */
$InitPHP_conf['isuri'] = 'path';
/**
 * 是否开启输出自动过滤
 * 1. 对多人合作，安全性可控比较差的项目建议开启
 * 2. 对HTML进行转义，可以放置XSS攻击
 * 3. 如果不开启，则提供InitPHP::output()函数来过滤
 */
$InitPHP_conf['isviewfilter'] = true;
/*********************************Service配置*****************************************/
/**
 * Service配置参数
 * 1. 你可以配置service的路径和文件（类名称）的后缀名
 * 2. 一般情况下您不需要改动此配置
 */
$InitPHP_conf['function']['path'] = 'library/functions/'; //service路径
/*********************************Service配置*****************************************/
/**
 * Service配置参数
 * 1. 你可以配置service的路径和文件（类名称）的后缀名
 * 2. 一般情况下您不需要改动此配置
 */
$InitPHP_conf['service']['service_postfix'] = 'Service'; //后缀
$InitPHP_conf['service']['path']            = 'library/service/'; //service路径
/*********************************DAO数据库配置*****************************************/
/**
 * Dao配置参数
 * 1. 你可以配置Dao的路径和文件（类名称）的后缀名
 * 2. 一般情况下您不需要改动此配置
 */
$InitPHP_conf['dao']['dao_postfix'] = 'Dao'; //后缀
$InitPHP_conf['dao']['path']        = 'library/dao/'; //后缀
/**
 * 数据库配置
 * 1. 根据项目的数据库情况配置
 * 2. 支持单数据库服务器，读写分离，随机分布的方式
 * 3. 可以根据$InitPHP_conf['db']['default']['db_type'] 选择mysql mysqli（暂时支持这两种）
 * 4. 支持多库配置 $InitPHP_conf['db']['default']
 * 5. 详细见文档
 */

/*********************************Controller配置*****************************************/
/**
 * Controller控制器配置参数
 * 1. 你可以配置控制器默认的文件夹，默认的后缀，Action默认后缀，默认执行的Action和Controller
 * 2. 一般情况下，你可以不需要修改该配置参数
 * 3. $InitPHP_conf['ismodule']参数，当你的项目比较大的时候，可以选用module方式，
 * 开启module后，你的URL种需要带m的参数，原始：index.php?c=index&a=run, 加module：
 * index.php?m=user&c=index&a=run , module就是$InitPHP_conf['controller']['path']目录下的
 * 一个文件夹名称，请用小写文件夹名称
 */
$InitPHP_conf['ismodule']                         = true; //开启module方式
$InitPHP_conf['controller']['path']               = 'api/';
$InitPHP_conf['controller']['controller_postfix'] = 'Controller'; //控制器文件后缀名
$InitPHP_conf['controller']['action_postfix']     = ''; //Action函数名称后缀
$InitPHP_conf['controller']['default_controller'] = 'index'; //默认执行的控制器名称
$InitPHP_conf['controller']['default_action']     = 'init'; //默认执行的Action函数
include 'module.conf.php';
$InitPHP_conf['controller']['default_module']        = 'order'; //默认执行module
$InitPHP_conf['controller']['default_before_action'] = 'before'; //默认前置的ACTION名称
$InitPHP_conf['controller']['default_after_action']  = 'after'; //默认后置ACTION名称
/*********************************View配置*****************************************/
/**
 * 模板配置
 * 1. 可以自定义模板的文件夹，编译模板路径，模板文件后缀名称，编译模板后缀名称
 * 是否编译，模板的驱动和模板的主题
 * 2. 一般情况下，默认配置是最优的配置方案，你可以不选择修改模板文件参数
 */
$InitPHP_conf['template']['template_path']   = 'web/template'; //模板路径
$InitPHP_conf['template']['template_c_path'] = 'data/template_c'; //模板编译路径
$InitPHP_conf['template']['template_type']   = '.html'; //模板文件类型
$InitPHP_conf['template']['template_c_type'] = '.tpl.php'; //模板编译文件类型
$InitPHP_conf['template']['is_compile']      = true; //模板每次编译-系统上线后可以关闭此功能
$InitPHP_conf['template']['driver']          = 'simple'; //不同的模板驱动编译
$InitPHP_conf['template']['theme']           = 'default'; //模板主题
/**
 * Redis配置，如果您使用了redis，则需要配置
 */
$InitPHP_conf['redis']['default']['server'] = '10.162.102.3';
$InitPHP_conf['redis']['default']['port']   = '6300';
$InitPHP_conf['redis']['default']['auth']   = 'j!e@i#w$e%i123';
$InitPHP_conf['redis']['default']['select'] = 8;
/**
 * 订单仓库
 */
$InitPHP_conf['redis']['order']['server'] = '10.162.102.3';
$InitPHP_conf['redis']['order']['port']   = '6300';
$InitPHP_conf['redis']['order']['auth']   = 'j!e@i#w$e%i123';
$InitPHP_conf['redis']['order']['select'] = 10;

/**
 * sission配置
 * type session储存类型   默认为file类型    可选(file,redis)
 * 如果选择redis则需要配置redis 连接配置   支持分布式
 */
$InitPHP_conf['session']['type']             = 'redis';
$InitPHP_conf['session']['redis']['timeout'] = 1200;
$InitPHP_conf['session']['redis']['server']  = '10.162.102.3';
$InitPHP_conf['session']['redis']['port']    = '6300';
$InitPHP_conf['session']['redis']['auth']    = 'j!e@i#w$e%i123';
$InitPHP_conf['session']['redis']['select']  = 8;
/*********************************RPC服务*****************************************/
//$InitPHP_conf['provider']['allow_ip'] = array();
$InitPHP_conf['customer'] = array(
    "default" => array( //可以进行分组
        "host" => array("service.yunzhao"), //服务提供者所在的服务器的IP地址，一般是内网IP地址。可以填写多台服务器
        "file" => "index.php", //访问服务的入口文件，例如加上IP地址：http://localhost/rpc.php
    ),
);

/*********************************Error*****************************************/
/**
 * Error模板
 * 如果使用工具库中的error，需要配置
 */
$InitPHP_conf['error']['template'] = 'library/helper/error.tpl.php';

/**
 * 数据库配置
 * 1. 根据项目的数据库情况配置
 * 2. 支持单数据库服务器，读写分离，随机分布的方式
 * 3. 可以根据$InitPHP_conf['db']['default']['db_type'] 选择mysql mysqli（暂时支持这两种）
 * 4. 支持多库配置 $InitPHP_conf['db']['default']
 * 5. 详细见文档
 */
$InitPHP_conf['db']['driver'] = 'mysqli'; //选择不同的数据库DB 引擎，一般默认mysqli,或者mysql
//default数据库配置 一般使用中 $this->init_db('default')-> 或者 $this->init_db()-> 为默认的模型
$InitPHP_conf['db']['default']['db_type']     = 0; //0-单个服务器，1-读写分离，2-随机
$InitPHP_conf['db']['default'][0]['host']     = 'rdsp5ibrufs13b6ofm84.mysql.rds.aliyuncs.com:3308'; //主机
$InitPHP_conf['db']['default'][0]['username'] = 'yunsoft'; //数据库用户名
$InitPHP_conf['db']['default'][0]['password'] = 'yunsoft'; //数据库密码
$InitPHP_conf['db']['default'][0]['database'] = 'jiewei'; //数据库

$InitPHP_conf['db']['default'][0]['charset']  = 'utf8'; //数据库编码
$InitPHP_conf['db']['default'][0]['pconnect'] = 0; //是否持久链接