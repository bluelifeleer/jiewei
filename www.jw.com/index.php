<?php
include_once('./Common/public.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $site['title']?></title>
	<meta name="viewport" content="initial-scale=1, maximum-scale=1">
	<link rel="shortcut icon" href="/favicon.ico">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<link rel="stylesheet" href="/sources/css/sm.min.css"/>
	<link rel="stylesheet" href="/sources/css/sm-extend.min.css"/>
	<link rel="stylesheet" href="/sources/css/demos.css">
	<link rel="stylesheet" type="text/css" href="/sources/css/add.css">
<body>

	<!-- page 容器 -->
	<div class="page" id="index-page">

		<input
		type="hidden"
		id="shareData"
		data-title="欢迎访问我的店铺"
		data-desc="我的店铺很简单~~~"
		data-link="http://www.zj3w.net/"
		data-thumb="https://ss1.bdstatic.com/5eN1bjq8AAUYm2zgoY3K/r/www/cache/static/protocol/https/home/img/qrcode/zbios_62c636fe.png"
		/>

		<!-- 标题栏 -->
		<header class="bar bar-nav">
			<div id="shop-info-block" class="w100 fll" style="height:2.2rem;">
				<a class="pull-left">
					<i class="icon iconfont mar0 white fs13">&#xe65e;</i>
				</a>
			</div>
			<h1 class="title" id="shop-title"></h1>

			<!--a class="pull-right open-panel" data-panel="#index-popup"> <i class="icon iconfont marr0 marl20 white fs08">&#xe660;</i>
			</a-->

			<a class="pull-right" href="search.php">
				<i class="icon iconfont mar0 white fs08">&#xe641;</i>
			</a>
		</header>
		<!-- 工具栏 -->
		<nav class="bar bar-tab">
			<span class="toools-bar-but tab-item external active" style="cursor:pointer;" id="shop-index" data-but-type="index">
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
			<span class="toools-bar-but tab-item " data-but-type="member" style="cursor:pointer;">
				<i class="icon iconfont">&#xe65e;</i>
				<span class="tab-label">我的</span>
			</span>
		</nav>
		<!-- 这里是页面内容区 -->
		<div class="content infinite-scroll">
			<!-- 图片轮播-->
			<div class="w100b" style="height:110px;background:#ECECEC !important;">
				<div id="index-banner" class="pos-r">
					<ul class="pad0" id="shop-advert">
						<li class="w100b">
							<a class="" href="javascript:;">
								<img class="w100b" src="/sources/images/banner-2.jpg">
							</a>
						</li>
					</ul>
					<div id="index-banners" class="pos-a" style="bottom:5px;left:50%"></div>
				</div>
			</div>
			<!-- 产品栏目-->
			<div class="card mar0">
				<div class="row no-gutter txac fs06 padt5 padb5" id="categories">
					<?php foreach(range(0,9) as $val):?>
					<div class="col-20 padb10">
					<div class="w50 h50 borrad50 marauto" style="line-height:43px;background-color:#f00;">
						<img src="http://res.zj3w.net/category/icon/2016/03/08/56deb3d7d9a4997.png" class="w50 h50 borrad50 marauto" alt="placeholder+image" />
					</div>
						<div>...</div>
					</div>
					<?php endforeach;?>
				</div>
			</div>
			<!--  热门商品展示-->
			<div class="card mar0">
				<div class="row no-gutter" id="hot-porduct">
					
					<div class="col-50" style="width:50% !important;">
						<a class="" id="hot0" href="">
							<img src="/sources/images/defaultpic.gif" class="hot-thumb w100b" onError="this.onerror=null;this.src='/sources/images/defaultpic.gif'" />
						</a>
					</div>

					<div class="col-50" style="width:50% !important;">
						
						<div class="row no-gutter">
							<div class="col-50">
								<a class="" id="hot1" href="">
									<img src="/sources/images/defaultpic.gif" class="hot-thumb w100b" onError="this.onerror=null;this.src='/sources/images/defaultpic.gif'" />
								</a>
							</div>
							<div class="col-50">
								<a class="" id="hot2" href="">
									<img src="/sources/images/defaultpic.gif" class="hot-thumb w100b" onError="this.onerror=null;this.src='/sources/images/defaultpic.gif'"/>
								</a>
							</div>
						</div>
						<div class="row no-gutter">
							<div class="col-50">
								<a class="" id="hot3" href="">
									<img src="/sources/images/defaultpic.gif" class="hot-thumb w100b" onError="this.onerror=null;this.src='/sources/images/defaultpic.gif'" />
								</a>
							</div>
							<div class="col-50">
								<a class="" id="hot4" href="">
									<img src="/sources/images/defaultpic.gif" class="hot-thumb w100b" onError="this.onerror=null;this.src='/sources/images/defaultpic.gif'"/>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- 全部商品 -->
			<div class="fs07" id="index-product">
				<div class="fs08 pad5 padt10">全部商品</div>

				<div id="list-container" class="row no-gutter">
					<?php foreach(range(0,9) as $val):?>
					<div class="col-50 bgfff bor2 bort2 bceee pad5">
							<a class="c666" href="goods.php">
								<img class="w100b" src="/sources/images/defaultpic.gif" alt="">
								<div class="c333 padl5 padr5 textove">  </div>
								<div class="padl5 padr5">
									<div class="cfa6a0b fll">￥ 0.00</div>
									<div class="flr fs06">销量 0</div>
								</div>
							</a>
					</div>
					<?php endforeach;?>
				</div>
			</div>
			<!-- 加载提示符 -->
			<div class="infinite-scroll-preloader">
				<div class="preloader"></div>
				<div class="preloader_null fs06">没有更多的商品了</div>
			</div>
		</div>


	</div>


	<!-- popup, panel 等放在这里 -->
	<div class="panel-overlay"></div>
	<!-- Left Panel with Reveal effect -->


	<div class="panel panel-left panel-reveal white fs06 pad10 bgf5f5f5" id="index-popup">
		

		<div class="content">
		  <div class="content-block-title">云兆商品平台</div>
		  <div class="list-block">
		    <ul>
		      <li><a href="javascript:void(0)" id="loginout-but" class="item-link list-button">退出登录</a></li>
		      <li><a href="#" class="item-link list-button close-panel">关闭</a></li>
		      <li><a href="#" class="item-link list-button">其他</a></li>
		    </ul>
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


<script type='text/javascript' data-main="/sources/js/app.js" src='/sources/js/require.js' charset='utf-8'></script>
</html>
