<?php
if($_GET['userid']){

	$userid = cookie('userid',$_GET['userid']) ;
	
	// $sso = $_COOKIE['sso_session'] = $_GET['HTTP_TOKEN'];
	// var_dump($_COOKIE);exit;
	// var_dump($userid);
	// var_dump($userid);exit;
	// if(isset($userid) && isset($sso)){
		header("location:member.php");
	// }else{
	// 	header("location:login.php");
	// }	
}

function cookie($var, $value = '', $time = 64800, $path = '/', $domain = '.zj3w.net', $s = false)
{
    $_COOKIE[$var] = $value;
    if (is_array($value)) {
        foreach ($value as $k => $v) {
            setcookie($var . '[' . $k . ']', $v, $time, $path, $domain, $s);
        }
    } else {
        setcookie($var, $value, $time, $path, $domain, $s);
   }
 }