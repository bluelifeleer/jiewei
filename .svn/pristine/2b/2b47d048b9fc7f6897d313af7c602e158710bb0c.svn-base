<?php
session_start();
$_YunUser = isset($_GET['YunUser'])?trim($_GET['YunUser']):'0';
$_YunUser = $_YunUser =='null' ? 0 : $_YunUser;
$YunUser = isset($_COOKIE['YunUser'])?$_COOKIE['YunUser']:0;
if($_YunUser == $YunUser && $_YunUser == 0){
      $YunUser = 1;
}else{
    $YunUser = $_YunUser ? $_YunUser : $YunUser;
}
$_COOKIE['YunUser'] = $YunUser;
setcookie("YunUser",$YunUser, time()+3600*24,'/','.zj3w.net');
/***************************************************************/
$site['title'] = '云兆•云商城';

function getRedis($key,$function='get',$redisdb='8'){
	$redisConf['server'] = '10.162.102.3';
	$redisConf['port']   = '6300';
	$redisConf['auth']   = 'j!e@i#w$e%i123';
	$redis=new Redis();
    $redis->connect($redisConf['server'], $redisConf['port']);
    $redis->auth($redisConf['auth']);
    $redis->select($redisdb);
    return $redis->$function($key);
}

/**
 * 获取用户信息
 * @return [type] [description]
 */
function getMemebrInfo(){
    $sso_session = getRedis($_COOKIE['sso_session'],'hgetall');
    $userid = $sso_session['_userid'];
    if(!$userid)return false;
    return getRedis('userinfo:'.$userid,'hgetall');
}