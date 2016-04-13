<?php
include_once('./Common/public.php');
// echo urlencode('http://www.zj3w.net/member.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>云兆●云商城</title>
		<meta name="viewport" content="initial-scale=1, maximum-scale=1">
		<link rel="shortcut icon" href="/favicon.ico">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<link rel="stylesheet" href="/sources/css/sm.min.css"/>
    <link rel="stylesheet" href="/sources/css/sm-extend.min.css"/>
		<link rel="stylesheet" href="/sources/css/demos.css">
		<link rel="stylesheet" href="/sources/css/add.css">
	</head>
	<body>
    	<!-- page 容器 -->
		<div class="page" id="page-login">
			<!-- 标题栏 -->
			<header class="bar bar-nav">
				<h1 class="title">登录</h1>
				<a class="pull-left external" id="shop-index" href="index.php">
					<i class="icon iconfont mar0 white fs13">&#xe66d;</i>
				</a>
			</header>
			<div class="content">
				<div class="page-login">
					<div class="list-block mar15 borl1 borr1 bce6">
						<ul>
							<li class=" borb1 bce6" style="position:relative;left:0;top:0;">
								<input id="account" value="" type="text" placeholder="手机号码">
							</li>
							<li>
								<input id="password" value="" type="password" placeholder="密码">
							</li>
						</ul>
					</div>
					<div class="content-block mar15 pad0">
						<p class="mar0 mart10"><div style="cursor:pointer;" id="login-in-but" class="block w100b h50 lh50 txac white bgfa6a0b">登录</div></p>
						<p class="mar0 mart10"><a id="wechat-login-but" class="iconfont external block w100b h50 lh50 txac bg06BE04 mar0 white fs10 bor1 bc10A40C borrad6" href="">&#xe66b;&nbsp;微信登录</a></p>
						<div class="fs07 mar0 mart10">
							<div class="fll"><a class="c0079fe" href="register.php">没有帐号？</a></div>
							<div class="flr"><a class="c0079fe" href="find_password.php">忘记密码</a></div>
							<div class="clear"></div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</body>
	<script type="text/javascript" src="/sources/js/zepto-full.1.1.6.min.js"></script>
	<script type="text/javascript" src="/sources/js/sm.min.js" charset="utf-8"></script>
	<script type="text/javascript" src="/sources/js/sm-extend.min.js" charset="utf-8"></script>
	<script type="text/javascript" src="/sources/js/module/public.js"></script>
	<script type="text/javascript" src="/sources/js/module/jweixin-1.0.0.js"></script>
	<script type="text/javascript" src="/sources/js/webuploader.js" charset="utf-8"></script>
	<script type="text/javascript" charset="utf-8" src="/sources/js/ueditor/ueditor.config.js"></script>
	<script type="text/javascript" charset="utf-8" src="/sources/js/ueditor/ueditor.all.js"> </script>
	<script type="text/javascript" charset="utf-8" src="/sources/js/ueditor/lang/zh-cn/zh-cn.js"></script>
	<script type='text/javascript' data-main="/sources/js/app.js" src='/sources/js/require.js' charset='utf-8'></script>
</html>
