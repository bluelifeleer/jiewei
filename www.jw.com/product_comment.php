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
		<meta name="keyworks" content="界微科技--商品评论页面" />
		<link rel="stylesheet" href="/sources/css/sm.min.css"/>
        <link rel="stylesheet" href="/sources/css/sm-extend.min.css"/>
		<link rel="stylesheet" href="/sources/css/demos.css">
		<link rel="stylesheet" href="/sources/css/add.css">
	</head>
	<body>
		<div class="page" id="page-comment">
			<!--头部-->
			<header class="bar bar-nav">
				<a class="pull-left back" id="backProduct" href="order.php?order_type=4">
					<i class="icon iconfont mar0 white fs13">&#xe61b;</i>
				</a>
				<h1 class="title" ><span class="white">产品评价</span></h1>
				<span class="pull-right product-comment-goto-cart">
					<i class="icon iconfont mar0 white fs13">&#xe605;</i>
				</span>
			</header>

			<!--工具栏-->
			<nav class="bar bar-tab">
				<span class="toools-bar-but tab-item external" style="cursor:pointer;" id="shop-index" data-but-type="index">
					<i class="icon iconfont">&#xe640;</i>
					<span class="tab-label">首页</span>
				</span>
				<span  class="inlineblock tab-item  w10b open-share-popup">
					<i class="iconfont block">&#xe601;</i>
					<span class="block fs06">分享</span>
				</span>
				<div  class="w40b tab-item  bgcF3720E white fs06 open-add-cart" data-fn="add-cart" style="color:#FFF;cursor: pointer;">加入购物车</div>
				<div  class="w40b tab-item  fs06 bgcFF3200 white open-buy-popup" data-fn="new-shop" style="color:#FFF;cursor: pointer;">立即购买</div>
			</nav>

			<!--内容-->
			<div class="content infinite-scroll infinite-scroll-bottom" data-distance="100">
				<!--评论内容列表区块-->
				<div class="comment-content-list-block w100b padt10">
					<!-- <div class="card mar0 pad5 marb10">
						<div class="h30" style="line-height:30px;">
							<div class="w10b fll">
								<img class="w30 h30 borrad50" src="/sources/images/59d348e0f2e38b5994756c520f3d8e37.jpg" alt="">
							</div>
							<div class="w90b flr">
								<span class="fll marl5">alksdfa</span>
								<span class="flr c666 fs06">3928-84-74</span>
								<div class="clear"></div>
							</div>
							<div class="clear"></div>
						</div>
						<div class="padt5 padb5">
							laksdjfoawjeflaksjdfklajsdfkjasdfk
						</div>
					</div> -->
				</div>
				<!-- 加载提示符 -->
				<div class="infinite-scroll-preloader c999 fs07">
					<div class="preloader"></div>
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
