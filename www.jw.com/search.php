<?php
include_once('./Common/public.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>搜索商品</title>
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
		<div class="page" id="page-search">
			<!-- 标题栏 -->
			<header class="bar bar-nav">
				<h1 class="title">搜索</h1>
				<a class="pull-left back " href="index.php">
					<i class="icon iconfont mar0 white">&#xe61b;</i>
				</a>
			</header>
			<div class="bar bar-header-secondary">
				<div class="searchbar row">
					<div class="search-input col-85" >
						<input type="search" name="search" id='search' placeholder='输入关键字...'/>
					</div>
					<div id="search-btn" class=" col-15 c666"><span class="icon icon-search"></span></div>
					<div class="clear"></div>
				</div>
			</div>
			<div class="content infinite-scroll" style="top:4.4rem;" >
					<div class="list-container"></div>
					<!-- 加载提示符 -->
					<div  class="infinite-scroll-preloader external">
							<div class="preloader_null fs06">没有对应的商品！</div>
					</div>
			</div>

		</div>
	</body>
<script type="text/javascript" src="/sources/js/zepto-full.1.1.6.min.js"></script>
<script type="text/javascript" src="/sources/js/sm.min.js" charset="utf-8"></script>
<script type="text/javascript" src="/sources/js/sm-extend.min.js" charset="utf-8"></script>
<script type="text/javascript" src="/sources/js/module/public.js"></script>
<script type="text/javascript" src="/sources/js/module/jweixin-1.0.0.js"></script>
<script type='text/javascript' data-main="/sources/js/app.js" src='/sources/js/require.js' charset='utf-8'></script>
</html>
