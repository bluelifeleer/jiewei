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
    <div class="page" id="page-user-information">
      <!-- 标题栏 -->
			<header class="bar bar-nav">
        <a class="pull-left back " href="family.php">
          <i class="icon iconfont mar0 white">&#xe61b;</i>
        </a>
				<h1 class="title">会员资料</h1>
				<a class="pull-right open-panel" href="javascript:void(0);">
					<i class="icon iconfont marr0 marl10 white">&#xe605;</i>
				</a>
			</header>

			<!-- 工具栏 -->
			<nav class="bar bar-tab">
				<span class="toools-bar-but tab-item " style="cursor:pointer;" id="shop-index" data-but-type="index">
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
			<!-- 这里是页面内容区 -->
			<div class="content bgfff" id="show-infomartion">
        <!--div class="w100b h180">
          <div class="w100b h100 borb1 bcc1c1c1">
            <div class="fll w15b h100"><img src="/sources/images/5111e6f7612b0.jpg" class="block w80 h80 borrad50 mart10 marl20" /></div>
            <div class="fll w70b h100">
              <div class="w100b h30 mart20">
                <span class="inlineblock w30b h30 lh30 marl10">相约巴黎</span>
                <span class="inlineblock w20b h25 lh25 bgCB1408 white txac marl10 borrad5">总监</span>
              </div>
              <div class="w100b">
                <span class="marl10">男</span>
                <span>26岁</span>
              </div>
            </div>
            <div class="fll w5b h100 lh100 iconfont mar0">&#xe63d;</div>
          </div>
          <div class="w100b h40 lh40 borb1 bcc1c1c1">
            <span class="block fll w25b h40 lh40 marl20 txalr">用户名：</span>
            <span class="block fll w65b h40 lh40">bluelife</span>
          </div>
          <div class="w100b h40 lh40 borb1 bcc1c1c1">
            <span class="block fll w25b h40 lh40 marl20 txalr">账号信息：</span>
            <span class="block fll w65b h40 lh40">15167167331</span>
          </div>
        </div>
        <div class="w100b mart20 h50">
          <a href="javascript:void(0);" class="block w90b marauto borrad5 h40 lh40 txalc white bg1EA1F2 marl20 ">加好友</a>
        </div-->
      </div>
    </div>
    <!-- popup, panel 等放在这里 -->
		<div class="panel-overlay"></div>
		<!-- Left Panel with Reveal effect -->
		<div class="panel panel-left panel-reveal">
			<div class="content-block">
				<p>这是一个侧栏</p>
				<p></p>
				<!-- Click on link with "close-panel" class will close panel -->
				<p><a href="#" class="close-panel">关闭</a></p>
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
