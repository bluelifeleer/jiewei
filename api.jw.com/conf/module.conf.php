<?php
/**
 * @Author: anchen
 * @Date:   2015-12-18 20:21:30
 * @Last Modified by:   anchen
 * @Last Modified time: 2016-03-27 17:52:57
 */

//module白名单
$InitPHP_conf['controller']['module_list'][] = 'account';
//支付模块 by bluelife for 2015-12-19
$InitPHP_conf['controller']['module_list'][] = 'pay';
//充值模块 by bluelife for 2016－02－18
$InitPHP_conf['controller']['module_list'][] = 'recharge';
//售后模块 by bluelife for 2016－02－21
$InitPHP_conf['controller']['module_list'][] = 'afterSales';
//评论模块 by bluelife for 2015-12-20
$InitPHP_conf['controller']['module_list'][] = 'comment';
//会员关系模块 by bluelife for 2015-12-20
$InitPHP_conf['controller']['module_list'][] = 'memberFriend';
//通知消息模块 by bluelife for 2015-12-20
$InitPHP_conf['controller']['module_list'][] = 'message';
//订单模块
$InitPHP_conf['controller']['module_list'][] = 'order';
//公用模块
$InitPHP_conf['controller']['module_list'][] = 'public';
//测试
$InitPHP_conf['controller']['module_list'][] = 'test';
//产品
$InitPHP_conf['controller']['module_list'][] = 'product';
//物流记录
$InitPHP_conf['controller']['module_list'][] = 'logistics';
//收货地址
$InitPHP_conf['controller']['module_list'][] = 'address';
//商品首页
$InitPHP_conf['controller']['module_list'][] = 'index';
//获取用户二维码
$InitPHP_conf['controller']['module_list'][] = 'userQcode';
//店铺服务
$InitPHP_conf['controller']['module_list'][] = 'shop';
//搜索
$InitPHP_conf['controller']['module_list'][] = 'search';

$InitPHP_conf['controller']['module_list'][] = 'wechat';

$InitPHP_conf['controller']['module_list'][] = 'wxpay';

$InitPHP_conf['controller']['module_list'][] = 'paypresent';
