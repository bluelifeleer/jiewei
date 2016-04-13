<?php
include_once('./Common/public.php');
$memebrInfo = getMemebrInfo();
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
    <div class="page" id="page-into-member">
      <!-- 标题栏 -->
			<header class="bar bar-nav">
				<a class="pull-left back" href="member.php">
					<i class="icon iconfont mar0 white">&#xe61b;</i>
				</a>
				<h1 class="title">申请开店</h1>
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
      	<div class="content-padded">
      	<h5 class="custom-level-title">
             尊贵的<span class="js-custom-level">V<?php echo $memebrInfo['levels']?> 会员</span>,您目前尚未获得开店权益！<br>
        </h5>
        <h6 class="custom-level-title">快速获取 ① :<span style="color:#666;padding:10px;font-size:0.55rem;">一次性缴纳系统服务费580元<?php if($memebrInfo['levels'] < 1){echo ',且为v1会员';}?></span></h6>
        <h6 class="custom-level-title">快速获取 ② :<span style="color:#666;padding:10px;font-size:0.55rem;">业绩累计达到580元后缴纳系统服务费用580元<?php if($memebrInfo['levels'] < 1){echo ',且为v1会员';}?></span></h6>
        </div>
        <a id="openshop"  class="block w95b h40 lh40 txac borrad5 white marauto  bgfa6a0b ">缴费去</a>
        <span id="gosale" class="block w95b h40 lh40 txac borrad5 white marauto  bg06BE04 mart20">赚钱去</span>
       
        <div class="fs08 padt10" style="color:#666;padding:10px;font-size:0.55rem;">
        	温馨提示：请您在开店信息填写中,正确填写收货地址.店铺开通后,
        	我们将赠送您价值280元的开店大礼包并包邮快递到您手中.
        	若因地址及收件人信息不正确,导致无法收到大礼包,概不补偿！(^o^)
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
