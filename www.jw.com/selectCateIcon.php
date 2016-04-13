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
		<div class="page" id="select-cate-icon">
			<!-- 标题栏 -->
			<header class="bar bar-nav">
				<h1 class="title">选择Icon图片</h1>
				<a class="pull-left back" href="shop_category_manage.php">
					<i class="icon iconfont mar0 white">&#xe61b;</i>
				</a>
				<span class="pull-right external iconSubmit" href="javascript:void(0);">
					
					<i class="icon iconfont mar0 white " style="font-size: 14px;cursor: pointer;">提交</i>
				</span>
			</header>
			<div class="content">
				<div class="row no-gutter txac fs06 padt5 padb5">
					<div class="col-25 padb10"></div>
					<div class="col-50 padb10 selectedItem">
						<div class="w100 h100 borrad50 marauto">
							<img  src="http://res.zj3w.net/product/pictures/2016/03/08/56de9abb93b6c35.png" class="w100 h100 path borrad50 marauto" data-change="false" alt="placeholder+image" />
						</div>
						<div class="name">服装</div>
				</div>
				</div>
			   <div class="content-block-title" style="margin-top: .75rem;">选择下面的icon图标</div>
				<div class="row no-gutter txac fs06 padt5 padb5" id="cateIcon">
					<!-- <div class="col-20 padb10 iconItem">
						<div class="w50 h50 borrad50 marauto" style="cursor:pointer;">
							<img  src="http://res.zj3w.net/product/pictures/2016/03/08/56de9abb93b6c35.png" class="w50 h50 borrad50 marauto path" alt="placeholder+image" />
						</div>
						<div class="name">服装33</div>
					</div> -->
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
