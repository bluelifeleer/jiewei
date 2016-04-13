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
		<div class="page" id="page-order">
			<!-- 标题栏 -->
			<header class="bar bar-nav">
				<h1 class="title" id="order-page-title">我的订单</h1>
				<a class="pull-left external" href="member.php">
					<i class="icon iconfont mar0 fs13 white">&#xe61b;</i>
				</a>
			</header>
			<div class="w100b pos-a borb1 bce6" style="position:absolute;top:2.2rem;z-index:99999;">
				<div class="row no-gutter txac bgfff fs06">
						<div class="order-page-bf col-20 padt8 padb8 borb2 bcfff mar0" style="width:16.66666%">
							<a class="c333 external" href="order.php?order_type=">全部</a></div>
						<div class="order-page-bf col-20 padt8 padb8 borb2 bcfff" style="width:16.66666%">
							<a class="c333 external" href="order.php?order_type=1">待付款</a>
						</div>
						<div class="order-page-bf col-20 padt8 padb8 borb2 bcfff" style="width:16.66666%">
							<a class="c333 external" href="order.php?order_type=2">待发货</a>
						</div>
						<div class="order-page-bf col-20 padt8 padb8 borb2 bcfff" style="width:16.66666%">
							<a class="c333 external" href="order.php?order_type=3">待收货</a>
						</div>
						<div class="order-page-bf col-20 padt8 padb8 borb2 bcfff" style="width:16.66666%">
							<a class="c333 external" href="order.php?order_type=4">已完成</a>
						</div>
						<div class="order-page-bf col-20 padt8 padb8 borb2 bcfff" style="width:16.66666%">
							<a class="c333 external" href="order.php?order_type=6">售后</a>
						</div>
					</div>
				</div>
			<!-- 工具栏 -->
			<nav class="bar bar-tab">
				<span class="toools-bar-but tab-item" style="cursor:pointer;" id="shop-index" data-but-type="index">
					<i class="icon iconfont">&#xe640;</i>
					<span class="tab-label">首页</span>
				</span>
				<span class="toools-bar-but tab-item" style="cursor:pointer;">
					<i class="icon iconfont">&#xe684;</i>
				<span class="tab-label">云兆云商</span>
				</span>
				<span class="toools-bar-but tab-item" data-but-type="cart" style="cursor:pointer;">
					<i class="icon iconfont">&#xe62e;</i>
					<span class="tab-label">购物车</span>
				</span>
				<span class="toools-bar-but tab-item active" data-but-type="order" style="cursor:pointer;">
					<i class="icon iconfont">&#xe661;</i>
					<span class="tab-label">订单</span>
				</span>
				<span class="toools-bar-but tab-item" data-but-type="member" style="cursor:pointer;">
					<i class="icon iconfont">&#xe65e;</i>
					<span class="tab-label">我的</span>
				</span>
			</nav>
			<div class="content  infinite-scroll" data-distance="100" style="margin-top:38px;">
				<!-- 默认的下拉刷新层 -->
				<!-- <div class="pull-to-refresh-layer">
						<div class="preloader"></div>
						<div class="pull-to-refresh-arrow"></div>
				</div> -->
				<div id="all-order-list-block"></div>
		      
		      <!-- 加载提示符 -->
		      <div class="infinite-scroll-preloader">
		      		<div class="preloader"></div>
		      		<div class="preloader_null disn fs06">没有更多的订单了</div>
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
