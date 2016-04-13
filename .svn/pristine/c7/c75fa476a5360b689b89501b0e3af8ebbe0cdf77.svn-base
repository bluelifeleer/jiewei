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
		<div class="page" id="page-balance"  data-ptr-distance="30">
			<!-- 标题栏 -->
			<header class="bar bar-nav">
				<h1 class="title">我的钱包</h1>
				<a class="pull-left back" href="member.php">
					<i class="icon iconfont mar0 white fs13">&#xe61b;</i>
				</a>
				<a class="pull-right" id="recharge">
					<i class="icon iconfont mar0 white fs13">&#xe659;</i>
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
			<div class="content bgfff ">
			<!-- 默认的下拉刷新层 -->
	<!-- 		<div class="pull-to-refresh-layer">
					<div class="preloader"></div>
					<div class="pull-to-refresh-arrow"></div>
			</div> -->
				<div class="card mar0 marb10 pad10 gradient_fa6a0b txac">
					<div class="padt30 padb30">
						<div class="fs08 fw200">总金额(元)</div>
						<div class="fs20" id="sun-amount">0</div>
						<div class="fs06 mart20">总金额 = 可用账户余额 +  冻结金额 </div>
					</div>
				</div>
				<div class="row no-gutter mart10 pad10 fs08 fw200">
					<div class="col-50 pad20 borr1 bcfff">
						<a class="c666" href="consume_records_detail.php?type=all">
							<div class="fs07">可用账户余额</div>
							<div class="cfa6a0b fs12" id="cash-amount">0</div>
						</a>
					</div>
					<div class="col-50 pad20">
						<a class="c666" href="consume_records_detail.php?type=frozen">
							<div class="fs07 fw200">冻结自营货款</div>
							<div class="cfa6a0b fs12" id="frozen-amount">0</div>
						</a>
					</div>
					<div class="col-50 pad20">
						<a class="c666" href="consume_records_detail.php?type=bonus">
							<div class="fs07 fw200">累计推荐奖金</div>
							<div class="cfa6a0b fs12" id="month-bonus-amount">0</div>
						</a>
					</div>
					<div class="col-50 pad20">
						<a class="c666" href="consume_records_detail.php?type=sales">
							<div class="fs07 fw200">本店销售货款</div>
							<div class="cfa6a0b fs12" id="month-sales-amount">0</div>
						</a>
					</div>
					<div class="col-50 pad20">
						<a class="c666" href="achievement.php?type=myBonus">
							<div class="fs07 fw200">个人冻结业绩</div>
							<div class="cfa6a0b fs12" id="my-bonus-amount">0</div>
						</a>
					</div>
					<div class="col-50 pad20">
						<a class="c666" href="achievement.php?type=teamBonus">
							<div class="fs07 fw200">团队冻结业绩</div>
							<div class="cfa6a0b fs12" id="team-bonus-amount">0</div>
						</a>
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
