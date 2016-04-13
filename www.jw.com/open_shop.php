<?php
include_once('./Common/public.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>充值缴费</title>
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
    <div class="page" id="page-open-shop">
      <!-- 标题栏 -->
			<header class="bar bar-nav">
				<a class="pull-left back" href="member.php">
					<i class="icon iconfont mar0 white">&#xe61b;</i>
				</a>
				<h1 class="title">开通店铺</h1>
			</header>
      <!-- 工具栏 -->
			<nav class="bar bar-tab">
				<span class="toools-bar-but tab-item external" style="cursor:pointer;" id="shop-index" data-but-type="index">
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
				<span class="toools-bar-but tab-item" data-but-type="order" style="cursor:pointer;">
					<i class="icon iconfont">&#xe661;</i>
					<span class="tab-label">订单</span>
				</span>
				<span class="toools-bar-but tab-item active" data-but-type="member" style="cursor:pointer;">
					<i class="icon iconfont">&#xe65e;</i>
					<span class="tab-label">我的</span>
				</span>
			</nav>
      <!--内容区-->
      <div class="content">
        <div class="card select-but" data-index='0' data-is-open="false">
          <div class="card-content">
            <div class="card-content-inner ovfh h50 lh50 pad0"><span class="block w30b fll h50 lh50 marl20">缴纳金额：</span><span class="total-title block w50b fll h50 lh50" data-total-value="580">580元</span></div>
          </div>
        </div>
        <div class="card select-but" data-index='1' data-is-open="false" style="display:none;">
          <div class="card-content">
            <div id="select-pay-type-but" data-is-show="false" class="card-content-inner ovfh h50 lh50 pad0"><span class="block w30b fll h50 lh50 marl20">支付方式：</span><span id="pay-type" data-pay-type-value="2" class="block w50b fll h50 lh50">微信支付</span><span class="block w08b mar0 iconfont flr mar option-status-icon">&#xe600;</span></div>
          </div>
        </div>
        <div class="card rechager-content-block" id="select-pay-type-option-block" >
          <div class="card-content" id="pay-type-lists-block">
          </div>
        </div>
		<div class="w95b h50 lh50 txalc white marauto mart20 bgCB1408 borrad5" id="submit-but">充值</div>
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