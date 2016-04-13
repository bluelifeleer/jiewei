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
		<meta name="keyworks" content="界微科技--我的信报箱提示列表对应的信息列表" />
		<link rel="stylesheet" href="/sources/css/sm.min.css"/>
        <link rel="stylesheet" href="/sources/css/sm-extend.min.css"/>
		<link rel="stylesheet" href="/sources/css/demos.css">
		<link rel="stylesheet" href="/sources/css/add.css">
	</head>
	<body>
		<div class="page" id="page-letter-detail">
      <header class="bar bar-nav bgFA6A0B">
        <a class="pull-left back " href="letter_box.php">
					<i class="icon iconfont mar0 white">&#xe61b;</i>
				</a>
				<h1 class="title white">消息详情</h1>
				<!-- <a class="pull-right open-panel">
					<div class="mesg-box">
						<i class="icon iconfont marr0 marl10 white">&#xe605;</i>
						<span class="mesg-badge fs06">2</span>
					</div>
				</a>
				<a class="pull-right " href="search.php">
					<i class="icon iconfont mar0 white">&#xe604;</i>
				</a> -->
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
			<div class="content pull-to-refresh-content infinite-scroll" data-distance="55">
				<!-- 默认的下拉刷新层 -->
			    <div class="pull-to-refresh-layer">
			        <div class="preloader"></div>
			        <div class="pull-to-refresh-arrow"></div>
			    </div>
				<div id="msg-list-block">
					
				</div>
			    <!-- 加载提示符 -->
	          	<div class="infinite-scroll-preloader">
	              	<div class="preloader"></div>
	          	</div>
			</div>
		</div>

		<!--
		消息列表
		<ul>
			<li>
				<a href="" class="tab-item  c3D4145">
					<div class="card">
						<div class="card-badge card-badge-no"></div>
						<div class="card-content">
							<div class="card-inner">
								<div class="content-padded">
									<div class="mesg-title fs09">信息提示标题</div>
									<div class="mesg-time fs07">2015-12-10</div>
									<div class="mesg-content fs07">这是一个用纯文本的简单卡片。但卡片可以包含自己的页头，页脚，列表视图，图像，和里面的任何元素。</div>
								</div>
							</div>
						</div>
						<div class="card-footer">立即查看<span class="icon icon-right"></span></div>
					</div>
				</a>
			</li>
			<li>
				<a href="" class="tab-item  c3D4145">
				<div class="card">
					<div class="card-badge card-badge-no"></div>
						<div class="card-content">
							<div class="card-inner">
								<div class="content-padded">
									<div class="mesg-title fs09">信息提示标题</div>
									<div class="mesg-time fs07">2015-12-10</div>
									<div class="mesg-content fs07">这是一个用纯文本的简单卡片。但卡片可以包含自己的页头，页脚，列表视图，图像，和里面的任何元素。</div>
								</div>
							</div>
						</div>
						<div class="card-footer">立即查看<span class="icon icon-right"></span></div>
					</div>
				</a>
			</li>
			<li>
				<a href="" class="tab-item  c3D4145"></a>
				<div class="card">
					<div class="card-badge card-badge-no"></div>
					<div class="card-content">
						<div class="card-inner">
							<div class="content-padded">
								<div class="mesg-title fs09">信息提示标题</div>
								<div class="mesg-time fs07">2015-12-10</div>
								<div class="mesg-content fs07">这是一个用纯文本的简单卡片。但卡片可以包含自己的页头，页脚，列表视图，图像，和里面的任何元素。</div>
							</div>
						</div>
					</div>
					<div class="card-footer">立即查看<span class="icon icon-right"></span></div>
				</div>
			</li>
			<li>
				<a href="" class="tab-item  c3D4145">
					<div class="card">
						<div class="card-badge card-badge-no"></div>
						<div class="card-content">
							<div class="card-inner">
								<div class="content-padded">
									<div class="mesg-title fs09">信息提示标题</div>
									<div class="mesg-time fs07">2015-12-10</div>
									<div class="mesg-content fs07">这是一个用纯文本的简单卡片。但卡片可以包含自己的页头，页脚，列表视图，图像，和里面的任何元素。</div>
								</div>
							</div>
						</div>
						<div class="card-footer">立即查看<span class="icon icon-right"></span></div>
					</div>
				</a>
			</li>
			<li>
				<a href="" class="tab-item  c3D4145">
					<div class="card">
						<div class="card-badge card-badge-off"></div>
						<div class="card-content">
							<div class="card-inner">
								<div class="content-padded">
									<div class="mesg-title fs09">信息提示标题</div>
									<div class="mesg-time fs07">2015-12-10</div>
									<div class="mesg-content fs07">这是一个用纯文本的简单卡片。但卡片可以包含自己的页头，页脚，列表视图，图像，和里面的任何元素。</div>
								</div>
							</div>
						</div>
						<div class="card-footer">立即查看<span class="icon icon-right"></span></div>
					</div>
				</a>
			</li>
		</ul>
		-->
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
