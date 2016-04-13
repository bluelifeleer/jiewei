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
		<div class="page" id="page-assess">
			<!-- 标题栏 -->
			<header class="bar bar-nav">
				<h1 class="title">评价</h1>
				<a class="pull-left external" href="order.php?order_type=4">
					<i class="icon iconfont mar0 white">&#xe64c;</i>
				</a>
				<span class="pull-right extend release" href="javascript:void(0);">
					<!-- <i class="icon iconfont mar0 white">&#xe65c;</i> -->
					<i class="icon iconfont mar0 white" style="font-size: 14px;cursor: pointer;">提交</i>
				</span>
			</header>
			<div class="content">
				<div class="card mar0 borrad0 pad5">
					<textarea id="asses-scontent" class="w100b h105 bor0 fs06" style="resize:none;"></textarea>
				</div>
				<div class="pad10">
					<div class="row no-gutter input_c padt5 padb5 padr5">
						<div class="col-33 padt5">是否显示昵称</div>
						<div class="col-33">&nbsp;</div>
						<div class="col-33 input_text">
							<label class="label-switch flr">
								<input type="checkbox" id="is_show_name" value="1">
								<div class="checkbox"></div>
							</label>
						</div>
					</div>
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
