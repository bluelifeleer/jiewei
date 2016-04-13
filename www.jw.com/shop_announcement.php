<?php
include_once('./Common/public.php');
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
		<div class="page" id="page-shop-announcement">
			<!-- 标题栏 -->
			<header class="bar bar-nav">
        		<a class="pull-left back " href="shop_manager.php">
					<i class="icon iconfont mar0 white">&#xe64c;</i>
				</a>
				<h1 class="title">店铺公告</h1>
				<a class="flr  white inlineblock h56 lh56 " href="javascript:void(0);" id="finish" style="position:absolute;right:10px;top:0;z-index:9999">完成</a>
			</header>

			<!-- 工具栏 -->
			<nav class="bar bar-tab">
				close-panel
			</nav>
			<!-- 这里是页面内容区 -->
			<div class="content bgEEEEEE">
        		<div id="shop-announcement" contenteditable="true" class="block w90b h100 bgfff marauto mart20 bor1 bcc1c1c1 c8F8F90">填写店铺公告</div>
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
